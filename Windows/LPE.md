## Operation:  
- **SetSecurityFile**  
- **CreateFile**  
- **Load Image**  

## Uunquoted service paths  
**Информация о сервисе**: ```sc.exe qc "ServiceName"```  
**Информация о доступах к сервису**: ```sc.exe sdshow "ServiceName"``` или ```accesschk.exe -c "ServiceName"```  
**Список всех сервисов и досупа к ним**: ```accesschk.exe -cqv *```  
**Найти все unquoted services**:  
- ```Get-CimInstance Win32_Service | Where-Object {$_.PathName -notLike '"*' -and $_.PathName -like '* *'} | Select-Object Name, DisplayName, PathName```
- ```wmic service gqt name, displayname, pathname, startmode | findstr /i "auto" | findstr /i /v "c:\windows\\" | findstr /i /v """```

**Модифицировать сервис**: ```sc.exe config "ServiceName" binPath="\"<PATH_TO_BINARY>\""```  

## Symlinks:  
Symlink может указывать на файл, директорию, объект.  
Symlink (имеет расширение .symlink) != Shortcut (имеет расширение .lnk.)  
На примере двух текстовых файлов можно увидеть отличия в содержании обычного текстового файла и shortcut (cat file1.txt и cat shortcut-file1.txt.lnk).  

**Создание симлинка (symlink)**:  
- Ссылка на директорию: ```mklink "symlink_name" "real_target"```
- Ссылка на директорию: ```New-Item -ItemType SymbolicLink -Path "C:\Path\To\Link" -Value "C:\Path\To\Target```
- Ссылка на файл: ```New-Item -ItemType SymbolicLink -Path "C:\Path\To\File.txt" -Value "C:\Path\To\Target.txt"```

**Разница между symlink и shortcut**: symlink это специальный указатель, простая ссылка на данные, программы могут обращаться по symlink. shortcut - обрабатывается ОС, программы не могут обращаться по shortcut, имеет дополнительные опции.  
**Hardlink**: указывает на данные, не на файл. Если удалить файл, то hardlink будет хранить данные.

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
