#!/bin/bash
php=php
$php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
$php -r "if (hash_file('SHA384', 'composer-setup.php') === '55d6ead61b29c7bdee5cccfb50076874187bd9f21f65d8991d46ec5cc90518f447387fb9f76ebae1fbbacf329e583e30') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
$php composer-setup.php
$php -r "unlink('composer-setup.php');"
$php composer.phar install
$php bin/console cache:clear --no-warmup
$php bin/console cache:clear --no-warmup --env=prod
$php bin/console doctrine:database:create
$php bin/console doctrine:schema:update --force
$php bin/console fos:user:create --super-admin admin bcelmer@is.umk.pl admin
chmod -R 777 var
chmod  777 .
chmod  777 data.db3
