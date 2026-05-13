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


If not done using frontend README yet.


## 1. Clone main app

```bash
$ git clone git@github.com:mokgosi/aedea-app.git
$ cd aedea-app
```

## 2. Clone Api & Setup 

```bash
$ git clone git@github.com:mokgosi/aedea-api.git
$ cd aedea-api
$ cp .env-example .env

DATABASE_URL="mysql://user:password@127.0.0.1:3306/db_name"
GOOGLE_RECAPTCHA_SITE_KEY=SITE_KEY
GOOGLE_RECAPTCHA_SECRET_KEY=SECRET_KEY
```

## 4. Clone frontend

```bash
$ git clone git@github.com:mokgosi/aedea-frontend.git
$ cd aedea-frontend
$ cp .env-example .env

VITE_RECAPTCHA_SITE_KEY=RECAPTCHA_SITE_KEY
```

## 5. Execute Setup

```bash
$ ./scripts/setup.sh

```





