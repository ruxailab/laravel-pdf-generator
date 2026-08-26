#!/usr/bin/env bash

set -Eeuo pipefail

PROJECT_ID="${PROJECT_ID:-}"
ENVIRONMENT="${ENVIRONMENT:-}"
REGION="${REGION:-us-central1}"
REPOSITORY="${REPOSITORY:-containers}"
SERVICE_NAME="${SERVICE_NAME:-laravel-pdf-generator}"
IMAGE_NAME="${IMAGE_NAME:-laravel}"
TAG="${TAG:-$(git rev-parse --short HEAD 2>/dev/null || date +%Y%m%d%H%M%S)}"
ALLOW_UNAUTHENTICATED="${ALLOW_UNAUTHENTICATED:-true}"

usage() {
  cat <<'EOF'
Usage: ./deploy.sh [options]

Options:
  --environment ENVIRONMENT  Deployment environment: develop or production
  --project PROJECT_ID       Google Cloud project (default: gcloud config)
  --region REGION            Google Cloud region (default: us-central1)
  --repository NAME          Artifact Registry repository (default: containers)
  --service NAME             Cloud Run service (default: laravel-pdf-generator)
  --tag TAG                  Docker image tag (default: current git commit)
  --authenticated            Require authentication on Cloud Run
  -h, --help                 Show this help

Environment variables with the same names are also supported:
ENVIRONMENT, PROJECT_ID, REGION, REPOSITORY, SERVICE_NAME, IMAGE_NAME,
TAG, ALLOW_UNAUTHENTICATED.

For environment deploys, set DEVELOP_PROJECT_ID or PRODUCTION_PROJECT_ID.
EOF
}

while [[ $# -gt 0 ]]; do
  case "$1" in
    --environment) ENVIRONMENT="$2"; shift 2 ;;
    --project) PROJECT_ID="$2"; shift 2 ;;
    --region) REGION="$2"; shift 2 ;;
    --repository) REPOSITORY="$2"; shift 2 ;;
    --service) SERVICE_NAME="$2"; shift 2 ;;
    --tag) TAG="$2"; shift 2 ;;
    --authenticated) ALLOW_UNAUTHENTICATED=false; shift ;;
    -h|--help) usage; exit 0 ;;
    *) echo "Unknown option: $1" >&2; usage >&2; exit 1 ;;
  esac
done

case "$ENVIRONMENT" in
  develop)
    PROJECT_ID="${PROJECT_ID:-${DEVELOP_PROJECT_ID:-}}"
    ;;
  production)
    PROJECT_ID="${PROJECT_ID:-${PRODUCTION_PROJECT_ID:-}}"
    ;;
  "")
    ;;
  *)
    echo "ERROR: environment must be 'develop' or 'production'." >&2
    exit 1
    ;;
esac

if [[ -z "$PROJECT_ID" ]]; then
  PROJECT_ID="$(gcloud config get-value project 2>/dev/null)"
fi

if [[ -z "$PROJECT_ID" || "$PROJECT_ID" == "(unset)" ]]; then
  echo "ERROR: configure a Google Cloud project with gcloud config set project PROJECT_ID or --project." >&2
  exit 1
fi

for command_name in gcloud docker; do
  if ! command -v "$command_name" >/dev/null 2>&1; then
    echo "ERROR: '$command_name' is required but was not found in PATH." >&2
    exit 1
  fi
done

IMAGE_URI="${REGION}-docker.pkg.dev/${PROJECT_ID}/${REPOSITORY}/${IMAGE_NAME}:${TAG}"

echo "Deploying ${IMAGE_URI} to Cloud Run service ${SERVICE_NAME}..."

gcloud services enable artifactregistry.googleapis.com run.googleapis.com \
  --project "$PROJECT_ID"

if ! gcloud artifacts repositories describe "$REPOSITORY" \
  --location "$REGION" \
  --project "$PROJECT_ID" >/dev/null 2>&1; then
  gcloud artifacts repositories create "$REPOSITORY" \
    --repository-format=docker \
    --location "$REGION" \
    --description="Docker images for ${SERVICE_NAME}" \
    --project "$PROJECT_ID"
fi

gcloud auth configure-docker "${REGION}-docker.pkg.dev" --quiet
docker build --platform linux/amd64 -t "$IMAGE_URI" .
docker push "$IMAGE_URI"

deploy_args=(
  run deploy "$SERVICE_NAME"
  --image "$IMAGE_URI"
  --region "$REGION"
  --platform managed
  --port 8000
  --project "$PROJECT_ID"
)

if [[ "$ALLOW_UNAUTHENTICATED" == "true" ]]; then
  deploy_args+=(--allow-unauthenticated)
fi

gcloud "${deploy_args[@]}"

echo "Deployment completed:"
gcloud run services describe "$SERVICE_NAME" \
  --region "$REGION" \
  --project "$PROJECT_ID" \
  --format='value(status.url)'