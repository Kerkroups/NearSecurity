
1. Устанавливаем необходимые для проекта модули PHP;
2. Некотороые модули уже предустановленны, но не активлы, для их активации нужно их раскомментировать в файле ```/etc/php/8.5/apache2/php.ini```;
3. Разархивируем проект в ```/var/www/html/``` директорию;
4. Выполняем ```sudo chown www-data:www-data -R /var/www/html/project_name && chmod 755 -R /var/www/html/project_name```;
5. Создаем конфиг для apache2 в ```/etc/apache2/sites-available/project_name.conf```;
6. Выполняем ```sudo a2ensite project_name.conf```;
7. Выполняем ```sudo systemctl reload apache2```;

