## DOM CLOBBERING  

## DOM XSS  
**Common sources**:  
```
location.search
location.href
location.hash
document.referrer
window.name
localStorage
sessionStorage
postMessage
```

**Dangerous sinks**:  
```
innerHtml
outerHtml
document.write()
document.writeln()
eval()
Function()
setTimeout()
setInterval()
location.href = userinput
setAttribute() //когда устанавливается для event handler
ng-bind-html //Angular
$scetrustAsHtml() //Angular
dangerouslySetInnerHTML //React
v-html //Vue.js
```

## postMessage attacks

## Prototype pollution  
Prototype pollution позволяет атакующему переопределить или добавить свойства в объект прототип (зачастую это Object.prototype), с момощью специальных ключей ```__proto__```, ```constructor``` или ```prototype```. Соответственно, мы должны понимать, что логика атаки заключается в том, что клиент передает данные, которые потом попадают в существующий объект или новый объект. Почти все объекты наследуются от Object.prototype, кроме этого объекта могут быть ситуации, когда наследование происходит от пользовательского объекта. С использованием специальных ключевых слов, мы можем попытаться передать данные в функции копирования/создания/модификации объекта, которые в последствии модифицируют наследуемый объект прототип.  

**Unfase functions**:  
```
Object.assign()
```

**Malicious keys**:  
```
__proto__
constructor.prototype
prototype
```  

## Client-side path traversal  

## Client-side template injection  
**Шаблоны**:  
```
res.send(`<h1>${req.query.name}</h1>`)

const name = new URLSearchParams(location.search).get('name');
document.getElementBy...innerHtml  = `Hello, ${name}`;
```  

## WAF Evasion / JS Expression:  
```
{} // Object
{}.toString // Object function
{}.toString.constructor // Function constructor
{}.toString.constructor('js here') // A function dynamically constructed from string
{}.toString.constructor('js here')() // Call function

![]+[] // False
(![]+[]).constructor // The string constructor
(![]+[]).constructor.formCharCode // The fromCharCode method
(![]+[]).constructor.formCharCode(97,108,101,110,116,46,100,111,10997,105,110,41) // "alert(document.domain)"
```  

## CORS:  

**Условия для атаки**:
1. ACAO не валидируется
2. ACAC: true

Для ACAO: * атака не сработает так как браузер не отсылает cookie.  

**null origin payload**:
```
<iframe src="data:text/html,<payload>"></iframe>
```

## WebSockets:  

SOP не работает для браузера:  
1. Чтение от вебсокета с другого домена;
2. Запись в вебсокет другого домена;

**null origin payload**:
```
<iframe src="data:text/html,<script>const socket = new WebSocket('wss://example.com')</script>"></iframe>
```

Заголовок Origin должен проверяться на стадии handshake.  
