FROM 831119889470.dkr.ecr.eu-central-1.amazonaws.com/mangoweb/php:7.2

RUN pecl install xdebug

COPY xdebug.ini /usr/local/etc/php/conf.d/

RUN echo "zend_extension="`find /usr/local/lib/php/extensions/ -iname 'xdebug.so'` >> /usr/local/etc/php/conf.d/xdebug.ini

COPY entrypoint.sh console-entrypoint.sh /var/

RUN chmod a+x  /var/entrypoint.sh /var/console-entrypoint.sh

ENTRYPOINT ["bash", "-c", "/var/entrypoint.sh"]
