## Docker image with Apache and PHP


### Package versions

- Debian 7 slim
- Apache 2.4.10
- PHP 5.2.16


### PHP extensions

bcmath, bz2, calendar, ctype, curl, date, dom, exif, filter, ftp,
gd, gettext, hash, iconv, imap, json, libxml, mbstring, mcrypt,
mime_magic, mysqli, openssl, pcre, PDO, pdo_mysql, pdo_sqlite,
posix, Reflection, session, shmop, SimpleXML, sockets, SPL,
SQLite, ssh2, standard, sysvmsg, tidy, tokenizer, wddx,
xml, xmlreader, xmlwriter, xsl, zip, zlib


### Docker compose example

```yaml
version: '3.3'
  services:
    example-mysql:
      image: mysql:5.5
      ports:
        - 3306:3306
      volumes:
        - ./:/docker-entrypoint-initdb.d
      environment:
        - MYSQL_DATABASE=example_db
        - MYSQL_USER=example_user
        - MYSQL_PASSWORD=pa55word
        - MYSQL_ROOT_PASSWORD=pa55word
    example-app:
      image: mantiby/apache-php-5-2:latest
      ports:
        - 8080:80
      links:
        - example-mysql
      volumes:
        - ./:/usr/local/apache2/htdocs
```
