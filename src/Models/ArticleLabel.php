<?php

namespace GIS\ArticleLabels\Models;

use GIS\ArticleLabels\Interfaces\ArticleLabelInterface;
use GIS\ArticlePages\Models\Article;
use GIS\TraitsHelpers\Traits\ShouldSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleLabel extends Model implements ArticleLabelInterface
{
    use ShouldSlug;

    protected $fillable = [
        "title",
        "slug",
    ];

    public function news(): BelongsToMany
    {
        $articleModelClass = config("article-pages.customArticleModel") ?? Article::class;
        return $this->belongsToMany($articleModelClass);
    }
}
