Для аутентификации используется "Devise" gem.  
Установка:  
1. Добавляем в Gemfile: gem 'device'
2. Выполняем команду: ```bundle install```.
3. Выполняем команду для генерации файлов конфигурации: ```rails generate devise:install```.

Файлы конфигурации будут находиться в **config/environments/**  
После действий выше нужно создать **model**: ```rails generate devise USER```, где USER это имя класса, который имплементирует аутентификацию. После, нужно выплднить: ```rake db:migrate```.  

Для контроллера аутентификации используется: ```before_action: authenticate_user!```.  
Для  проверки пользователя, залогинен ли он (signed in), используется такой helper: ```user_signed_in?```.  
Для распознавания залогиненного пользователя используется такой helper: ```user_session```.  

## HAS_SECURE_PASSWORD  
Создание модели:  
```rails generate model USer email: string password_digest: string```.  
Добавить has_secure_password модуль в модуль User: ```class User < ActiveRecord::Base has_secure_password end```.  
Теперь можем создавать пользователей с паролем.  
Метод верификации пароля: ```user.authenticate('somepassword')```.  
