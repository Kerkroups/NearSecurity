Небезопасная проверка путей с помощью startWith:  
```
const path = resolve(query.path as string);
if (!path.startsWith(devRootDir)) {
```  

Небезопасный import():  
```
await import(/* @vite-ignore */ query.path as string)
```
RCE если используется ESM ("type":"module" или .mjs)  

