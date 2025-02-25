<?php

return [
    // Admin
    // ArticleLabels
    "customLabelModel" => null,
    "customLabelObserver" => null,

    // Policy
    "articleLabelPolicyTitle" => "Управление метками",
    "articleLabelPolicy" => \GIS\ArticleLabels\Policies\ArticleLabelPolicy::class,
    "articleLabelPolicyKey" => "article-labels",
];
