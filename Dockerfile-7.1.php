# 构建php-fpm镜像
# 基础镜像：php:7.1-fpm
# dengqihua<1006236360@qq.com>

FROM php:7.1-fpm

ENV TZ=Asia/Shanghai

# 设置源
# COPY sources.list /etc/apt/sources.list

RUN set -xe; \
    # 设置系统时区
    ln -sf /usr/share/zoneinfo/Asia/Shanghai /etc/localtime; \
    \
    apt-get update; \
    apt-get install -y git; \
    apt-get install -y librabbitmq-dev; \
    \
    # 安装 gd
    apt-get install -y libpng-tools libpng-dev libjpeg-dev libfreetype6-dev; \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/; \
    docker-php-ext-install gd; \
    \
    echo "清理"; \
    apt-get purge -y --auto-remove; \
    rm -rf /var/cache/apt/*; \
    rm -rf /var/lib/apt/lists/*

# 安装扩展
RUN set -xe; \
    docker-php-ext-install mysqli pdo_mysql zip opcache bcmath pcntl

# 安装 redis
COPY ./php-fpm/package/redis-5.3.2.tgz /usr/src/php/ext/redis.tgz
RUN set -xe; \
    cd /usr/src/php/ext; \
    tar xfz /usr/src/php/ext/redis.tgz; \
    mv /usr/src/php/ext/redis-5.3.2 /usr/src/php/ext/redis; \
    rm -rf /usr/src/php/ext/redis.tgz; \
    docker-php-ext-install redis

# 安装 composer
COPY ./php-fpm/package/composer.phar /usr/local/bin/composer
RUN set -xe; \
    chmod +x /usr/local/bin/composer; \
    composer config -g repo.packagist composer https://packagist.phpcomposer.com

# 安装 mongodb
COPY ./php-fpm/package/mongodb-1.9.0.tgz /usr/src/php/ext/mongodb.tgz
RUN set -xe; \
    apt-get update; \
    apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev; \
    cd /usr/src/php/ext; \
    tar xfz /usr/src/php/ext/mongodb.tgz; \
    mv /usr/src/php/ext/mongodb-1.9.0 /usr/src/php/ext/mongodb; \
    rm -rf /usr/src/php/ext/mongodb.tgz; \
    docker-php-ext-configure mongodb --with-mongodb-ssl=auto; \
    docker-php-ext-install mongodb; \
    echo "清理"; \
    apt-get purge -y --auto-remove; \
    rm -rf /var/cache/apt/*; \
    rm -rf /var/lib/apt/lists/*


# 安装 swoole
COPY ./php-fpm/package/swoole-4.5.10.tgz /usr/src/php/ext/swoole.tgz
RUN set -xe; \
    cd /usr/src/php/ext; \
    tar xfz /usr/src/php/ext/swoole.tgz; \
    mv /usr/src/php/ext/swoole-4.5.10 /usr/src/php/ext/swoole; \
    rm -rf /usr/src/php/ext/swoole.tgz; \
    docker-php-ext-install swoole

# 安装 amqp
COPY ./php-fpm/package/amqp-1.10.2.tgz /usr/src/php/ext/amqp.tgz
RUN set -xe; \
    cd /usr/src/php/ext; \
    tar xfz /usr/src/php/ext/amqp.tgz; \
    mv /usr/src/php/ext/amqp-1.10.2 /usr/src/php/ext/amqp; \
    rm -rf /usr/src/php/ext/amqp.tgz; \
    docker-php-ext-configure amqp --with-amqp; \
    docker-php-ext-install amqp

# 安装 pdo_pgsql
RUN set -xe; \
    apt-get update; \
    \
    # 安装 libpg-dev
    apt-get install -y libpq-dev; \
    docker-php-ext-install pgsql pdo_pgsql; \
    \
    echo "清理"; \
    apt-get purge -y --auto-remove; \
    rm -rf /var/cache/apt/*; \
    rm -rf /var/lib/apt/lists/*

# 安装 imagick
COPY ./php-fpm/package/imagick-3.4.3.tgz /usr/src/php/ext/imagick.tgz
RUN set -xe; \
    apt-get update; \
    apt-get install -y libmagickwand-dev libmagickcore-dev; \
    cd /usr/src/php/ext; \
    tar xfz /usr/src/php/ext/imagick.tgz; \
    mv /usr/src/php/ext/imagick-3.4.3 /usr/src/php/ext/imagick; \
    rm -rf /usr/src/php/ext/imagick.tgz; \
    docker-php-ext-install imagick; \

    echo "清理"; \
    apt-get purge -y --auto-remove; \
    rm -rf /var/cache/apt/*; \
    rm -rf /var/lib/apt/lists/*
    
