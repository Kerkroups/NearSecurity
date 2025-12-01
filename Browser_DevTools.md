## Browser Developer Tools  

**Setup breakpoint for all "postMessage" where "host" == \***:  
```debug(postMessage,'argument[1]=="*"');```  

**Monitor all "postMessage" events to current page**:  
```monitorEvents(window, 'message');```  

**Browser memory dump**:  создав snapshot можно исследовать память на наличие API запросов.  

**LightHouse**: снять все настройки оставив лишь "Best practices" и "Desktop".  

**Plugin for recon DOM XSS**: https://github.com/filedescriptor/untrusted-types  

## Client-side exploitation:  

**Find DOM XSS via DevTools**: https://youtu.be/CNNCCgDkt5k?si=6DkUv5WcJmBYfWI2  

**Referer leak**: https://youtu.be/uDigwNal7GQ?si=qCswM_7IlInaZO3R  
