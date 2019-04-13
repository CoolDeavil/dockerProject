FROM ubuntu:18.04

# disable interactive functions
ENV DEBIAN_FRONTEND noninteractive
RUN export RUNLEVEL=1

RUN grep -v '^#' /etc/apt/sources.list
RUN apt-get update && apt-get install -y --no-install-recommends apt-utils
RUN apt-get install software-properties-common -y

RUN apt-get -y install locales
RUN sed -i -e 's/# en_US.UTF-8 UTF-8/en_US.UTF-8 UTF-8/' /etc/locale.gen 
RUN locale-gen en_US.UTF-8

RUN apt-get install -y curl software-properties-common sudo zip vim wget

ENV LANG en_US.UTF-8
ENV LANGUAGE en_US.UTF-8
ENV LC_ALL en_US.UTF-8

RUN apt-get install -y apache2 -y
RUN echo "ServerName zenmachine" >> /etc/apache2/apache2.conf

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_LOG_DIR /var/log/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_LOG_DIR /var/log/apache2

RUN mkdir -p /var/www/html/application/public
RUN chown -R www-data:www-data /var/www/html/application/public
ADD etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf

# supervisor installation 
RUN apt-get -y install supervisor
RUN update-rc.d supervisor defaults

ADD etc/supervisor/conf.d/apache2.conf /etc/supervisor/conf.d/
ADD etc/supervisor/conf.d/php-fpm.conf /etc/supervisor/conf.d/


# Install PHP 7.2
RUN apt-get install php7.2 php7.2-fpm -y
RUN a2enmod proxy_fcgi rewrite

RUN service php7.2-fpm start

RUN apt-get install php7.2-fpm \
  php7.2-cli \
  php7.2-common \
  php7.2-json \
  php7.2-opcache \
  php7.2-mysql \
  php7.2-mbstring \
  php7.2-zip \
  php7.2-xml \
  php7.2-gd \
  php7.2-redis \
  php7.2-sqlite3 -y --allow-unauthenticated

RUN apt-get install -y php-xdebug
RUN apt-get install -y php-imagick

ADD etc/php/7.2/fpm/conf.d/99-overrides.ini etc/php/7.2/fpm/conf.d/
ADD etc/php/7.2/mods-available/xdebug.ini etc/php/7.2/mods-available/

RUN service apache2 restart

#MailCatcher
RUN apt install build-essential libsqlite3-dev ruby-dev -y
RUN gem install mailcatcher --no-rdoc --no-ri

#Composer
RUN curl -s http://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

#NodeJS
RUN curl -sL https://deb.nodesource.com/setup_11.x | sudo -E bash -
RUN apt-get install -y nodejs
# https://docs.npmjs.com/getting-started/fixing-npm-permissions
RUN mkdir ~/.npm-global
RUN npm config set prefix '~/.npm-global'
RUN export PATH=~/.npm-global/bin:$PATH
RUN sudo chown -R $USER:`id -g -n $USER` ~/.npm-global

#GIT
RUN add-apt-repository ppa:git-core/ppa -y
RUN apt-get update -y
RUN apt-get install git -y

# Configure Services and Ports
EXPOSE 1080 1025
EXPOSE 9000

# Launch Script
COPY start.sh start.sh
CMD ["./start.sh"]