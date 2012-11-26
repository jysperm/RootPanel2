#!/bin/bash

cp /RootPanel/etc/apache2/apache2.conf /etc/apache2/apache2.conf
cp /RootPanel/etc/apache2/ports.conf /etc/apache2/ports.conf
cp /RootPanel/etc/apache2/sites-enabled/00000-rphost /etc/apache2/sites-enabled/00000-rphost
cp /RootPanel/etc/nginx/nginx.conf /etc/nginx/nginx.conf
cp /RootPanel/etc/nginx/sites-enabled/00000-rphost /etc/nginx/sites-enabled/00000-rphost
cp /RootPanel/etc/php5/cli/conf.d/ming.ini /etc/php5/cli/conf.d/ming.ini
cp /RootPanel/etc/php5/php.ini /etc/php5/apache2/php.ini
cp /RootPanel/etc/php5/php.ini /etc/php5/cgi/php.ini
cp /RootPanel/etc/sudoers /etc/sudoers
cp /RootPanel/etc/security/limits.conf /etc/security/limits.conf
cp /RootPanel/etc/sysctl.conf /etc/sysctl.conf
cp /RootPanel/etc/pptpd.conf /etc/pptpd.conf
cp /RootPanel/etc/ppp/pptpd-options /etc/ppp/pptpd-options

sysctl -p
