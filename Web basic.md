## Анатомия URL:  
```schema://login:password@address:8080/path/to/resource?parameter=value#fragment```  

**schema**: http://, ftp://, etc.;  
**pseudo-URLs**: data:, javascript:, etc.;  

[https://www.rfc-editor.org/rfc/rfc1738.html](https://www.rfc-editor.org/rfc/rfc1738.html):  
Scheme names consist of a sequence of characters. The lower case letters "a"--"z", digits, and the characters plus ("+"), period ("."), and hyphen ("-") are allowed. For resiliency, programs interpreting URLs should treat upper case letters as equivalent to 
lower case in scheme names (e.g., allow "HTTP" as well as "http").

[https://www.rfc-editor.org/rfc/rfc1630.html](https://www.rfc-editor.org/rfc/rfc1630.html): зарезервированные символы в URL.  

Адресс может быть представлен в разных форматах, напрмер:
```
http://127.0.0.1
http://0x7f.1
http://017700000001/
```  

Как браузер парсит URL:  
```http://example.com&gibberish%3D1234@10.0.0.1/``` выполнит подключение к 10.0.0.1
```http://example.com/@coredump.cx/``` выполнит подключение к example.com  
