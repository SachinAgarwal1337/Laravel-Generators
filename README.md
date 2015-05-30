# Laravel-5.1-Generators
[![Build Status](https://travis-ci.org/SachinAgarwal1337/Laravel-5.1-Generators.svg?branch=master)](https://travis-ci.org/SachinAgarwal1337/Laravel-5.1-Generators)
<br><br>If you like to keep your laravel appliaction in well formed structure and tired of making all the directories and subdirectories manually for every model, Then this package will help you automate this process.

**Just run the following command:**
```
php artisan make:model:structure Foo --migration
```
And you will be having the directory structure with the **Eloquent Model** `Foo.php` And few more php classes out of the box.

**Note:** If you provide the `--migration` flag then a migration will also be created for you out of the box.

*few more commands to come*
<hr>
#### Following Directory Structure will be created
```
app/
  |
  |_Foo/
    |
    |_Foo.php
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

