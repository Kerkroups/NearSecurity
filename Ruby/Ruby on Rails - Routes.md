## ROUTING  

Rails router определяет URL и направляет их в действие контроллера, а также может генерировать пути и URL. Маршруты определяются в файле ```config/routes.rb```. Методы ```resources``` или ```resource``` используются для создания груп или взаимосвязанных маршрутов.  

Пример ```config/routes.rb```:
```
get '/users', to: 'users#index'
post '/users', to: 'users#create'
```
Имена действий отображаются после символа # в параметре **to** выше. Методы с такими же именами должны быть определены в app/controllers/users_controller.rb следующим образом:  
```
class UsersController < ApplicationController
  def index
  end
  def create
  end
# continue with all the other methods...
end
```
Действи можно ограничить используя ключевые слова ```only``` и ```except```:  
```
resources :users, only:[:show]
resources :users, except: [:show, :index]
```

Маршруты приложения можно посмотреть командой: ```rake routes``` или ```rails routes```. Можно выполнять поиск по маршрутам с помощью опции -g. Это покажет любой маршрут, который частично соответствует имени вспомогательного метода, пути URL или HTTP-глаголу. Например:  
```
rake routes -g new_user # Matches helper method
rake routes -g POST # Matches HTTP Verb POST
```
Дополнительно: если rails сервер запущен в development mode, то все маршруты будут доступны по адресу ```<hostname>/rails/info/routes```.  

**ОГРАНИЧЕНИЯ**  
Мы можем фильтровать маршруты используя ограничения, например: ограничение на основе запроса, позволяющее только определенному IP-адресу получить доступ к маршруту:  
```
constraints(ip: /127\.0\.0\.1$/) do
  get 'route', to: "controller#action"
end
```

**ГРУПИРОВАНИЕ МАРШРУТОВ**  
Rails предоставляет несколько путей для организации маршрутов.  

 - Организация по URL:  
```
scope 'admin' do
  get 'dashboard', to: 'administration#dashboard'
  resources 'employees'
end
```  
 - Организация по module:  
```
scope module: :admin do
  get 'dashboard', to: 'administration#dashboard'
end
```
module ищет файлы контроллера в подпапке с указанным именем. Мы можем переименовать префикс помощников пути, добавив параметр as, например:  
```
scope 'admin', as: :administration do
  get 'dashboard'
end
```
Также можно использовать метод ```namespace```:  
```
namespace :admin do
end
```
Эквивалент:  
```
scope 'admin', module: :admin, as: :admin
```

 - Огранизация по контроллеру:
```
scope controller: :management do
  get 'dashboard'
  get 'performance'
end
```
Код выше сгенерирует такие маршруты:  
```
get '/dashboard', to: 'management#dashboard
get '/performance', to: 'management#performance'
```
- Shallow Nesting:
// TODO
