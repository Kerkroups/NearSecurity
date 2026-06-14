## Начало:  
1. Список всех клиентов и служб подключенных в данный момент к шине сообщений D-Bus: ```busctl list```
2. Покажет список элементов службы: ```busctl tree [package_name]```
3. Покажет интерфейсы, методы, свойства и сигналы: ```busctl introspect org.freedesktop.login1```
4. Вызво метода: ```busctl call <service> <path> <interface> <property>```
5. Просмотр трафика: ```busctl monitor <srvice>```
6. Отобразить информацию о процессе, учетные данные, контект безопасности сервиса: ```busctl status <service|PID>```

