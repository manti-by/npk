FROM debian:wheezy-slim

RUN cat /dev/null > /etc/apt/sources.list && \
    echo "deb http://archive.debian.org/debian/ wheezy main non-free contrib" >> /etc/apt/sources.list && \
    echo "deb-src http://archive.debian.org/debian/ wheezy main non-free contrib" >> /etc/apt/sources.list && \
    echo "deb http://archive.debian.org/debian-security/ wheezy/updates main non-free contrib" >> /etc/apt/sources.list && \
    echo "deb-src http://archive.debian.org/debian-security/ wheezy/updates main non-free contrib" >> /etc/apt/sources.list

RUN apt-get update

RUN apt-get install -y --force-yes vim curl patch make wget gcc perl bzip2 autoconf pkg-config \
    apache2 apache2-threaded-dev libapache2-mod-php5 libxml2-dev libcurl4-openssl-dev libjpeg-dev \
    libmysqlclient-dev libpng12-dev libreadline6-dev libssl-dev

RUN apt-get autoremove --purge && apt-get clean
