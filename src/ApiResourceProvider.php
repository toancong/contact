<?php

namespace Bean\Contact;

use Route;
use CloudCreativity\LaravelJsonApi\Api\AbstractProvider;
use CloudCreativity\LaravelJsonApi\Routing\RouteRegistrar;

class ApiResourceProvider extends AbstractProvider
{
    public $resources = [
        'contacts' => Models\Contact::class,
    ];

    /**
     * Mount routes onto the provided API.
     *
     * @param RouteRegistrar $api
     * @return void
     */
    public function mount(RouteRegistrar $api): void
    {
        Route::namespace('\Bean\Contact\Api\Controllers')->group(function () use ($api) {
            $api->resource('contacts');
        });
    }

    /**
     * @return string
     */
    protected function getRootNamespace(): string
    {
        return '\\Bean\\Contact\\Api';
    }
}
