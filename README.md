- Расширения PHP: raphf, http, curl
- В .env:
  - С префиксом AMOCRM: subdomain, redirect_url, client_secret, client_id, long_term_access_token - всё берётся из интеграции.
    Выбор auth_type предусмотрен, но не реализован, так что аутентификация только по долгосрочному токену.
    И leads_source для инверсии зависимости есть, но по сути выбора нет:)
  - App_root_user_email и app_root_user_password - логин-пароль от пользователя по-умолчанию, который сидится с помощью php artisan db:seed. APP_locale тоже можно ru поставить.

