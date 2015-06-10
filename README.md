# Laravel-5.1-Generators
[![Build Status](https://travis-ci.org/SachinAgarwal1337/Laravel-5.1-Generators.svg?branch=develop)](https://travis-ci.org/SachinAgarwal1337/Laravel-5.1-Generators) [![Latest Stable Version](https://poser.pugx.org/skagarwal/generators/v/stable)](https://packagist.org/packages/skagarwal/generators) [![Latest Unstable Version](https://poser.pugx.org/skagarwal/generators/v/unstable)](https://packagist.org/packages/skagarwal/generators) [![License](https://poser.pugx.org/skagarwal/generators/license)](https://packagist.org/packages/skagarwal/generators)
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
- `make:model:structure`
- `make:repository`

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

### `make:model:structure`
**Arguments:**
- `model` - _Required._ Name of the model to be created.

**Options:**
- `--migration` - _Optional._ If provided, Migration for the Model will be created.

**usage:**
```php
php artisan make:model:structure Foo ---migration
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
### `make:repository`
**Arguments:** 
- `model` - _Required._ The Model Name. Repository Will Be Created Under This Model Directory.

**Options:**
- `--repo` - _Optional._ The Repository Name to be created. If not provided, Repository with the Model Name will be created.

**Usage:**
```php
php artisan make:repository Foo
```
This will produce:
```php
app\Foo\Contracts\FooRepository.php
app\Foo\Repositories\EloquentFooRepository.php
```
If `--repo=Bar` is provided, then it will produce:
```php
app\Foo\Contracts\BarRepository.php
app\Foo\Repositories\EloquentBarRepository.php
```
-
