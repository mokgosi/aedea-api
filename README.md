# 🚀 Symfony API Backend

This is the backend API for idea submissions, collaborations, project proposals or business enquires built with:

- Symfony 8
- API Platform
- Doctrine ORM
- JWT Authentication
- reCAPTCHA verification
- Symfony Mailer 
- Mailpit 

---

# ⚙️ Requirements

- PHP 8.1+
- Composer
- Symfony CLI (optional but recommended)
- MySQL or PostgreSQL
- Node (optional for frontend)

---

# 📥 Installation

## 1. Clone repository

```bash
git clone git@github.com:mokgosi/aedea-api.git
cd aedea-api
```

## 2. Install dependencies

```bash
composer install
```

## 3. Setup environment

```bash
$ composer install
$ php bin/console lexik:jwt:generate-keypair

DATABASE_URL="mysql://user:password@127.0.0.1:3306/db_name"

MAILER_DSN=smtp://localhost:1025

GOOGLE_RECAPTCHA_SITE_KEY=SITE_KEY
GOOGLE_RECAPTCHA_SECRET_KEY=SECRET_KEY

```

## 4 Create Database

```bash
$ php bin/console doctrine:database:create
$ php bin/console doctrine:migrations:migrate
$ php bin/console doctrine:fixtures:load
```

## 5 Run services


```bash
$ mailpit
$ symfony serve
```

Your api docs  runs here: http://localhost:8000/api

Mailpit runs here: http://localhost:8025