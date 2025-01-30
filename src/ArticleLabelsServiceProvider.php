<?php

namespace GIS\ArticleLabels;

use Illuminate\Support\ServiceProvider;

class ArticleLabelsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Views
        $this->loadViewsFrom(__DIR__ . "/resources/views", "al");

        // Livewire
        $this->addLivewireComponents();
    }

    public function register(): void
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");

        // Config
        $this->mergeConfigFrom(__DIR__ . "/config/article-labels.php", "article-labels");
    }

    protected function addLivewireComponents(): void
    {

    }
}
