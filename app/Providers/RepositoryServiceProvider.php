<?php

namespace App\Providers;

use App\Repositories\Entry\EntryInterface;
use App\Repositories\Entry\EntryRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EntryInterface::class, EntryRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD)
     *
     */
    public function boot()
    {
    }
}
