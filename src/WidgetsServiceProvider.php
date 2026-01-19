<?php

declare(strict_types=1);

namespace Accelade\Widgets;

use Accelade\Docs\DocsRegistry;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WidgetsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/widgets.php', 'widgets');
    }

    public function boot(): void
    {
        $this->configurePublishing();
        $this->configureComponents();
        $this->configureRoutes();
        $this->registerDocs();
    }

    protected function configurePublishing(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/widgets.php' => config_path('widgets.php'),
        ], 'widgets-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/widgets'),
        ], 'widgets-views');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/widgets'),
        ], 'widgets-assets');
    }

    protected function configureComponents(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'widgets');

        // Register anonymous blade components with a different prefix to avoid conflicts
        // with PHP class-based widget components
        Blade::anonymousComponentPath(__DIR__.'/../resources/views/components', 'widgets');

        // Register class-based widgets as blade components
        // These use render() method which renders the anonymous component views
    }

    protected function configureRoutes(): void
    {
        if (! config('widgets.routes.enabled', true)) {
            return;
        }

        Route::group([
            'prefix' => config('widgets.routes.prefix', 'widgets'),
            'middleware' => config('widgets.routes.middleware', ['web']),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Register documentation into Accelade's docs registry.
     */
    protected function registerDocs(): void
    {
        if (! config('widgets.docs.enabled', true)) {
            return;
        }

        // Check if accelade.docs is available
        if (! $this->app->bound('accelade.docs')) {
            return;
        }

        /** @var DocsRegistry $docs */
        $docs = $this->app->make('accelade.docs');

        // Register widgets package documentation path
        $docs->registerPackage('widgets', __DIR__.'/../docs');

        // Register widgets navigation group
        $docs->registerGroup('widgets', 'Widgets', 'layout', 40);

        // Register sub-groups within Widgets
        $docs->registerSubgroup('widgets', 'widget-types', '📊 Widget Types', '', 10);

        // Register widget documentation sections
        $this->registerWidgetDocs($docs);
    }

    /**
     * Register widget documentation sections.
     */
    protected function registerWidgetDocs(DocsRegistry $docs): void
    {
        // Main entry - no subgroup
        $docs->section('widgets')
            ->label('Widgets')
            ->markdown('getting-started.md')
            ->demo()
            ->icon('📊')
            ->package('widgets')
            ->inGroup('widgets')
            ->register();

        // Widget Types subgroup
        $docs->section('stats-widget')
            ->label('Stats Widget')
            ->markdown('stats-widget.md')
            ->demo()
            ->icon('📈')
            ->package('widgets')
            ->inGroup('widgets')
            ->inSubgroup('widget-types')
            ->register();

        $docs->section('chart-widget')
            ->label('Chart Widget')
            ->markdown('chart-widget.md')
            ->demo()
            ->icon('📉')
            ->package('widgets')
            ->inGroup('widgets')
            ->inSubgroup('widget-types')
            ->register();

        $docs->section('table-widget')
            ->label('Table Widget')
            ->markdown('table-widget.md')
            ->demo()
            ->icon('📋')
            ->package('widgets')
            ->inGroup('widgets')
            ->inSubgroup('widget-types')
            ->register();

        $docs->section('calendar-widget')
            ->label('Calendar Widget')
            ->markdown('calendar-widget.md')
            ->demo()
            ->icon('📅')
            ->package('widgets')
            ->inGroup('widgets')
            ->inSubgroup('widget-types')
            ->register();
    }
}
