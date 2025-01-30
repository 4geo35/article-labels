<?php

namespace GIS\ArticleLabels\Observers;

use GIS\ArticleLabels\Interfaces\ArticleLabelInterface;
use GIS\ArticleLabels\Models\ArticleLabel;

class ArticleLabelObserver
{
    public function creating(ArticleLabelInterface $label): void
    {
        $labelModelClass = config("article-labels.customLabelModel") ?? ArticleLabel::class;
        $priority = $labelModelClass::query()
            ->select("id", "priority")
            ->max("priority");
        if (empty($priority)) $priority = 0;
        $label->priority = $priority + 1;
    }

    public function deleted(ArticleLabelInterface $label): void
    {
        $label->news()->sync([]);
    }
}
