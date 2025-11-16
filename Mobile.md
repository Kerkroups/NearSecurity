## GET APK FROM DEVICE  
1) Search for APK: adb shell pm list packages | grep -i app_name
2) Get path to APK: adb shell pm path com.example.app
3) Download APK to localhost: adb pull /data/app/com.example.sapp-2.apk path/to/desired/destination

## DECOMPILE APK  
1) ```apktool d file.apk```  
2) ```d2j-dex2jar file.apk```

## GREP CODE  

## ACTIVITY  

## BROADCAST RECEIVERS  

## CONTENT PROVIDERS  

## SERVICES  

