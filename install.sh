#!/bin/bash
php=php ;
$php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" ;
$php composer-setup.php ;
$php -r "unlink('composer-setup.php');" ;
mv composer.phar composer ;
$php composer.phar install ;
$php bin/console cache:clear --no-warmup ;
$php bin/console cache:clear --no-warmup --env=prod ;
$php bin/console doctrine:database:create ;
$php bin/console doctrine:schema:update --force ;
$php bin/console fos:user:create --super-admin admin bcelmer@is.umk.pl admin ;
$php bin/console asset:install ;
$php bin/console assetic:dump ;
$php bin/console doctrine:schema:update --force ;
chmod -R 777 var ;
chmod  777 . ;
chmod  777 data.db3 ;
