## Docker  
1. Check for credentials in image
2. Check for CVE in OS dependencies

## AWS  
1. Check for public EBS
2. Check for publick AMI
3. Check for public/misconfigured S3 buckets

## Git  
1. Look for credentials in .git folder
2. Search for .pack files
3. Search for other sensitive data in .git
4. Check for misconfiguration in .gitlab-ci.yml file

**Github actions**:  
Где искать? ".github/workflows/" - список workflows в которых могут использоваться Actions.  
Для чего нужны Actions? - запускает действия при определенных событиях. Actions задаются в параметре "uses".  
Список событий: [https://docs.github.com/en/actions/reference/workflows-and-actions/events-that-trigger-workflows](https://docs.github.com/en/actions/reference/workflows-and-actions/events-that-trigger-workflows)  
- Анализ кода Actions [https://codeql.github.com/codeql-query-help/actions/](https://codeql.github.com/codeql-query-help/actions/)

