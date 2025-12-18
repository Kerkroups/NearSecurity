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
