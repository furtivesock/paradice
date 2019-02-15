# Paradice

What the hell is Paradice ? Well, it's not really a French cabaret. It's basically as if Discord and written Role play made a baby together... If you are not familiar with Role Play, DO. NOT. EVER. LEAVE. because Paradice is an amazing world that centralizes simplified RP forums. 
Each one matches with an universe that one member made with his imagination, preferably. People can join them and contribute to stories organized by a GM (Game Master) or not. Unlike normal forums, Paradice offers a panel of features dedicated to RP and universe development, for example dices or wiki-like articles.
The only rule is to use your imagination the best as you can!

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
  - [ ] Notification of new message
- [x] Home
  - [x] Show top universes
- [ ] Universe
  - [ ] Show all
  - [x] Show one
  - [x] Creation
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
  - [ ] Notification of new message
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
 sum up all our ideas of design and features for paradice. Please have a look on it if you want to see what could become our website :D


Design and ideas were mostly imagined by @furtivesock

Some examples :

![](https://gitlab.com/alerycserrania/paradice/uploads/7cd903384cd4b6f106b41b349ae3d1ca/dice-feature.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/f866747659eeeafb161616fdc278f051/ongoing-story-user.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/392fac8b3585b88d57dc69436c44cffd/home.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/e4be1b8c2f786385606dad7c00737cb3/story-creation.jpg)

![](https://gitlab.com/alerycserrania/paradice/uploads/2bc27e77b736915178130b775887b773/story-registration-narrator.jpg)

![](https://gitlab.com/alerycserrania/paradice/uploads/1cb526e0b67e910ad1dc574e1c0408f0/story-registration-process-user.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/c3eb1b5ad20fe88a0055cb0493a09524/story-reply-box.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/f31906a6a35ac7ff20911c32e3bbd74d/story-reply-example.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/3e9f84e08a3811acb4ece443440c59b4/story-status-icons.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/58b21455dc35e2eaeaf20b94cc9a5c82/universe-creation.jpg)

![](https://gitlab.com/alerycserrania/paradice/uploads/893d489d5fe29589bc0f4ac4eb732e4c/universe-dashboard-home.jpg)

![](https://gitlab.com/alerycserrania/paradice/uploads/d1275f4bb35fc241273675086b34888b/universe-homepage.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/8903841666bcfe194748a7336760ae77/universe-story-example.png)

![](https://gitlab.com/alerycserrania/paradice/uploads/fb1c29ef8cc18e8103e1f5342f2ed55e/vertical-menu.png)

## Database

You can check our current [Merise diagram](https://gitlab.com/alerycserrania/paradice/uploads/11a67e327753ea291ea8ec1ce8dbfa80/mcd.Jpg) for the application (changes can happened at any time if needed)

![diag](https://gitlab.com/alerycserrania/paradice/uploads/11a67e327753ea291ea8ec1ce8dbfa80/mcd.Jpg)