FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y gnupg gosu curl ca-certificates zsh zip unzip git

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY ./startup.sh /usr/local/bin/startup.sh

RUN chmod +x /usr/local/bin/startup.sh

EXPOSE 80

ENTRYPOINT ["startup.sh"]
