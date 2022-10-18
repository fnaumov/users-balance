# Users balance

Простое приложение на Laravel с авторизацией и балансами пользователей

- На главной странице после входа отображает баланс пользователя и последние пять операций
- Обновляет данные на главной странице каждую секунду
- Отображает таблицу операций с сортировкой по полю “дата” и поиском по полю “описание”

## Инструкция
- Загрузить репозиторий
- Обновить зависимости `composer install`
- Поднять окружение докер `docker-compose build` и `docker-compose up -d`
- Прописать настройки в файле `.env` (пример `.env.example`)
- Накатить миграции `php artisan migrate`
- Обновить зависимости npm `npm install`
- Собрать фронт `npm run dev`

## Команды
- Добавление пользователя (в аргументах имя, email, пароль)
``` script
php artisan user:create username example@gmail.com password
```

- Изменение баланса (в аргументах email, направление (in, out), сумма, валюта (usd, eur, rub), описание)
``` script
php artisan transaction:create example@gmail.com in 9.554 rub desc1
php artisan transaction:create example@gmail.com out 155.35 usd desc2
```
