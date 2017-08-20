<?php

namespace App\Providers;

use App\Services\CloudService;
use App\Services\TagsService;
use Illuminate\Support\ServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use LaravelDoctrine\ORM\DoctrineManager;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Ignore "migrations" table in Doctrine
        $this->app->make(DoctrineManager::class)->onResolve(function (ManagerRegistry $registry) {
            /** @var EntityManager $em */
            $em = $registry->getManager();
            $em->getConfiguration()->setFilterSchemaAssetsExpression('/^((?!migrations).)*$/');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->singleton('Doctrine\ORM\EntityManager', function ($app) {
            // Retrieve our configuration.
            $config = $app['config'];
         //   $connection = $config->get('laravel-doctrine::doctrine.connection');
            $devMode = false;//$config->get('app.debug');

            $cache = null; // Default, let Doctrine decide.

            if (!$devMode) {
                $cache_config = $config->get('laravel-doctrine::doctrine.cache');
                $cache_provider = $cache_config['provider'];
                $cache_provider_config = $cache_config[$cache_provider];

                switch ($cache_provider) {
                    case 'memcache':
                        if (extension_loaded('memcache')) {
                            $memcache = new \Memcache();
                            $memcache->connect($cache_provider_config['host'], $cache_provider_config['port']);
                            $cache = new \Doctrine\Common\Cache\MemcacheCache();
                            $cache->setMemcache($memcache);
                        }
                        break;
                }

            }
        });

        $this->registerServices();
    }

    public function registerServices()
    {
        $this->app->alias(CloudService::class, 'cloud.service');
        $this->app->singleton(CloudService::class, function() {
            return new CloudService();
        });

        $this->app->singleton(TagsService::class, function($app) {
            return new TagsService(
                $app->make(EntityManager::class)
            );
        });
    }
}
