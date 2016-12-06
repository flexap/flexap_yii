FlexAP
======

Требования
----------

Минимальное требование к веб-серверу - поддержка PHP 5.5.

Для установки необходимых расширений PHP выполните в командной строке:

~~~
sudo apt-get install php-mysql php-xml php-imagick php-intl php-memcache php-curl php-cli php-mbstring
~~~

Установка FlexAP
----------------

### 1. Склонируйте репозиторий проекта

~~~
git clone https://github.com/noogen-projects/flexap.git
~~~

### 2. Установите зависимоcти проекта

Если у вас не установлен [Composer](http://getcomposer.org/), то установите его следуя инструкции
с официального сайта [getcomposer.org](http://getcomposer.org/doc/00-intro.md).

Выполните следующие команды в корневой папке проекта `flexap`:

~~~
composer global require fxp/composer-asset-plugin --no-plugins
composer install
composer run-script post-create-project-cmd
~~~

### 3. Создайте схему базы данных

Выполните в корневой папке проекта:
    
~~~
sudo mysql -u root < data/create_db.sql
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
php yii migrate/up --migrationPath=@yii/rbac/migrations
php yii migrate
~~~

### 4. Настройте web-сервер Apache

Для установки требуемого Apache PHP-модуля, выполните:

~~~
sudo apt-get install libapache2-mod-php
~~~

Выполните в корневой папке проекта:

~~~
sudo ln -s `pwd` /var/www/flexap
sudo a2enmod rewrite
sudo cp ./config/webserver/flexap.conf /etc/apache2/sites-available/flexap.conf
sudo a2ensite flexap
sudo service apache2 restart
~~~

По адресу [http://localhost/](http://localhost/) теперь должна открываться стартовая страница приложения.

Тестирование
------------

Tests are located in `tests` directory. They are developed with [Codeception PHP Testing Framework](http://codeception.com/).
By default there are 3 test suites:

- `unit`
- `functional`
- `acceptance`

Tests can be executed by running

```
composer exec codecept run
``` 

The command above will execute unit and functional tests. Unit tests are testing the system components, while functional
tests are for testing user interaction. Acceptance tests are disabled by default as they require additional setup since
they perform testing in real browser. 


### Running  acceptance tests

To execute acceptance tests do the following:  

1. Rename `tests/acceptance.suite.yml.example` to `tests/acceptance.suite.yml` to enable suite configuration

2. Replace `codeception/base` package in `composer.json` with `codeception/codeception` to install full featured
   version of Codeception

3. Update dependencies with Composer 

    ```
    composer update  
    ```

4. Download [Selenium Server](http://www.seleniumhq.org/download/) and launch it:

    ```
    java -jar ~/selenium-server-standalone-x.xx.x.jar
    ``` 

5. (Optional) Create `yii2start_tests` database and update it by applying migrations if you have them.

   ```
   tests/bin/yii migrate
   ```

   The database configuration can be found at `config/test_db.php`.


6. Start web server:

    ```
    tests/bin/yii serve
    ```

7. Now you can run all available tests

   ```
   # run all available tests
   composer exec codecept run

   # run acceptance tests
   composer exec codecept run acceptance

   # run only unit and functional tests
   composer exec codecept run unit,functional
   ```

### Code coverage support

By default, code coverage is disabled in `codeception.yml` configuration file, you should uncomment needed rows to be able
to collect code coverage. You can run your tests and collect coverage with the following command:

```
#collect coverage for all tests
composer exec codecept run -- --coverage-html --coverage-xml

#collect coverage only for unit tests
composer exec codecept run unit -- --coverage-html --coverage-xml

#collect coverage for unit and functional tests
composer exec codecept run functional,unit -- --coverage-html --coverage-xml
```

You can see code coverage output under the `tests/_output` directory.
