<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        // Can't use `config()` to get path as Laravel is not yet booted
        $filePath = __DIR__.'/../database/database.sqlite';
        if (!file_exists($filePath)) {
            touch($filePath);
        }
        parent::setUp();
    }

}
