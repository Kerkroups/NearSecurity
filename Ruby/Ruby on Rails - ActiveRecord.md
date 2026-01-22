ActiveRecord это часть Model-View-Controller и является частью Model, которая отвечает за представление данных и бизнес логику. Active Record помогает создавать и использовать объекты Ruby, атрибуты которых требуют постоянного хранения в базе данных.  

**Callbacks**  
Callback (обратный вызов) — это метод, который вызывается в определенные моменты жизненного цикла объекта (непосредственно перед или после создания, удаления, обновления, проверки, сохранения или загрузки из базы данных).  
```
class Listing < ApplicationRecord
  after_create :set_expiry_date
  private
  def set_expiry_date
    expiry_date = Date.today + 30.days
    self.update_column(:expires_on, expiry_date)
  end
end
```
Callback методы:
 - Creating an Object: before_validation, after_validation, before_save, around_save, before_create, around_create, after_create, after_save, after_commit/after_rollback;
 - Updating an Object: before_validation, after_validation, before_save, around_save, before_update, around_update, after_update, after_save, after_commit/after_rollback;
 - Destroying an Object: before_destroy, around_destroy, after_destroy, after_commit/after_rollback;

Простой пример создания model: класс User наследует все методы ActiveRecord.  
```
class User < ActiveRecord::Base
end
```

Файлы model хранятся в пути ```app/models/```.  

