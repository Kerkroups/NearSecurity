## Web Cache Poisoning  
Это атака на CDN, reverse proxy, кеш браузера.  Может привести к:  
- Mass XSS / Redirection;
- Session / Token leaks;
- DoS;

Как работает кеширование?  
**КЛИЕНТ** -> **CDN/REVERSE PROXY** -> **ORIGIN SERVER**  

HIT - данные из кеша;  
MISS - данные полученные от Origin и затем сохранены в кеш;  

У каждого закешированного объекта есть идентификатор (cache key). Cache key обычно является комбинацией из:  
```Schema + Host + Path + Query + [Иногда заголовки перечисленные в заголовке Vary]```. ВАЖНО!: большинство данных, которые влияют на ответ от сервера не являются составляющими Cache key. Такие данны называют Unkeyed inputs.  

**Методология поиска Web Cache Poisoning**  
1. Найти unkeyed inputs; Параметры запроса или заголовки, которые меняют ответ от сервера, но игнорируются cache key.
2. Внедрить payload в unkeyed inputs.
3. Проверить, удалось ли сохранить payload в кеше.

**Примеры unkeyed inputs**  
```
X-Forwarded-For
X-Forwarded-Host
X-Forwarded-Ip
X-Original-URL
X-Forwarded-Scheme
X-HTTP-Method-Override
X-Method-Override
X-HTTP-Method
X-Forwarded-Port
User-Agent
Cookies
Path queries: ;, %00, %2e%2e
```

**Заголовки кеширования**  

**Быстрый чек-лист**:  
- Наличие "Cache-Control: public";
- Проверить заголовок "Vary";
- Протестировать потенциальные "unkeyed inputs" на отражение в ответе сервера;
- Протестировать ответы с ошибками (400б 502);
- Протестировать различные User-Agents;
- Логировать ответы с "Age" и "Via";

**Выборочное отравление - цели User-Agent. Vary уловки.**  
Заголовок "Vary: User-Agent" означает, чтов кеше хранятся различные данные в зависимости от "User-Agent" пользователя. Это позволяет отдавать разные версии ответа сервера для отдельных технологий/клиентских групп (например, мобильные браузеры).  


