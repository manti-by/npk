#!/bin/sh

set -e
set -u

# echo "extension=bz2.so" > /etc/php/conf.d/ext-bz2.ini
# pecl install bz2

php-ext-install bcmath
php-ext-install calendar
php-ext-install curl
php-ext-install exif
php-ext-install ftp
php-ext-install gettext
php-ext-install iconv

php-ext-install mcrypt
php-ext-install mysqli

php-ext-configure gd --with-jpeg-dir=/usr/
php-ext-install gd

php-ext-configure imap --with-kerberos --with-imap-ssl
php-ext-install imap

cp /usr/src/php/ext/openssl/config0.m4 /usr/src/php/ext/openssl/config.m4
php-ext-install openssl

php-ext-install pdo_mysql
php-ext-install shmop
php-ext-install sockets

# yes '' | pecl install ssh2-0.13
# echo "extension=ssh2.so" > /etc/php/conf.d/ssh2.ini

php-ext-install sysvmsg
php-ext-install tidy
php-ext-install wddx
php-ext-install xsl
php-ext-install zip

cp /usr/src/php/ext/zlib/config0.m4 /usr/src/php/ext/zlib/config.m4
php-ext-install zlib

php-ext-install mbstring
php-ext-install mime_magic

