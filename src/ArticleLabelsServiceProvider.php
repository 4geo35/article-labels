<?php

namespace GIS\ArticleLabels;

use GIS\ArticleLabels\Models\ArticleLabel;
use GIS\ArticleLabels\Observers\ArticleLabelObserver;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use GIS\ArticleLabels\Livewire\Admin\ArticleLabels\IndexWire as LabelIndexWire;

class ArticleLabelsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Views
        $this->loadViewsFrom(__DIR__ . "/resources/views", "al");

        // Livewire
        $this->addLivewireComponents();

        // Observers
        $labelObserverClass = config("article-labels.customLabelObserver") ?? ArticleLabelObserver::class;
        $labelModelClass = config("article-labels.customLabelModel") ?? ArticleLabel::class;
        $labelModelClass::observe($labelObserverClass);
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
        $component = config("article-labels.customLabelIndexComponent");
        Livewire::component(
            "al-label-index",
            $component ?? LabelIndexWire::class
        );
    }
}
