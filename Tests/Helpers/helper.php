<?php

/**
 * Generate content for repository interface.
 *
 * @param $repo
 *
 * @return string
 */
function repository_interface_content($repo)
{
    return <<<Contract
<?php namespace App\\Foo\\Contracts;

interface {$repo}Repository
{

}

Contract;
}

/**
 * Generate content for Eloquent Repository.
 *
 * @param $repo
 *
 * @return string
 */
function eloquent_repository_content($repo)
{
    return <<<Repo
<?php namespace App\\Foo\\Repositories;

use App\\Foo\\Contracts\\{$repo}Repository;

class Eloquent{$repo}Repository implements {$repo}Repository
{

}

Repo;
}

/**
 * Delete a file if exists
 *
 * @param $file
 */
function deleteFile($file)
{
    if (is_file($file)) {
        unlink($file);
    }
}

/**
 * Delete a directory if exists
 *
 * @param $dir
 */
function deleteDir($dir)
{
    if (is_dir($dir)) {
        rmdir($dir);
    }
}
