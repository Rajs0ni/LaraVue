#!/bin/bash
fuser -k 8091/tcp
fuser -k 8093/tcp

yarn install;
pushd vuejs/; yarn install ; popd;
pushd laravel/; composer install; php artisan migrate ; popd;
(php -S  localhost:8091 -t laravel/public route.php & cd vuejs ; yarn serve --port  8093 --host localhost & wait)


