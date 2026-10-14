# Laravel PDF Generator ✅

A lightweight Laravel project that demonstrates PDF generation using packages like `barryvdh/laravel-dompdf` and includes a simple web UI. This README explains how to run the project locally, use Docker, and deploy to Google Cloud Run.

---

## 🚀 Quick Start

### 1. Clone the repository

```bash
git clone <repo-url> laravel-pdf-generator
cd laravel-pdf-generator
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Configure the environment

Copy the example environment file:

```bash
cp .env.example .env
```

On Windows (PowerShell):

```powershell
Copy-Item .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

Configure the remaining environment variables as required by your application.

### 4. Run the application

```bash
php artisan serve
```

Open your browser at [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 🧪 Tests

Run the test suite with:

```bash
php artisan test
```

---

## 🐳 Docker (optional)

This repository includes a `Dockerfile`. Build and run the image locally:

```bash
docker build -t laravel-pdf-generator .

docker run -it --rm -p 8000:8000 \
  -e APP_ENV=local \
  -e APP_KEY="base64:YOUR_APP_KEY" \
  laravel-pdf-generator
```

Replace `YOUR_APP_KEY` with a valid Laravel application key. Configure any additional environment variables required by your application.

Open [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## ☁️ Deploy to Google Cloud Run

### Prerequisites

Before deploying, make sure you have:

- [Google Cloud CLI](https://cloud.google.com/sdk/docs/install) installed.
- Docker installed and running.
- Access to the Google Cloud projects where the application will be deployed.
- Permissions to push images to Artifact Registry and deploy services to Cloud Run.
- The required Google Cloud APIs enabled, or permission to enable them.

### 1. Authenticate with Google Cloud

Sign in using the Google account that has the necessary permissions:

```bash
gcloud auth login
```

Check the active account:

```bash
gcloud auth list
```

The deployment script uses the currently authenticated Google Cloud account. Selecting a project does not change the authenticated account.

If development and production require different Google accounts, authenticate with the appropriate account before deploying.

### 2. Configure the deployment script

Make the script executable:

```bash
chmod +x deploy.sh
```

The script uses these defaults:

| Setting | Default |
|---|---|
| Region | `us-central1` |
| Artifact Registry repository | `containers` |
| Image name | `laravel` |
| Cloud Run service | `laravel-pdf-generator` |
| Port | `8000` |
| Memory | `512Mi` |
| Concurrency | `1` |
| Public access | Enabled |

The deployment script builds the Docker image, pushes it to Artifact Registry, and deploys it to Cloud Run.

### 3. Configure development and production projects

Set the Google Cloud **project IDs**, not their display names.

```bash
export DEVELOP_PROJECT_ID="YOUR_DEVELOP_PROJECT_ID"
export PRODUCTION_PROJECT_ID="YOUR_PRODUCTION_PROJECT_ID"
```

For example, if your development project is `ruxailab-develop`:

```bash
export DEVELOP_PROJECT_ID="ruxailab-develop"
export PRODUCTION_PROJECT_ID="YOUR_PRODUCTION_PROJECT_ID"
```

Replace `YOUR_PRODUCTION_PROJECT_ID` with the actual ID of the production project.

These variables must be available in the terminal where you run the deployment commands. The `export` commands above apply to the current shell session.

### 4. Deploy to development

Run:

```bash
npm run deploy-develop
```

The script should publish the image to the development project's Artifact Registry and deploy the service to that project.

### 5. Deploy to production

Run:

```bash
npm run deploy-production
```

The script should publish the image to the production project's Artifact Registry and deploy the service to that project.

**Important:** Always check the first `Deploying ...` line in the terminal before proceeding. The image URL contains the target project ID.

For example:

```text
Deploying us-central1-docker.pkg.dev/YOUR_PRODUCTION_PROJECT_ID/containers/laravel:TAG
```

If the URL contains the development project ID, stop and correct the configuration before deploying.

### 6. Deploy manually with `deploy.sh`

You can also deploy directly without using npm scripts:

```bash
./deploy.sh --environment develop
```

Or:

```bash
./deploy.sh --environment production
```

You can override the project explicitly:

```bash
./deploy.sh --environment production --project YOUR_PRODUCTION_PROJECT_ID
```

Other supported options include:

- `--region`: Google Cloud region.
- `--repository`: Artifact Registry repository.
- `--service`: Cloud Run service name.
- `--tag`: Docker image tag.
- `--authenticated`: Require authentication to access the Cloud Run service.

For example:

```bash
./deploy.sh \
  --environment production \
  --project YOUR_PRODUCTION_PROJECT_ID \
  --region us-central1 \
  --authenticated
```

### 7. Verify the deployed service

After deployment, the script prints the Cloud Run service URL.

You can also verify the service explicitly:

```bash
gcloud run services describe laravel-pdf-generator \
  --region us-central1 \
  --project YOUR_PRODUCTION_PROJECT_ID \
  --format="value(status.url)"
```

Replace the project ID with the intended target project.

---

## ⚠️ Troubleshooting & Tips

### Deployment targets the wrong project

Check your environment variables:

```bash
echo "$DEVELOP_PROJECT_ID"
echo "$PRODUCTION_PROJECT_ID"
echo "$PROJECT_ID"
```

The `deploy.sh` script supports `PROJECT_ID` as an explicit override. If it is already set in your shell, it may take precedence over the environment-specific project variable, depending on the script's configuration.

To avoid deploying to the wrong project, pass the project ID explicitly:

```bash
./deploy.sh \
  --environment production \
  --project YOUR_PRODUCTION_PROJECT_ID
```

Always verify the project ID in the image URL before the image is pushed and the service is deployed.

### Permission errors

If the deployment fails with a permission error, verify the active account:

```bash
gcloud auth list
```

Confirm that the account has the required permissions in the target project, including Artifact Registry access and Cloud Run deployment permissions.

### Composer memory errors

If `composer install` fails with memory errors, try:

```bash
COMPOSER_MEMORY_LIMIT=-1 composer install
```

### Missing PHP extensions

Ensure the PHP extensions required by Laravel and your installed packages are available in your environment, including extensions such as `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, and `bcmath`, as applicable.

### PDF generation runs out of memory

The Cloud Run container memory allocation and PHP's own `memory_limit` are separate settings.

The Docker image should configure the PHP memory limit through a file such as:

```ini
memory_limit = 512M
```

For the official PHP Docker image, this can be added to `/usr/local/etc/php/conf.d/memory-limit.ini`.

Cloud Run's `--memory` setting must also be sufficient for the application. Large PDF documents may require more memory.

### Assets are not updating

Try:

```bash
npm run build
php artisan view:clear
php artisan route:clear
php artisan config:clear
```

### Docker authentication warnings

If `gcloud auth configure-docker` displays a warning about Docker credential helpers, check that Docker and Google Cloud CLI are installed and configured correctly. The warning alone does not necessarily mean the deployment failed; inspect the command's exit status and subsequent output.

---

## 📁 Project notes

- PDF generation uses `barryvdh/laravel-dompdf`, included in `composer.json`.
- PDF templates are located in `resources/views/pdf/`, if present.
- Controllers and routes are located in `app/Http/Controllers` and `routes/`.
- The Docker image is used for Cloud Run deployments.

---

## 🤝 Contributing

Contributions are welcome. Please open an issue or submit a pull request.

---

## 📜 License

The Laravel framework is open-source software licensed under the [MIT License](https://opensource.org/licenses/MIT).
