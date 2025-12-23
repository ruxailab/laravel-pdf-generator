# Laravel PDF Generator ✅

A lightweight Laravel project that demonstrates PDF generation (using packages like `barryvdh/laravel-dompdf`) and includes a simple web UI. This README explains how to get the project running locally and in Docker.

---

## 🚀 Quick Start

1. Clone the repository

```bash
git clone <repo-url> laravel-pdf-generator
cd laravel-pdf-generator
```

2. Install PHP dependencies

```bash
composer install
```

3. Copy the environment file and set values

```bash
cp .env.example .env
# On Windows (PowerShell): Copy-Item .env.example .env
```

4. Serve the application

```bash
php artisan serve 
```

Open your browser at: `http://127.0.0.1:8000`

---

## 🧪 Tests

Run the test suite with:

```bash
php artisan test
```

---

## 🐳 Docker (optional)

This repository contains a `Dockerfile`. A simple way to build and run the image locally:

```bash
docker build -t laravel-pdf-generator .
docker run -it --rm -p 8000:8000 \
  -e APP_ENV=local -e APP_KEY="base64:..." \
  laravel-pdf-generator
```

(Adjust environment variables and entrypoint as required; for production deployments prefer using a multi-stage build or Docker Compose.)

---

## ⚠️ Troubleshooting & Tips

- If `composer install` fails with memory errors, run:

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

- Ensure PHP extensions required by Laravel are installed (openssl, pdo, mbstring, tokenizer, xml, ctype, json, bcmath).

- On Windows, if symlinks fail for `php artisan storage:link`, create the `storage` public folder manually or run your terminal as Administrator.

- If assets are not updating, try:

```bash
npm run dev
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

---

## 📁 Project notes

- PDF generation uses `barryvdh/laravel-dompdf` (already included in `composer.json`). Check `resources/views/pdf/` for example templates.

- Routes and controllers are located in `app/Http/Controllers` and views are in `resources/views`.

---

## 🤝 Contributing

Contributions are welcome — please open an issue or a pull request.

---

## 📜 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
