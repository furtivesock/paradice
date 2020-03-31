<div align="center">
  <img src="https://i.imgur.com/IzI4WBI.png">
  <p style="font-style:italic">Into the Multi Verse</p>
</div>

# Paradice <a href="https://app.codacy.com/manual/furtivesock/paradice?utm_source=github.com&utm_medium=referral&utm_content=furtivesock/paradice&utm_campaign=Badge_Grade_Settings"><img src="https://api.codacy.com/project/badge/Grade/769badb588f6446198fb80cf43665da7" alt="Codacy Badge"></a> <a href="https://github.styleci.io/repos/242159657"><img src="https://github.styleci.io/repos/242159657/shield?branch=dev" alt="StyleCI"></a> <a href="https://travis-ci.com/furtivesock/paradice"><img src="https://travis-ci.com/furtivesock/paradice.svg?branch=dev"></a>
  

Paradice is an online textual role play platform that you can self-host in your own servers.

## Table of contents

* [Introduction](#introduction)
  * [Features](#features)
  * [Roadmap](#roadmap)
  * [Origin](#origin)
* [Requirements](#requirements)
* [Installation](#installation)
* [File tree](#file-tree)
* [Advancement](#advancement)
  * [Available features](#available-features)
    * [Back-end](#back-end)
    * [Front-end](#front-end)
* [Database](#database)

## Introduction

What the hell is **Paradice** ? Well, it won't be a French cabaret. It's basically as if Discord and written Role play made a baby together... If you are not familiar with Role Play, DO. NOT. EVER. LEAVE. because Paradice is an amazing world that centralizes simplified RP forums. Each one matches with an universe that one member made with his imagination, preferably. People can join them and contribute to stories organized by a GM (Game Master) or not. Unlike normal forums, Paradice offers a panel of features dedicated to RP and universe development, for example dices or wiki-like articles. The only rule is to use your imagination the best as you can!

This project is not finished yet but I would like to achieve it as soon as I could.

### Features

- Register once to get access to all the content
- Create multiple universes with its rules and quirks
- Choose its visibility so you can work on it at your pace. You can also make it accessible and block registrations, to use it as a wiki for your other platform
- Write informations about your universe as much as you want it detailed, like a wiki
- Invite your peers to take part, expand your universe
- Customize your character sheet according to the different elements forming your universe
- Create one or multiple characters in an universe
- Create your collaborative stories. You can also prepare, find partners and discuss together about the course of events before the beginning
- Use different types of dice and make events more unexpected
- Organize your stories into chapters
- Manage shops and inventories of each playable character
- Use API to interconnect data from your Paradice universe to your other platform (*in review*)

### Roadmap

- **Late december 2018** : Genesis

#### 2019

- **January to April** : Early version with some implemented minimal features
- **December** : Rebirth

#### 2020

- **March to April** : Concentrating chakras and doing my best to conceive the best baby ever!! *fingers crossed*

### Origin

It all began in late December 2018 as a school project, with three other good guys ([Aleryc](https://github.com/Aleryc), Sloky and Eggoer). In fact, I've always wanted to create a project around textual role play to reunite good ol' friends that I've met in this childhood hobby. In late 2019, for my CS engineering web development module I decided to take over my project but this time I will be alone.

I was also seduced during this time by cool projects that involve self-hosting and open-sourceness (i.e. [Monica](https://github.com/monicahq/monica), [Mastodon](https://github.com/tootsuite/mastodon)..). That's why I would like to do the same with this project, in the long run. My idea is that there would be a centralized official Paradice platform. Users who choose self-hosting decide to share it or not.

## Requirements

- PHP 7.2+
- Composer
- Yarn
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

About the front, you have to type this command which will install Encore, Bootstrap Sass, JQuery and Popper.js (used for Bootstrap JS) :

```sh
yarn install
```

Then, build once the assets/ files into public/build/ folder :

```sh
yarn encore dev
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

Here is the main file tree of the application. Some branches are not included in this tree because there weren't made by us and aren't that interesting.

```sh
paradice
├──config # contains configuration for security, routing, validation, services ...
│   └───packages
│        └───security.yaml # configurations for encoding algorithms
├──public # resources used in the views
│   ├───css
│   ├───images
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

## Advancement

### Available features

Here are the current available features in our app

#### Back-end

- [ ] User
  - [ ] Show all
  - [x] Show one Profile
  - [x] Modification of profile
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
  - [x] Accept or reject application
  - [x] Apply to a universe
- [ ] Story
  - [x] Show all from a universe
  - [x] Show one
  - [x] Creation
  - [x] Change status
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
  - [x] Show all from a user
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

#### Front-end

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
  - [x] Create
  - [x] Login
- [x] Home
  - [x] Show top universes
- [ ] Universe
  - [ ] Show all
  - [X] Show one
  - [X] Create
  - [ ] Show support forum
  - [ ] Accept or reject application
  - [ ] Apply to a universe
  - [ ] Delete (Moderators)
- [ ] Story
  - [X] Show all from a Universe
  - [X] Show one
  - [X] Create
  - [ ] Change status
  - [ ] Close inscription
  - [ ] Add players
  - [ ] Accept or reject application
  - [ ] Apply to a story
  - [ ] Delete
- [ ] Chapter
  - [X] Show all from a Story
  - [X] Show one
  - [X] Create
  - [ ] End a chapter
- [X] Message
  - [X] Send a message in a chapter
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

## Database

You can check our current [Merise diagram](https://gitlab.com/alerycserrania/paradice/uploads/11a67e327753ea291ea8ec1ce8dbfa80/mcd.Jpg) for the application (changes can happened at any time if needed)

![diag](https://gitlab.com/alerycserrania/paradice/uploads/11a67e327753ea291ea8ec1ce8dbfa80/mcd.Jpg)
