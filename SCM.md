**Branch** - независимая копия, где разработкчики работают не затрагивая основной код в ветке main.  

**Commit** - сохраненный snapshot изменений.  

**Merge** - выполняет слияние отдельных направлений разработки (branches) в единую ветку (main). Объединяет несколько последовательностей коммитов в общую историю.  

**Merge Request** - используются для отслеживания изменений по мере их внесения, для совместной работы, просмотра изменений с членами команды и привязке изменений к задачам. Каждый MR тригерит CI/CD pipeline автоматически. Тесты, сканнирование кода на безопасность, сборка должны быть "pass" перед операцией merge.  

**gitlab-ci.yml** - файл в котором описаны инструкции, что делать при "push" и "merge".  

**Группы**:  
  - Организационный контейнер для проектов, департаментов и комманд.
  - Может содержать множество проектов и подгрупп.
  - Устанавливает права для всех участников.
  - Разделяет CI/CD переменные (API keys, credentials) между проектами.
  - Агрегирует метрики.
  - Можно создать свои group-level шаблоны и политики.

**Если выполнить "commit" в бранч, которого нет, то запустятся job's без "rules"**  

## PIPELINES  

Pipelines могут запускаться автоматически при определенных событиях, например при "push" в бранч, создании MR или по расписанию. Также могут запускаться вручную.  

Pipeline описывается в gitlab-ci.yml и состоит из job.  

**Типы pipelines**  
  - Basic pipeline - выполняет все job'ы на каждом этапе одновременно, заме переходит к следующему этапу.
  - Pipelines которые используют ключевое слово "needs" - работают на основе зависимостей между заданиями (jobs) и могут выполнятся быстрее чем basic pipeline.
  - Merge request pipeline - запускается только для MR а не для каждого commit.
  - Merged results pipeline - ?
  - Merge trains - используются Merged results pipeline для объединения результатов один за другим.
  - Parent-child pipelines - разбивает сложные pipelines в один родительский pipeline, который запускает несколько дочерних pipelines, которые работают в одном проекте с одним и тем же SHA.
  - Multi-project pipelines - комбинирует pipelines из разних проектов в единый pipeline.

При запуске pipeline вручную мы можем посмотреть все переменные среды. Требование: пользователь должен иметь роль Owner.  

View variable names = Guest  
View variable values = Developer  
Configure visibility setting = Owner  

**Переменные, помеченные как защищеннные, доступны для заданий (jobs), выполняемых в pipelines для защищенных веток.**  

**Runners, помоченные как защищенные, могут выполнять jobs только на защищененных ветках, предотвращая выполнение недовереного кода в protected runner и защищая другие чувствительные данные от непреднамеренного доступа.**  

Для защиты данных чувствительных переменных, таких как учетные данные или токены, нужно использовать **"protected variables"** или **"external secrets management"** вметсо мануального определения переменных (**"Manual variables"**) во время ручного запуска pipeline.  

**Запуск pipeline с помощью URL query string**  

Создаnm новый pipeline:
```
https://gitlab.com/[namespase]/myproject1/-/pipelines/new?ref=dev&var[foo]=bar&file_var[file_foo]=file_bar
```
- ref - указывает на branch для которого создается pipeline.  
- var - задать переменную (тип Variable).  
- file_var - задать файл (тип File).

**Manual jobs**  
//TODO  
https://docs.gitlab.com/ci/jobs/job_control/#create-a-job-that-must-be-run-manually 

**Skip pipeline**  
Для push commit без запуска pipeline необходимо добавить "[ci skip]" или "[skip ci]" в любом регистре в commit message. В качестве альтернативы, в git 2.10 или более поздних версиях можно использовать опцию "ci.skip" для push. "ci.skip" не пропускает MR pipelines (заускает такие pipeline).  

Когда пропускаем pipeline происходит:  
  - Создается пустой pipeline без этапов и заданий. Pipeline может отображаться в UI и API ответах.  
  - Устанавливается статус "skipped".

**Удаление pipeline**  
Удаление pipeline не приводит к автоматическому удаление его дочерних pipeline.
Удаление pipeline приводит к истечению срока всех кешей pipeline и удалению всех непосредственно связанных объектов, таких как задания, артефакты и тригеры.  

**Pipeline details**  

Страница с подробностями о последней версии pipeline для последнего commit в main branch.  
```
gitlab.example.com/my-group/my-project/-/pipelines/latest
```

Страница с последней версией pipeline для определенной ветки.  
```
gitlab.example.com/my-group/my-project/-/pipelines/<branch>/latest
```
