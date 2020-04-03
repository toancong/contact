<?php

namespace Bean\Contact\Tests;

use CloudCreativity\LaravelJsonApi\Facades\JsonApi;
use CloudCreativity\LaravelJsonApi\LaravelJsonApi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [
            'Bean\Contact\ServiceProvider',
            'CloudCreativity\LaravelJsonApi\ServiceProvider',
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app->singleton(\Illuminate\Database\Eloquent\Factory::class, function ($app){
            return \Illuminate\Database\Eloquent\Factory::construct($app->make(\Faker\Generator::class), __DIR__ . '/../database/factories');
        });
        config()->set('json-api-default', require_once(__DIR__.'/files/json-api.php'));
    }
}
