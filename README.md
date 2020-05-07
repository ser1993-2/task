## Установка

- запусть git clone https://github.com/ser1993-2/task.git.
- в дериктории проекта:
- запустить composer install
- запустить npm install
- запустить cp .env.example .env
- php artisan key:generate
- php artisan storage:link
- указать параметры БД (mysql)
- php artisan migrate
- php artisan db:seed
- запустить npm run prod

## Начальные данные

- Менеджер: email - manager@manager.ru ; password - qwer1234;
- Пользователь: создается при регистрации

## Почтовые отправления

Указать данные (yandex):
- MAIL_MAILER=smtp
- MAIL_HOST=smtp.yandex.ru
- MAIL_PORT=465
- MAIL_USERNAME=Login
- MAIL_PASSWORD=Password
- MAIL_ENCRYPTION=ssl

