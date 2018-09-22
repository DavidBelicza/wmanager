FROM ubuntu:18.04

MAINTAINER David Belicza "87.bdavid@gmail.com"

RUN ln -sf /usr/share/zoneinfo/Europe/Budapest /etc/localtime

RUN apt-get update
RUN apt-get install php-common php-mbstring php-cli php-bcmath -y
RUN apt-get install composer -y

WORKDIR /var/www/html

CMD composer install \
    && /bin/bash
