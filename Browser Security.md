## SOP  
**SOP запрещает по-умолчанию**:
- Доступ к DOM и JS объектам других origins;
- Чтение объектов при кросдоменных запросах;
- Доступ к cookies, storage или данных аутентификации из других источников (origins);
**SOP разрешает запрос но блокирует ответ**:
- Встроенный контент с помощью ```<iframe src=>```;
- Действия по ссылкам или перенаправления с window.location;
- postMessage, pixel tracking, window.name abuse;

## CORS  
**Что делает CORS?**: Когда JavaScript в браузере выполняет кроссдоменный запрос, браузер сперва отправляет запрос с заголовком "Origin". Затем целевой ресурс должен ответить с CORS заголовками, который явно разрешает запрос: ```Access-Control-Allow-Origin: домен```. Если заголовок не присутствует в ответе или заголовок содержит другой домен, браузер заблокирует доступ к ответу.  

**Два типа CORS запросов**:  
1) Simple request (простой запрос): GET/POST с простым Content-type;
2) Preflight request: если в запросе есть ползовательские заголовки, PUT/DELETE/etc., Content-type: json;

**null как Allowed Origin**: такое происходит когда:  
- Файл загружается через протокол ```file://```;
- A sandboxed iframe испольуется без "allow-same-origin";
- Расширения браузера/embedded environment тригерят запросы;

## CSP  

**Что искать при анализе CSP?**  
- "unsafe-inline" и "unsafe-eval";
- Использование "*" в "script-src";
- Отраженные скрипты от JSONP или CDN;
- Отсутствие или неправильное использование "nonce";
- CSP политики, которые ничего не блокируют или разрешают все;
- Отражненный пользовательский ввод в CSP политике;  

## SRI  
SRI - проверяет целостность third-party скриптов и защищает от компроментации CDN скрипты.  

## SANBOXING  
Sandboxing - изолирует third-party контент и ограничивает действия ```<iframe>```;  

## TRUSTED TYPES  

## COOKIES FLAGS  

## STORAGE API's    

## Browser Developer Tools  

**Setup breakpoint for all "postMessage" where "host" == \***:  
```debug(postMessage,'argument[1]=="*"');```  

**Monitor all "postMessage" events to current page**:  
```monitorEvents(window, 'message');```  

**Browser memory dump**:  создав snapshot можно исследовать память на наличие API запросов.  

**LightHouse**: снять все настройки оставив лишь "Best practices" и "Desktop".  

**Plugin for recon DOM XSS**: https://github.com/filedescriptor/untrusted-types  

## Client-side exploitation:  

**Find DOM XSS via DevTools**: https://youtu.be/CNNCCgDkt5k?si=6DkUv5WcJmBYfWI2  

**Referer leak**: https://youtu.be/uDigwNal7GQ?si=qCswM_7IlInaZO3R  
