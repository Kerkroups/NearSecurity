ТАК КАК ДОКУМЕНТАЦИЯ ПО CodeQL ПОЛНЕЙШЕЕ ГОВНО, ТО ЗДЕСЬ Я БУДУ ОПИСЫВАТЬ ПРОЦЕСС УСТАНОВКИ, КОНФИГУРАЦИИ И СОЗДАНИЮ ЗАПРОСОВ ИСХОДЯ ИЗ СОБСТВЕННОГО ОПЫТА!  

## УСТАНОВКА:  
Варианты установки:  
1. Расширение VSCode;
2. Бинарник;

## ПОДДЕРЖИВАЕМЫЕ ЯЗЫКИ ПРОГРАММИРОВАНИЯ:  
При выборе проекта нужно ориентироваться на поддерживаемые CodeQL языками программирования: https://codeql.github.com/docs/codeql-overview/supported-languages-and-frameworks/  

## СОЗДАНИЕ БД  
1. Нам все равно потребуется наличие бинарника, поэтому качаем [бинарник](https://github.com/github/codeql-cli-binaries); бинарник нужно добавить в PATH;
2. Скачиваем проект над которым будем выполнять статический анализ;
3. В директории проекта создаем директорию с названием databases;
4. Создаем БД: ``` &'D:\Program Files\codeql\codeql.exe' database create <database name> --language=python --source-root=D:\Bugbounty\<project folder>\<project code folder>```
5. В расширении загрузить созданную БД;
6. Queries -> Create example query;
