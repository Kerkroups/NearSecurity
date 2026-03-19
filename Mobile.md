## GET APK FROM DEVICE  
1) Search for APK: adb shell pm list packages | grep -i app_name
2) Get path to APK: adb shell pm path com.example.app
3) Download APK to localhost: adb pull /data/app/com.example.sapp-2.apk path/to/desired/destination

## DECOMPILE APK  
1) ```apktool d file.apk```  
2) ```d2j-dex2jar file.apk```
3) ```jadx -d app_src file.apk```

## GREP CODE  

## ACTIVITY  

## BROADCAST RECEIVERS  

## CONTENT PROVIDERS  

## SERVICES  

## DROZER  

**Package information**: ```run app.package.info -a package_name```  
**Identify attacke surface**: ```run app.package.attacksurface package_name```  
**Activity info**: ```run app.activity.info -a package_name```  
**Service information**: ```run app.service.info -a package_name```  
**Broadcast receivers information**: ```run app.broadcast.info -a package_name```  

[data:text/html;base64,PGltZyBzcmM9MSBvbmVycm9yPXByb21wdCgndGVzdCcpPg==](data:text/html;base64,PGltZyBzcmM9MSBvbmVycm9yPXByb21wdCgndGVzdCcpPg==)
