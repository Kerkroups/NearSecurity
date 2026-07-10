## DOCX, PPTX, XLSX

Open XML fioramt file contains:
  - Document properties;
  - Custom Defined XML;
  - Charts;
  - Embedded Code/Macros;
  - Image, Video, Sound files;
  - WordML/SpreadsheetML, etc.;
  - Comments;

Основная часть документа XML содержиться в:  
  - /word/document.xml
  - /ppt/presentaion.xml
  - /xl/workbook.xml

**Обработка XML в браузере**: https://developer.mozilla.org/ru/docs/Web/XML/Guides/Parsing_and_serializing_XML  

**Пример простого документа в XML**:  
```
<?xml version="1.0"?>

<!-- Comment -->

<PRODUCTS>
     <PRODUCT>
          <TITLE> Product #1 </TITLE>
          <PRICE> 10.00 </PRICE>
     </PRODUCT>
     <PRODUCT>
          <TITLE> Product #2 </TITLE>
          <PRICE> 20.00 </PRICE>
     </PRODUCT>
</PRODUCTS>
```
Для использования символов кириллицы нужно использовать такой заголовок:  
```
 <?xml version="1.0" encoding="windows-1251"?>
```
Если для XML документа существует файл CSS, который задает отображение каждого элемента XML, то его нужно добавить в конце XML документа:  
```
 <?xml-stylesheet type="text/css" href="Sample.css"?>
```
В результате при открытии XML-документа в браузере он будет отображён в соответствии с инструкциями, записанными в таблице стилей.  

**Атрибуты элементов**:  
 В начальный тэг элемента либо в тэг пустого элемента вы можете включить одно или несколько описаний атрибутов. Описание атрибута представляет собой пару имя - значение, например:  
```
 <PRICE type="retail">$10.55</PRICE> 
```
ИЛИ  
```
 <PRICE type="retail" /> 
```
Если XML-документ отображается с помощью таблицы стилей CSS, браузер не выводит атрибуты и их значения. Доступ к атрибутам и их значениям даёт отображение XML-документа с использованием XSL-таблицы, связывания данных или сценария.
