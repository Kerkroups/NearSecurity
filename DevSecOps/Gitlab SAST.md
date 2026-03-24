## План:  
1. Secret detection
2. Dependency scanning
3. Code scanning

## Secret detection:
1. Внедряем на стадии test в файле .gitlab-ci.yml / scan execution policy.

Для варианта с файлом .gitlab-ci.yml отредактируем данный файл добавив сделующий код:  
```
include:
  - template: Jobs/Secret-Detection.gitlab-ci.yml
```

Использование FIPS-image для сканнирования: [https://docs.gitlab.com/user/application_security/secret_detection/pipeline/#fips-enabled-images](https://docs.gitlab.com/user/application_security/secret_detection/pipeline/#fips-enabled-images)  
```
variables:
  SECRET_DETECTION_IMAGE_SUFFIX: '-fips'

include:
  - template: Jobs/Secret-Detection.gitlab-ci.yml
```  
Модифицированный файл сохраняется в default branch.  

2. Вариант для secret detection во время merge request: [https://docs.gitlab.com/user/application_security/secret_detection/pipeline/#use-an-automatically-configured-merge-request](https://docs.gitlab.com/user/application_security/secret_detection/pipeline/#use-an-automatically-configured-merge-request)

3. Если secret detection был имплементирован не сразу то необходимо после добавления конфигурации в .gitlab-ci.yml запустить historic secret detection scan для того чтобы обнаружить уже существующие секреты в истории коммитов: [https://docs.gitlab.com/user/application_security/secret_detection/pipeline/#run-a-historic-scan](https://docs.gitlab.com/user/application_security/secret_detection/pipeline/#run-a-historic-scan)

4. Результат работы secret detection pipeline будет записан в файл ```gl-secret-detection-report.json```: [https://docs.gitlab.com/user/application_security/secret_detection/pipeline/#secret-detection-results](https://docs.gitlab.com/user/application_security/secret_detection/pipeline/#secret-detection-results)  
