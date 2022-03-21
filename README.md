# Post Author Comment

This is the Post CRUD, Post Comment, Login, Register, Change password & forgot password.

#### Laravel 9.x

## Installation

```bash
git clone https://github.com/hiteshkr1995/hulkapps-practical-app.git
```

```bash
cd hulkapps-practical-app
```

```bash
composer install
```

```bash
cp .env.example .env
```

```bash
php artisan key:generate
```

After this please set the database credentials in .env we use MYSQL.
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=expence_app
DB_USERNAME=root
DB_PASSWORD=
```

For reset password we need to set email credentials in .env file eg:.
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Now run this to setp up database
```bash
php artisan migrate
```

#### To run project
```bash
php artisan serve
```

## Libraries
	- [Laravel Tags](https://spatie.be/docs/laravel-tags/v4/introduction)
	- [Bootstrap](https://getbootstrap.com/)