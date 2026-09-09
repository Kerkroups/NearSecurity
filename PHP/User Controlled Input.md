**$_SERVER**  
**$_GET**  
**$_POST**  
**$_FILES**  
**$_COOKIE**  
**$_REQUEST**  
**php://input**  

**apache_request_headers()**: https://www.php.net/manual/en/function.apache-request-headers.php  
**getallheaders()**: https://www.php.net/manual/en/function.getallheaders.php  

## LARAVEL:  

**Поиск маршрутизации**: пример с POST  
```
Route::post('/path', [UserClass::class, 'test'])
```
**Обработка запроса**:  
```
namespace App\Http\Controllers;
use Illuminame\Http\Request;

class UserClass extends Controller {
  function test(Request $request) {
    return $request->input('parameter'); 
  }
}
```
$request->method(): используемый HTTP метод (GET, POST, etc.);  
$request->only('parameter'): использовать только определенный параметр;  
$request->only(['parameter1', 'parameter2']): использовать массив определенных параметров;  
$request->except('parameter'): исключить параметр из результата;  
$request->input('parameter'): исполльзовать заданный параметр;
$request->parameter: еще один вариант обращения к данным запроса;  
$request->has('parameter'): проверить, существует ли параметр с именем, если существует вернет 1;  
$request->input('parameter', "default value"): если значение параметра не переданно использовать значение по умолчанию;  

**Дополнительные ресурсы**  
https://medium.com/@anishregmi19/laravel-request-handling-http-input-in-modern-apps-a1bb3f8a52f1  
https://laravel.com/framework/docs/requests  

