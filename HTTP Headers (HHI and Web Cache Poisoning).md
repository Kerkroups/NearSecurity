## Test for Host header injection and Web Cache poisoning  
```
X-Forwarded-Host
X-Original-URL
X-Host
X-Rewrite-URL
X-Forwarded-Scheme
X-Forwarded-For
X-Forwarded-Server
X-Real-Ip
```
Potential unkeyed headers:  
 - Request headers above;
 - User-Agent;
 - Cookies;
 - Path queries (;,%00,%2e%2e)
