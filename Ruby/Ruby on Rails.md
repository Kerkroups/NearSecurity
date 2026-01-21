## ROUTING  

Rails router определяет URL и направляет их в действие контроллера, а также может генерировать пути и URL. Маршруты определяются в файле ```config/routes.rb```.   

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

