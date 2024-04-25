<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Deploy

To perform the deployment it is necessary to store a docker image in the Artifact Registry, follow the command to deploy:

1 - Generate an image to upload to the Artifact Registry: <br>
`docker build -t us-central1-docker.pkg.dev/PROJECT/name-docker-repo/name-image:latest .`

* `us-central1` is the repository location.
* `docker.pkg.dev` is the hostname of the Docker repository you created.
* `PROJECT` is the Google Cloud project ID.
* `name-docker-repo` is the ID of the repository you created.
* `name-image` is the name of the image you want to use in the repository.
* `latest` is a tag you are adding to the Docker image.

2 - Upload the generated image to the Artifact Registry:<br>
`docker push us-central1-docker.pkg.dev/PROJECT/name-docker-repo/name-image:latest`

3 - Change the image in Cloud Run

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
