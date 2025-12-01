## Browser Developer Tools  

**Setup breakpoint for all "postMessage" where "host" == \***:  
```debug(postMessage,'argument[1]=="*"');```  

**Monitor all "postMessage" events to current page**:  
```monitorEvents(window, 'message');```  

**Browser memory dump**:  создав snapshot можно исследовать память на наличие API запросов.  

**LightHouse**: снять все настройки оставив лишь "Best practices" и "Desktop".  
