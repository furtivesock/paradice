# Paradice

## Table of contents

- [Requirements](#requirements)
- [Installation](#installation)
- [File tree](#file-tree)
- [Features](#features)
    - [Back-end](#back-end)
    - [Front-end](#front-end)
- [Mock-up](#mock-up)
- [Database](#database)
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

## File tree

Here is the main file tree of the application. Some branches are not included in this trere because there weren't made by us and aren't that interesting.

```sh
paradice
├──config # contains configuration for security, routing, validation, services ...
│   └───packages
│        └───security.yaml # configurations for encoding algorithms
├──public # resources used in the views
│   ├───css
│   ├───js
│   └───index.php # main point of the app used to redirect to the correct controller
├──src # Contains the majority of the php code
│   ├───Controller
│   ├───DataFixtures # Collection of classes to create and insert a set of data in the database
│   ├───Entity # Models used for the database
│   ├───Form # Collection of classes to build form
│   ├───Migrations # All migrations made for the database
│   ├───Repository # Classes used to make query and transform sql result into entities from src/Entity
│   └───Security # Include the Login Authenticator
├──templates # HTML views
│   ├───chapter
│   ├───home
│   ├───registration
│   ├───security # Login form
│   ├───story
│   ├───universe
│   └───base.html.twig # base view for all views in this directory
└───.env # contains environment variables
```

## Features

Here are the current available feature in our app

### Back-end

- [ ] User
  - [ ] Show all
  - [ ] Show one Profile
  - [ ] Modification of profile
  - [x] Creation
  - [x] Login
- [x] Home
  - [x] Show top universes
- [ ] Universe
  - [ ] Show all
  - [x] Show one
  - [ ] Creation
  - [ ] Show support forum
  - [ ] Accept or reject application
  - [ ] Apply to a universe
- [ ] Story
  - [x] Show all from a universe
  - [x] Show one
  - [x] Creation
  - [ ] Change status
  - [ ] Close inscription
  - [ ] Add players
  - [ ] Accept or reject application
  - [ ] Apply to a story
- [ ] Chapter
  - [x] Show all from a Story
  - [x] Show one
  - [x] Creation
  - [ ] End a chapter
- [x] Message
  - [x] Send a message in a chapter
- [ ] Persona
  - [ ] Creation
  - [ ] Show all from a user
  - [ ] Show one
  - [ ] Add modification to your persona
- [ ] Type
  - [ ] Add type or subtype
  - [ ] Remove type or subtype
  - [ ] Modification of type or subtype
- [ ] Location
  - [ ] Add location or sublocation
  - [ ] Remove location or sublocation
- [ ] Characteristic
  - [ ] Add a characteristic
  - [ ] Remove a characteristic
  - [ ] Modification of a characteristic
- [ ] Support forum
  - [ ] Send a message

### Front-end

- [x] All layout
  - [x] User's universes
  - [x] Profile link
  - [x] Logout link
  - [x] Create an account link
  - [x] Create a universe link
  - [x] Log in link
  - [ ] Design of base layout
- [x] Integration of Vue.js (for top universes, stories and messages)
- [x] Integration of Axios (to make asynchronous request)
- [ ] User
  - [ ] Show all
  - [ ] Show one Profile
  - [ ] Modification of profile
  - [ ] Create
  - [ ] Login
- [ ] Home
  - [ ] Show top universes
- [ ] Universe
  - [ ] Show all
  - [ ] Show one
  - [ ] Create
  - [ ] Show support forum
  - [ ] Accept or reject application
  - [ ] Apply to a universe
  - [ ] Delete (Moderators)
- [ ] Story
  - [ ] Show all from a Universe
  - [ ] Show one
  - [ ] Create
  - [ ] Change status
  - [ ] Close inscription
  - [ ] Add players
  - [ ] Accept or reject application
  - [ ] Apply to a story
  - [ ] Delete
- [ ] Chapter
  - [ ] Show all from a Story
  - [ ] Show one
  - [ ] Create
  - [ ] End a chapter
- [ ] Message
  - [ ] Send a message in a chapter
- [ ] Persona
  - [ ] Create
  - [ ] Show all from a user
  - [ ] Show one
  - [ ] Add modification to your persona
  - [ ] Delete
- [ ] Type
  - [ ] Add type or subtype
  - [ ] Remove type or subtype
  - [ ] Modification of type or subtype
- [ ] Location
  - [ ] Add location or sublocation
  - [ ] Remove location or sublocation
- [ ] Characteristic
  - [ ] Add a characteristic
  - [ ] Remove a characteristic
  - [ ] Modification of a characteristic
- [ ] Support forum
  - [ ] Send a message

## Mock-up

[This doc](https://docs.google.com/document/d/1ujAzk27OrEfw6X94VvQVaKHv9srDw7gYD_tYzYvZbYY/edit?usp=sharing)
 sum up all our ideas of design and functionality for paradice. Please have a look on it if you want to see what could become our website :D


Design and ideas were mostly imagine by @furtivesock

## Database

You can check our current [Merise diagram](https://gitlab.com/alerycserrania/pweb/uploads/12f08a089b516a099c3e760aee259bb0/mcd_v4.Jpg) for the application (changes can happened at any time if needed)

