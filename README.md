Jungle
=================================
Фреймворк обязан доступно обеспечить разработчика всеми возможно-стями при проектировании целевого _WEB приложения_ с пользовательским интерфейсом.

Фреймворк в первую очередь разрабатывается с целью максимально эффективно использовать возможности технологий и парадигм программирования, для решения задач связанных с формированием про-грамм с пользовательским интерфейсом, благодаря централизованному стилю абстрагирования.

Для **Jungle** характерен максимально централизованный стиль проектирования и абстрагирования, это означает что, один интерфейс  может использоваться несколькими компонентами, так как при проектировании некоторых разных по специфике компонентов, мы наталкиваемся на мысль об использовании одного общего интерфейса для конкретного узла. Интерфейсная часть должна проектироваться достаточно ответственно с точки зрения сфер реализации и будущего применения данного интерфейса. Как пример, два слова: **Запрос** и **Ответ** в контексте **_Коммуникаций_** между хостами, по данному примеру разрабатываются принимающие (**Сервер**) и отправляющие (**Клиенты**) компоненты.

Из конкретных решений в данный момент представлена объектно реляционная модель, которая проектируется с упором на больший спектр типов источников с прозрачным связыванием записей с разными источ-никами между собой, аналогично ForeignKey в базах данных. В список особенностей также входит возможность создать динамическую связь (**Relation**) , когда при обычном связывании «таблиц» мы указываем название внешней «таблицы» в определение метаданных поля, здесь же информация о внешней «таблице», указывается в определенном поле записи.

#### Немного пред-истории

До того как началась разработка, били практики с другими аналогами и инструментами. В результате получения идей по усовершенствованию инфраструктуры проектов, а так же их фундаментальной части – были сделанные выводы собрать с нуля работающий по отличающимся прин-ципам будущий Фреймворк, так как реализация задуманных идей не представляется совместимой с Фреймворками находящимися в ассор-тименте на рынке Open-Source проектов на тот момент. Например, было решено использовать ORM для смешанных типов хранилищ, не ограни-чивая модель объектами только из Базы Данных, это позволит работать с любыми данными как с объектами по общим ORM стандартам, не думая о низкоуровневых операциях с тем или иным типом хранилища, даже с файловой системой. Используя данный прием можно надеяться на обобщенность стиля представления данных (View) реализовав Model-Presenter для любой модели.

Другие компоненты также решено было написать с нуля, т.к. считается, что их можно спроектировать по одним общим стандартам фреймворка, возможно с более мощным функционалом.
