## Operation:  
- **SetSecurityFile**  
- **CreateFile**  
- **Load Image**  

## Services  
**Информация о сервисе**: ```sc.exe qc "ServiceName"```  
**Информация о доступах к сервису**: ```sc.exe sdshow "ServiceName"``` или ```accesschk.exe -c "ServiceName"```  
**Список всех сервисов и досупа к ним**: ```accesschk.exe -cqv *```  
**Список всех запущенных сервисов**: ```Get-Service | Where-Object {$_.Status -eq "Running"}```  
**Найти все unquoted services**:  
- ```Get-CimInstance Win32_Service | Where-Object {$_.PathName -notLike '"*' -and $_.PathName -like '* *'} | Select-Object Name, DisplayName, PathName```
- ```wmic service gqt name, displayname, pathname, startmode | findstr /i "auto" | findstr /i /v "c:\windows\\" | findstr /i /v """```

**Вывести результат команды ./accesschk.exe для каждого сервиса где есть строка "RW\s+NT AUTHORITY\\Authenticated Users"**:  
```
Get-Service |
Where-Object {$_.Status -eq "Running"} |
ForEach-Object {
    $service = $_
    $output = .\accesschk.exe -accepteula -c $service.Name 2>$null

    $match = $output | Select-String 'RW\s+NT AUTHORITY\\Authenticated Users'

    if ($match) {
        Write-Host "Found service: $($service.Name)" -ForegroundColor Green
        $match.Line
    }
}
```

**Модифицировать сервис**: ```sc.exe config "ServiceName" binPath="\"<PATH_TO_BINARY>\""```  

**Список значений доступов для сервисов**: https://learn.microsoft.com/en-us/windows/win32/services/service-security-and-access-rights  

## Symlinks:  
Symlink может указывает на файл (объект).
Symlink (имеет расширение .symlink) != Shortcut (имеет расширение .lnk.)  
На примере двух текстовых файлов можно увидеть отличия в содержании обычного текстового файла и shortcut (cat file1.txt и cat shortcut-file1.txt.lnk).  

**Создание симлинка (symlink)**: https://learn.microsoft.com/en-us/windows-server/administration/windows-commands/mklink  
- Ссылка на директорию: ```mklink "symlink_name" "real_target"```
- Ссылка на директорию: ```New-Item -ItemType SymbolicLink -Path "C:\Path\To\Link" -Value "C:\Path\To\Target```
- Ссылка на файл: ```New-Item -ItemType SymbolicLink -Path "C:\Path\To\File.txt" -Value "C:\Path\To\Target.txt"```

**Разница между symlink и shortcut**: symlink это специальный указатель, простая ссылка на данные, программы могут обращаться по symlink. shortcut - обрабатывается ОС, программы не могут обращаться по shortcut, имеет дополнительные опции.  
**Hardlink**: указывает на данные, не на файл. Если удалить файл, то hardlink будет хранить данные.  
**Junction**: может указывать на диск, директорию.  

**Windows data stream**: https://learn.microsoft.com/en-us/openspecs/windows_protocols/ms-fscc/c54dec26-1551-4d3a-a0ea-4fa40f848eb3  

## Установщики и механизмы восстановления:  
Суть атаки в том, что установщик может запускать файлы с повышеными правами, и если атакующий сможет контролировать путь/файл откуда установщик берет файлы или обращается, то установщик выплнит код атакующего с повышеными привилегиями.  
После установки ПО, программа для восстановления создается в "C:\Windows\Installer" и имеет рандомное имя, т.е. следует смотреть на производителя ПО. Далее запускаем процесс восстановления и смотри какие пути и файлы запрашиваются от SYSTEM. Изучаем доступы к найдем файла и реализуем эксплуатацию.  

Нужно отслеживать поведение msiexec.exe.  
Для анализа .msi используем orca.exe.  

**Запуск механизма восстановления**: ```msiexec.exe /fa C:\Windows\Installer\[XXXXX].msi```  

**CTF-вариант**:
- InstallAlwaysElevated

## Arbitrary File Manipulation:  
Нужно помнить, что у стандартного пользователя есть право на запись в директории C:\Windows\Temp и C:\ProgramData.  
Некоторые сервисы могут выполнять неправильную последовательность поиска файла или директории, что может привести к уязвимости.  

**TOCTOU**: вариант race condition атаки, который часто используется в LPE. Идея в том, что если приложение, к примеру, сначала проверяет файл -> удаляет -> записывает в логи, то в такой цепи атакующий между всем этими стадиями может заменить удаляемы файл на symlinc/junction. Так как у стандартного пользователя нет прав для содания symlinc, можно обойти это ограничение с помощью комбинации: junction -> Object Manager symlink (\RPC CONTROL), что дает нам pseudo-symlink.  

Object Manager symlink (\RPC CONTROL): [CreateMountPoint](https://github.com/googleprojectzero/symboliclink-testing-tools/tree/main/CreateMountPoint)  
junction: [CreateSymlink](https://github.com/googleprojectzero/symboliclink-testing-tools/tree/main/CreateSymlink)  
SetOplock: [SetOpLock](https://github.com/googleprojectzero/symboliclink-testing-tools/tree/main/SetOpLock)

**Действия**:  пример Arbitrary File Deletion
1. Перед эксплуатацией нужно создать oplock для файла куда будут вноситься логи (для того, чтобы программа остановилась и не пошла по циклу дальше): SetOpLock.exe <path_to_file>
2. Удалить директорию
3. Создать директорию
4. Создать точку монтирования: CreateMountPoint.exe <путь_к_созданной_директории> "\RPC Control"
5. Создать symlink на удаляемый файл: CreateSymlink.exe "<имя_symlink>" "<удаляемый_файл>"
6. Продолжаем выполнение программы.

**Vulnerable pattern for inserting symlink/hardlink/junction**:  
Множественные операции над одним и тем же файлом. Выполняется операция CreateFile дважды.  
```
CreateFile
CloseFile
<-------- здесь можно подменить файл
CreateFile
WriteFile
```
**Attack File DACL**:  
- GetFileSecurity
- SetFileSecurity

**ProcMon filters**:  
**Column**: User, **Relation**: is, **Value**: NT AUTHORITY\SYSTEM  
**Column**: Path, **Relation**: contains, **Value**: C:\Windows\Temp  
**Column**: Path, **Relation**: contains, **Value**: C:\ProgramData  
**Column**: Path, **Relation**: contains, **Value**: C:\Users\<username>  
**Column**: Operation, **Relation**: is, **Value**: CreateFile  
**Column**: Operation, **Relation**: is, **Value**: WriteFile  
**Column**: Operation, **Relation**: is, **Value**: QueryBasicInformationFile  

## DLL Hijacking:  

Реверсим программу, ищем имплементацию функции LoadLibrary (нам нужно понимать порядок загрузки библиотек).  

## Scheduled tasks  
Анализ планировщиков событый на уязвимости доступа.  

## Named Pipes  

**pipe** - это блок разделяемой памяти, который используется процессом для коммуникации и обмена данными.  
**Named Pipes** - в Windows это механизм который предоставляет возможность двум независимым процессам обмениваться данными, даже если процессы расположенны в разных сетях. Это очень похоже на клиент/серверную архитектуру. named pipe server открывает соединение с предопределенным именем и затем named pipe client подключается к этой pipe по известному имени. После установления соединения может начаться обмен данными.  

**Паттерн named pipe**: ```\\.\pipe\pipe_name```  

По умолчанию named pipes коммуницируют по протоколу SMB.  

**Вывести список named pipes**: ```((Get-ChildItem \\.pipe\).name)[-1..-5]```  

**Атаки на named piped**:  
- Token Impersonation


## Additional ProcMon filters:  
**Column**: User, **Relation**: contains, **Value**: SYSTEM  
**Column**: Result, **Relation**: is, **Action**: include, **Value**: NAME INVALID  
**Column**: Operation, **Relation**: is, **Action**: include, **Value**: CreateFile  
**Column**: Path, **Relation**: ends with, **Action**: include, **Value**: dll  
**Column**: Result, **Relation**: is, **Action**: include, **Value**: PATH NOT FOUND  
**Column**: Result, **Relation**: is, **Action**: include, **Value**: NAME NOT FOUND  

## Notes:  
- Not every "CreateFile" call leads to load placed DLL. There are many calls that just checks for attributes, permissions, if the file exist and so on.
- Look for "LoadLibraryA" and "LoadLibraryExW" calls. This calls used to load DLL's or EXE files (dynamically load external code modules into running application's memory at runtime).
- Save ProcMon output to CSV file.  

## Basic Windows commands:
- icacls

## Windows Error codes:  
"Access Denied": 0x80070005  
"File Not Found": 0x80070002  
"Driver package filed signature verification": 0xe000022f  

## Basic questions:  
- Какие файлы создаюся?
- Где SYSTEM пишет?
- Кто запускается от SYSTEM?
- Какие пути используются?
- Что можно подменить?
- Какие ACL для потенциальных файлов/путей?
