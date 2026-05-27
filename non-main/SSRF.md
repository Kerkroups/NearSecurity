Server Side Request Forgery - атака, которая позволяет отправлять разного рода запросы (HTTP, DSN, FTP, etc.) от имени ресурса.  

**Типы SSRF**:  
1. Basic - ответ на запрос отображается в UI (на экране, в терминате и т.д.).
2. Blind - ответ на запрос не отображается (ответ не виден атакующему).

**SSRF to Reflected XSS**:  
Выполнить запрос на сайт, который в ответе отдаст payload с нужным Content-type (например html) для тригера XSS.  

**Expose Internal Network**:  
С помощью SSRF можно обнаружить и атаковать внутреннюю сеть и сервисы компании.  
IP для атаки:  
```
  10.0.0.0/8
  127.0.0.1/32
  172.16.0.0/12
  192.168.0.0/16
```
**Cloud Metadata retrieval**:  
У разных облачных поставщиков услуг есть специальные ссылки, при запросе на которые могут раскрываться чевствительные данные, например временные учетные данные.  


**Где можно найти SSRF**:  
- Webhooks;
- PDF генераторы;
- Document parsers;
- Link expansion;
- File upload;
- Video conversion;

**PDF генераторы**:  
Внедрение таких элементов как <iframe>, <img>, <base>, <script>, CSS url() и т.д. Конвертирование документов с такими тегами в файл PDF может спровоцировать SSRF. [https://youtu.be/o-tL9ULF0KI?si=_n8Ktjqa_rI8vYVw](https://youtu.be/o-tL9ULF0KI?si=_n8Ktjqa_rI8vYVw)

**Document parsers**:  
Эксплуатация через XXE и другие небезопасные техники чтения разных форматов, которые могут выполнять запросы по сети.  

**File Upload**:  
Вместо загрузки файла, попробовать загрузить ресурс из указанного URL. [https://hackerone.com/reports/713](https://hackerone.com/reports/713)  

**Video converting**:  
[https://youtu.be/OQBZ__L23KU?si=YPHBj_bFwzebvu9d](https://youtu.be/OQBZ__L23KU?si=YPHBj_bFwzebvu9d)  
[https://hackerone.com/reports/237381](https://hackerone.com/reports/237381)  

**Blacklist bypass**:  
1. Convert IP to HEX.
2. Convert IP to Decimal.
3. Convert IP to Octal.
4. DNS Rebinding.
5. Domain that point to local address.
6. 
