#!/bin/zsh

cd /var/www/html

echo $(pwd)

if [ ! -d ./vendor ]; then
    echo "Installing packages"
    composer install
    echo "Done installing packages"
fi

composer phpstan
composer test

php -S 0.0.0.0:80 -t /var/www/html/public
