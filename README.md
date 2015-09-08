# Laravel-5.1-Generators
[![Build Status](https://travis-ci.org/SachinAgarwal1337/Laravel-5.1-Generators.svg?branch=master)](https://travis-ci.org/SachinAgarwal1337/Laravel-5.1-Generators) [![Latest Stable Version](https://poser.pugx.org/skagarwal/generators/v/stable)](https://packagist.org/packages/skagarwal/generators) [![Latest Unstable Version](https://poser.pugx.org/skagarwal/generators/v/unstable)](https://packagist.org/packages/skagarwal/generators) [![License](https://poser.pugx.org/skagarwal/generators/license)](https://packagist.org/packages/skagarwal/generators)
<br><br>If you like to keep your laravel appliaction in well formed structure and tired of making all the directories and subdirectories manually for every model, Then this package will help you automate this process.
<br><br>
**This Package Strictly Follows The Directory Structure:** 
```php
app/
  |
  |_Foo/
    |
    |_Foo.php // The Eloquent Model
    |
    |_Contracts/
      |
      |_FooRepository.php // black interface
    |
    |_Events/
    |
    |_Jobs/
    |
    |_Listeners/
    |
    |_Repositories/
      |
      |_EloquentFooRepository.php // impletements the FooRepository.php interface out of the box.
```
<br>
**Avaiabale Commands:**
- `create:model`
- `create:repository`
- `create:event`
- `create:listener`
- `create:job`

*Few More to Come*
<br>
# Usage

### Step 1: Install Through Composer
```
composer require skagarwal/generators --dev
```

### Step 2: Add the Service Provider
  Add the `SKAgarwal\Generators\GeneratorsServiceProvider` to the `Config/app.php`'s `providers` array
```
Config/app.php

'providers' => [
  ...
  ...
  ...
  
  'SKAgarwal\Generators\GeneratorsServiceProvider',
],
```

### Step 3: Run Artisan!
You're all set. Run `php artisan` from the console, and you'll see the new commands in the `make:*` namespace section.

<hr>
# Commands

### `create:model`
**Description:**
- Creates a model, migration and the directory structure.

**Arguments:**
- `model` - _Required._ Name of the model to be created.

**Options:**
- `--migration` - _Optional._ If provided, Migration for the Model will be created.

**usage:**
```php
php artisan create:model Foo ---migration
```

This will produce the Following:
```php
app/
  |
  |_Foo/
    |
    |_Foo.php // The Eloquent Model
    |
    |_Contracts/
      |
      |_FooRepository.php // black interface
    |
    |_Events/
    |
    |_Policies/
    |
    |_Jobs/
    |
    |_Listeners/
    |
    |_Repositories/
      |
      |_EloquentFooRepository.php // impletements the FooRepository.php interface out of the box.
```
And since `--migration` option is provided, there will be a migration for `Foo` in `Database\Migrations\`.

-
### `create:repository`
**Description:**
- Creates a repository interface and its eloquent implimentation in respective directories.

**Arguments:** 
- `model` - _Required._ The Model Name. Repository Will Be Created Under This Model Directory.

**Options:**
- `--repository` - _Optional._ The Repository Name to be created. If not provided, Repository with the Model Name will be created.

**Usage:**
```php
php artisan create:repository Foo
```
This will produce:
```php
app\Foo\Contracts\FooRepository.php
app\Foo\Repositories\EloquentFooRepository.php
```
If `--repository=Bar` or `-r Bar` is provided, then it will produce:
```php
app\Foo\Contracts\BarRepository.php
app\Foo\Repositories\EloquentBarRepository.php
```

**Note:**
- Do not forget to bind the interface to its implimentation in Service container.

-
### `create:event`
**Description:**
- Creates a event class in `{model}/Events/` directory.

**Arguments:**
- `name` - _Required._ Name of the event class.

**Options:**
- `model` - _Required._ Name of the model the event belongs to.

**Usage:**
```php
php artisan create:event UserRegistered --model=User
```
This will produce:
```php
User\Events\UserRegistered.php
```

-
#### `create:listener`
**Description:**
- Creates a event listener in `{model}\Listeners\` directory.

**Arguments:**
- `name` - _Required._ Name of the event listener.

**Options:**
- `model` - _Required._ Name of the model lsitener belongs to.
- `event` - _Required._ Name fo the event listener is being listened for.
- `queued` - _Optional_ Indicated listener should be queued.

**Usage:**
```php
php artisan create:listener SendWelcomeEmail --event=UserRegistered --model=User
```

This will produce:
```php
User\Listeners\SendWelcomeEmail.php
```

**Note:**
- Do not forget to register the listener for the event in `EventServiceProvider`.

-
#### `create:job`
**Description:**
- Creates a job in `{model}\Jobs\` directory.

**Arguments:**
- `name` - _Required._ Name of the job.

**Options:**
- `model` - _Required._ Name of the model job belongs to.
- `queued` - _Optional_ Indicated listener should be queued.

**Usage:**
```php
php artisan create:job RegisterUser --model=User --queued
```

This will produce:
```php
User\Jobs\RegisterUser.php
```

-

#### `create:policy`
**Description:**
- Creates a policy in `{model}\Policies\` directory.

**Arguments:**
- `name` - _Required._ Name of the policy.

**Options:**
- `model` - _Required._ Name of the model policy belongs to.

**Usage:**
```php
php artisan create:policy PostPolicy --model=Post
```

This will produce:
```php
Post\Policies\PostPolicy.php
```

-
