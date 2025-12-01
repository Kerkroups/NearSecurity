## Browser Developer Tools  

**Setup breakpoint for all "postMessage" where "host" == \***:  
```debug(postMessage,'argument[1]=="*"');```  

**Monitor all "postMessage" events to current page**:  
```monitorEvents(window, 'message');```  
