## CI/CD configuration process
Let's begin with security modeling in CI/CD, since this is often a top priority. In most cases, the product has already been in development for some time and has multiple releases.
⚠️ WARNING: The allow_failure: true option that will used in examples is used here to prevent jobs from failing and stopping the pipeline. Since we are building everything from scratch, we first need to understand which stages are likely to fail and how to handle them.
In future articles, we will discuss more secure and production-ready approaches. For now, we will use this (arguably controversial) approach.
Secrets Detection stage
Let's start with detecting sensitive data leaks by adding the following configuration to .gitlab-ci.yml:
```
gitleaks:
   stage: secret-detection-scan
   image: 
     name: zricethezav/gitleaks
     entrypoint: [""]
   variables:
     GIT_DEPTH: 50
   script:
     - gitleaks version
     - gitleaks detect --source=$CI_PROJECT_DIR --redact --no-banner --report-format json --report-path gitleaks-report.json --exit-code 1
   allow_failure: true
   after_script:
     - test -f gitleaks-report.json || echo '{}' > gitleaks-report.json
   artifacts:
     when: always
     paths:
       - gitleaks-report.json
```
If secrets are detected, the pipeline job will complete with a Warning status and generate a JSON report that can be viewed in the browser or downloaded.
This setup covers both the first and second points of our plan, as Gitleaks scans not only current changes but also historical commits.  

## Dependency Scanning & SBOM stage
Next, we implement dependency scanning. Depending on the project, different approaches may be required. For example, in a typical PHP + JavaScript project, we need to scan dependencies used by the application.
For JavaScript, possible tools include:
 - npm audit
 - OWASP Dependency-Check
 - Semgrep

To run npm audit, both package.json and package-lock.json are required. In short, package-lock.json contains the full dependency tree, including transitive dependencies. Add the following job:  
```
security_scan:
  stage: dependency-scan
  image: node:latest
  before_script:
    - npm install --global @cyclonedx/cyclonedx-npm
  script:
    - npm install
    - npm audit --json > dependencies-report.json || true
    - cyclonedx-npm --output-format JSON --output-file project-sbom.json
  allow_failure: true
  artifacts:
     when: always
     paths:
       - dependencies-report.json
       - project-sbom.json
```

The job will likely return a Warning because vulnerabilities are commonly found. The output includes:  
 - dependencies-report.json - vulnerability report
 - project-sbom.json - SBOM file

At this stage, an SBOM file has been generated for the npm dependencies used by the project. What is the SBOM? This is an abbreviation for Software Bill of Materials and it used for:
 - inventory of dependencies
 - useful for compliance
 - helps mitigate supply chain attacks by identifying where vulnerable components are used.

## Static Scanning (SAST) stage
For SAST, we will use Semgrep (via Docker, not the built-in GitLab integration).
Semgrep provides a convenient dashboard for vulnerability analysis. To upload results to semgrep dashboard we need to create SEMGREP_APP_TOKEN and place it to project variables.  
```
semgrep-sast:
   stage: sast-semgrep-scan
   image: semgrep/semgrep
   script: 
     - SEMGREP_APP_TOKEN=$SEMGREP_APP_TOKEN semgrep ci --json --json-output=sast-report.json
   allow_failure: true

   rules:
     - if: $CI_PIPELINE_SOURCE == "web"
     - if: $CI_MERGE_REQUEST_IID
     - if: $CI_COMMIT_BRANCH == $CI_DEFAULT_BRANCH
   artifacts:
     when: always
     paths:
       - sast-report.json
```

## Container Scanning (Trivy) stage  
We also integrate Trivy for scanning Docker images. In our approach, we intend to use a pre-built Docker image to scan for OS vulnerabilities, language-specific dependencies/package vulnerabilities, misconfiguration and secrets and generate an SBOM file for OS/Language-specific packages/dependencies used in docker image.  
```
stages:
  - docker-image-build
  - docker-image-scan

build:
  image:
    name: moby/buildkit:rootless
    entrypoint: [""]
  stage: docker-image-build
  variables:
    IMAGE_NAME: dvwa
  script:
      - buildctl-daemonless.sh build --frontend dockerfile.v0 --local context=. --local dockerfile=. --output type=docker,name=$IMAGE_NAME,dest=image.tar
  artifacts:
    paths:
      - image.tar
    expire_in: 1h

trivy:
  stage: docker-image-scan
  image: 
    name: aquasec/trivy:0.69.3
    entrypoint: [""]
  dependencies: 
    - docker-image-build
  script:
    - trivy --version
    - ls -l /usr/local/bin
# We used the "--exit-code 0" flag in the example to prevent the job from failing. 
# In a more realistic scenario, options such as "--exit-code 1 --severity HIGH,CRITICAL" would be used.
# Scan docker image for vulnerabilities and secrets.
    - trivy image --input image.tar --scanners vuln,secret --exit-code 0 -o gl-container-image-scanning-report.json
# Generate SBOM files for docker image OS and Language-specific package/dependencies.
    - trivy image --input image.tar --format cyclonedx --output sbom-result.json
  cache:
    paths:
      - .trivycache/
  artifacts:
    paths:
      - gl-container-image-scanning-report.json
      - sbom-result.json
```
What we just did:  
1. We build docker image with BuildKit and pack it to TAR archive.
2. Scan docker image for vulnerabilities and secrets.
3. Generate SBOM files for docker image.

Overall, Trivy offers universal scanning capabilities; for example, in addition to Docker images, it can also search for secrets in project files located on the file system (on disk), scan for misconfiguration in configuration files such as Dockerfile, Kubernetes, Terraform, CloudFormation and others, perform checks for compliance with CIS standards, and other container-specific checks.
