## Начало:  
1. Список всех клиентов и служб подключенных в данный момент к шине сообщений D-Bus: ```busctl list```
2. Покажет список элементов службы: ```busctl tree [package_name]```
3. Покажет интерфейсы, методы, свойства и сигналы: ```busctl introspect org.freedesktop.login1 <element_name>```
4. Вызво метода: ```busctl call <service> <path> <interface> <method> <arguments>```
5. Просмотр трафика: ```busctl monitor <srvice>```
6. Отобразить информацию о процессе, учетные данные, контект безопасности сервиса: ```busctl status <service|PID>```

**Примеры вызова методов**:  
```
gdbus call --[BUS] --dest [DEST] --object-path [PATH] --method [INTERFACE].[METHOD] [ARGUMENTS]
gdbus call --system --dest org.freedesktop.UDisks2 --object-path /org/freedesktop/UDisks2/Manager --method org.freedesktop.UDisks2.Manager.CanCheck ext4
gdbus call --system --dest org.example.Service --object-path /org/example/Object --method org.example.Service.Foo "test" true 123

busctl call [BUS] [DESTINATION] [OBJECT_PATH] [INTERFACE] [METHOD] [SIGNATURE] [ARGUMENTS]
busctl --user call org.freedesktop.Notifications /org/freedesktop/Notifications org.freedesktop.Notifications Notify susssasa{sv}i "my_app" 0 "dialog-information" "Hello" "World" 0 0 -1
```

**Сигнатуры методов**:  
s - string  
b - bool  
i - int32  
u - uint32   
x - int64  
t - uint64  
o - object path  
g - signature  
v - variant  
as - array of strings  
ao - array of objects  
a{sv} - dict<string, variant>  
