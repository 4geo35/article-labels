<?php

namespace GIS\ArticleLabels;

use GIS\ArticleLabels\Models\ArticleLabel;
use GIS\ArticleLabels\Observers\ArticleLabelObserver;
use Illuminate\Support\Facades\Gate;
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

        // Расширить конфигурацию
        $this->expandConfiguration();

        // Policies
        $this->setPolicies();

        // Observers
        $this->observeModels();
    }

    public function register(): void
    {
        // Migrations
        $this->loadMigrationsFrom(__DIR__ . "/database/migrations");

        // Config
        $this->mergeConfigFrom(__DIR__ . "/config/article-labels.php", "article-labels");
    }

    protected function setPolicies(): void
    {
        Gate::policy(config("article-labels.customLabelModel") ?? ArticleLabel::class, config("article-labels.articleLabelPolicy"));
    }

    protected function observeModels(): void
    {
        $labelObserverClass = config("article-labels.customLabelObserver") ?? ArticleLabelObserver::class;
        $labelModelClass = config("article-labels.customLabelModel") ?? ArticleLabel::class;
        $labelModelClass::observe($labelObserverClass);
    }

    protected function addLivewireComponents(): void
    {
        $component = config("article-labels.customLabelIndexComponent");
        Livewire::component(
            "al-label-index",
            $component ?? LabelIndexWire::class
        );
    }

    protected function expandConfiguration(): void
    {
        $al = app()->config["article-labels"];

        $um = app()->config["user-management"];
        $permissions = $um["permissions"];
        $permissions[] = [
            "title" => $al["articleLabelPolicyTitle"],
            "policy" => $al["articleLabelPolicy"],
            "key" => $al["articleLabelPolicyKey"],
        ];
        app()->config["user-management.permissions"] = $permissions;
    }
}
