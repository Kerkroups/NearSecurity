## Dangerous functions that lead to RCE:  
```
eval,system,exec,spawn,open,Process.exec,Process.spawn,IO.binread,IO.binwrite,IO.foreach,IO.popen,IO.read,IO.readlines,IO.write, yaml.load
```

## XSS:
```html_safe```

## CSRF:  
```skip_before_action :verify_authenticity_token```  

## SQL:  
```.where, sum()```  

## MASS ASSIGNMENT:  
Pattern:
```User.create(params[:user])```  
Defence: нужно явно указать список разрешенных параметров.    
```params.require(:user).permit(:name, :email)```  
