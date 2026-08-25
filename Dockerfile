FROM php:8.4-cli

RUN apt-get update -y && apt-get install -y --no-install-recommends \
	git \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libpng-dev \
	openssl \
	unzip \
	zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-install -j"$(nproc)" gd \
	&& rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
RUN composer install

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EXPOSE 8000
