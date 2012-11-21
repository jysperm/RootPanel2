#!/bin/bash

cp apache2/apache2.conf /etc/apache2/apache2.conf
cp apache2/ports.conf /etc/apache2/ports.conf
cp apache2/sites-enabled/00000-rphost /etc/apache2/sites-enabled/00000-rphost
cp nginx/nginx.conf /etc/nginx/nginx.conf
cp nginx/sites-enabled/00000-rphost /etc/nginx/sites-enabled/00000-rphost
cp php5/cli/conf.d/ming.ini /etc/php5/cli/conf.d/ming.ini
cp php5/php.ini /etc/php5/apache2/php.ini
cp php5/php.ini /etc/php5/cgi/php.ini
cp sudoers /etc/sudoers