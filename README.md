# Paradice

## Table of contents

- [Requirements](#requirements)
- [Installation](#installation)

## Requirements

- PHP 7.2+
- Composer
- MySQL

## Installation

**Clone** the repository :

```sh
git clone "https://gitlab.com/alerycserrania/pweb.git" paradice
cd paradice
```

This will create a new directory named `paradice` with the project inside.

Create a **local environment file** named `.env.local` at the root of `paradice` and copy this code :

```sh
###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=447cedadc84a5a64ca75339ef51c5ec7
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
DATABASE_URL=mysql://<db_user>:<db_password>@127.0.0.1:3306/paradice
###< doctrine/doctrine-bundle ###

###> symfony/swiftmailer-bundle ###
MAILER_URL=null://localhost
###< symfony/swiftmailer-bundle ###
```

This code will define the **environment variables** used in the website. You just need to **replace** `<db_user>` with your MySQL's username and `<db_password>` with your MySQL's password. **In case there is no password for this user, just let it blank like this** :

```sh
DATABASE_URL=mysql://aleryc:@127.0.0.1:3306/paradice
```

Now you can **install the dependencies** needed for this project :

```sh
composer install
```

**Create** the database :

```sh
php bin/console doctrine:database:create
```

This will create a new database in your MySQL's server. You can then **apply migrations** in the database :

```sh
php bin/console doctrine:migrations:migrate
```

If you want some data to test our website you can type this command to insert data from the DataFixtures directory in your newly created database :

```sh
php bin/console doctrine:fixtures:load
```

Finally, you can **run the server** :

```sh
php bin/console server:run
```

Open your browser and go to `localhost:8000` to start your wonderful journey :)

## Tree file

```sh
paradice
└──src
    ├───Controller # All controllers
    ├───DataFixtures # Collection of classes to create a set of data
    ├───Entity # Models used for the database
    ├───Form # Collection of classes for building form
    ├───Migrations # All migrations make for the database
    ├───Repository
    └───Security
  ```