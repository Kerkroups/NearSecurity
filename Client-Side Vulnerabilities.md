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

## Client-side path traversal  

## Client-side template injection  
**Шаблоны**:  
```
res.send(`<h1>${req.query.name}</h1>`)

const name = new URLSearchParams(location.search).get('name');
document.getElementBy...innerHtml  = `Hello, ${name}`;
```
