<?php

declare(strict_types=1);

it('registers config', function () {
    expect(config('widgets'))->toBeArray();
    expect(config('widgets.routes.enabled'))->toBeTrue();
});

it('registers routes', function () {
    $routes = collect(app('router')->getRoutes()->getRoutes());

    $hasDemo = $routes->contains(function ($route) {
        return str_contains($route->uri(), 'widgets/demo');
    });

    $hasDocs = $routes->contains(function ($route) {
        return str_contains($route->uri(), 'widgets/docs');
    });

    expect($hasDemo)->toBeTrue();
    expect($hasDocs)->toBeTrue();
});

it('registers view namespace', function () {
    $finder = app('view')->getFinder();
    $hints = $finder->getHints();

    expect($hints)->toHaveKey('widgets');
});
