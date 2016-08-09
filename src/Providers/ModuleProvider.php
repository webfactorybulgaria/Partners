<?php

namespace TypiCMS\Modules\Partners\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Shells\Facades\TypiCMS;
use TypiCMS\Modules\Core\Shells\Observers\FileObserver;
use TypiCMS\Modules\Core\Shells\Observers\SlugObserver;
use TypiCMS\Modules\Core\Shells\Services\Cache\LaravelCache;
use TypiCMS\Modules\Partners\Shells\Models\Partner;
use TypiCMS\Modules\Partners\Shells\Models\PartnerTranslation;
use TypiCMS\Modules\Partners\Shells\Repositories\CacheDecorator;
use TypiCMS\Modules\Partners\Shells\Repositories\EloquentPartner;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.partners'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['partners' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'partners');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'partners');

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/partners'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        AliasLoader::getInstance()->alias(
            'Partners',
            'TypiCMS\Modules\Partners\Shells\Facades\Facade'
        );

        // Observers
        PartnerTranslation::observe(new SlugObserver());
        Partner::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Partners\Shells\Providers\RouteServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Partners\Shells\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('partners::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('partners');
        });

        $app->bind('TypiCMS\Modules\Partners\Shells\Repositories\PartnerInterface', function (Application $app) {
            $repository = new EloquentPartner(new Partner());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'partners', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
