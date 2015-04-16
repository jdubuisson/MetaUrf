# Meta Urf

Welcome to Meta Urf - a fully-functional Symfony2 application that allows
web users to test their knowledge of the League of Legends Meta in the
featured game mode Ultra Rapide Fire.

##Install

### Prerequisites
You downloaded the source and extracted it.
Your server is configured so that the `./web` of the project is accessible by a browser.

### Composer
Composer is required to build the project.
If you have curl :
```
curl -sS https://getcomposer.org/installer | php
```

Then, run composer install :
```
php composer.phar install
```

### Final steps

#### Assets
```
php app/console assets:install web --symlink && app/console assetic:dump
```

#### Cache and logs permissions
You will likely need to fix the `./app/cache` and `./app/logs` folders permissions.

#### Database
The `./app/config/config.yml` must be updated to include your Riot Games API Key.

To initiate the database and its structure :
```
app/console doctrine:database:create
app/console doctrine:schema:create
```

#### Data
You will need to initiate the local champion data :
```
app/console murf:static-champion-init
```

The websites stores URF game sets returned by the api (api-challenge-v4.1) and uses them for the random series, but also as fallback if something goes wrong while loading the data from the API (too many connections ...). As a result, you should load a couple sets/series into your database. It's easy, just access this URL of your website dev environment : `http://yoursite.com/app_dev.php/api-set`.
When moving to production, you should import some data from a test/dev environment to smooth things out.
