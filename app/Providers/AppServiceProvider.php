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
