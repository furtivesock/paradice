How to contribute
=================

This file is a guide detailing the step to contribute to this amazing project

## Table of contents
- [First step](#first-step)
  - [Clone the repository](#clone-repo)
- [Propose a new task](#propose-task)
  - [Create a new issue](#create-issue)
  - [Edit this issue](#edit-issue)
    - [Add labels](#add-label)
    - [Assign this task to someone](#assign-task)
- [Work on a task](#work-task)
    - [Create a merge request](#create-merge-request)
    - [Pull the repository](#pull-repo)
    - [Commit and push your changes](#push-changes)
- [Warning](#warning)

## <a id="first-step">First step</a>

Well, as we do still not have a Docker, you need to follow these steps manually... Good luck!

### <a id="clone-repo">Clone the repository</a>

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


## <a id="new-feature">Propose a new task</a>

I know you must have a lot of awesome ideas for our project. You just need to follow these step in order to help creating the most incredible website.

### <a id="create-issue">Create a new issue</a>

Go to the **issue board** page. You should see something like this:

![issue-board-panel](./img/issue-board-panel.png)

Once you're here, click on the `New Issue` button on the `Open` panel

![button-new-issue](./img/button-new-issue.png)

Then, type the **name** of the feature you want to add

![add-issue](./img/add-issue.png)

**Convention** for the name : 
```bnf
<Type>:  <Short description>
```
`Type` can be `Add`, `Update` or `Fix`

Voilà! You created your first issue for this project. 

### <a id="edit-issue">Edit this issue</a>

Your first issue is not bad, but you should add more details to help others know what it is about

#### <a id="add-labels">Add labels</a>

You can **add a label to categorize** this task. For instance, if this task is about adding documentation in a file you should apply the `documentation` label.

![issue-detail-add-labels](./img/issue-detail-add-labels.png)

#### <a id="assign-task">Assign this task to someone</a>

Not everyone should work on this task, therefore assigning someone to work on it is important.

![issue-detail-assign-task](./img/issue-detail-assign-task.png)

## <a id="work-task">Work on a task</a>

Now head to the **issue board** page to view the task you can work on.

### <a id="create-merge-request">Create a merge request</a>

Before doing anything, check on the upper right corner **if anyone has already been assigned** to this task. If there is no one, you can assign it to yourself! 

![issue-detail-assign-task](./img/issue-detail-assign-task.png)

After that, **choose a name** for the branch and select the `dev` branch as a source.

![create-branch](./img/create-branch.png)
Convention for branch name :

```bnf
<your-name>/<short-description-of-this-task>
```

Now you should see your merge request on the **merge request page**

Tadaaa~ you did it!

### <a id="pull-repo">Pull the repository</a>

You can start working locally. Go to your workspace and **pull the repository** :

```bash
cd <location-of-local-repository>/
git pull
```

The newly created branch should be added to your local repository. **Switch** the current branch to this branch :

```bash
git checkout <name-of-the-new-branch>
```

### <a id="push-changes">Commit and push your changes</a>

You finally **completed the task** that has taken you enough time to lose all hope of seeing your family again.

Great.

Congratulation! You can **commit** your changes and **push** them to the remote:

```bash
git add .
git commit -m "short description of what you did" -m "add details"
git push origin <name-of-the-branch>
```

## <a id="warning">Warning</a>

**Never push to `dev` or `master` branch. This would have a lot of terrible consequences like :**

  - World being invaded by cute assassin kittens
  - Mickey Mouse coming to your house telling you for 24h that what you did was really mean
  - etc...

