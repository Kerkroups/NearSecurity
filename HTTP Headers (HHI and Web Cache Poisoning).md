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
X-HTTP-Method-Override
X-Method-Override
X-HTTP-Method
X-Forwarded-Port
```
Potential unkeyed headers:  
 - Request headers above;
 - User-Agent;
 - Cookies;
 - Path queries (;,%00,%2e%2e)

## Playbook
1) Найти **unkeyed inputs**: такие параметры запроса или заголовков, которые меняют ответ от сервера, но игнорируются **cache key**.
2) Внедрить payload в unkeyed inputs.
3) Проверить, удалось ли сохранить payload в кеше.

## Заголовки кеширования  
 - **Cache-Control**: определяет правила кеширования: public, max-age, no-cache, etc.  
 - **Vary**: отображает экстра заголовки добавляемые в cache key, например ```Vary: User-Agent```.  
 - **Age**: отображает время жизни дагнных в кеше.
 - **X-Cache / CF-Cache-Status**: отображает статус кеширования, HIT/MISS.
 - **Via / X-Served-By**: отображает технологию кеширования.
