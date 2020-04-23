# Changelog

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

*Features may be changed over time.*

### Minimum Valuable Product

#### Website

- Show all universes
- UI improvements

#### Universe

- Create a Location
- Create a Trait
- Create a Type of trait
- Customize design, CSS
- Add markdown
- Publish a lore (encyclopedia) information page
- Character sheet
- Member management
- Send invitations

#### Story

- Dice feature

#### User

- Show user's profile

#### Miscellaneous

- Migrations from Symfony 4 to 5
- Write functional tests

#### Issues to fix

- Issue [#5](https://github.com/furtivesock/paradice/issues/5) : Use app.user to get user instead of manually adding them for each render response
- Issue [#3](https://github.com/furtivesock/paradice/issues/3) : Use client and server websocket to avoid active polling 
- Issue [#4](https://github.com/furtivesock/paradice/issues/4) : Asking for the idUniverse and idChapter in ChapterController::show() is useless

### Additional features

*Once MVP is done*

- Shop
- Inventory
- Universe map
- Create a story without chapters
- Multiple characters for one account
- Join a story without website registration

## [0.2.0] - 2019-04-12

### Added

- UI improvements

### Fixed

- Remove HTML tags for formatting
- Use Bootstrap styles with SASS

## [0.1.1] - 2019-02-22

### Fixed

- Separate form, process, and confirmation routes
- Use the Form class for building forms
- Get rid of Java Enterprise Naming
- Use the configuration for settings

## [0.1.0] - 2019-02-11

### Added

#### Website

- Universe rankings: all time, annually, monthly, weekly, today

#### Database

- Create the database
- Create dummy data for the database (fixtures)

#### Story

- View of a Story
- Visibility of a Story
- Creation of a Story
- Registration to a Story (Author pov)
- Send a message
- Change status for a story

#### Universe

- Registration to an Universe (Creator + moderator pov)
- View of an Universe

#### User

- Registration to the website
