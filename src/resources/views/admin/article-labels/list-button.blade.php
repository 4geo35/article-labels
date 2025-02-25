@can("viewAny", config("article-labels.customLabelModel") ?? \GIS\ArticleLabels\Models\ArticleLabel::class)
    <livewire:al-label-index />
@endcan
