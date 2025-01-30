<?php

namespace GIS\ArticleLabels\Livewire\Admin\ArticleLabels;

use GIS\ArticleLabels\Models\ArticleLabel;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    public bool $displayList = false;

    public string $title = "";
    public string $slug = "";

    public int|null $labelId = null;

    public function rules(): array
    {
        $uniqueCondition = "unique:article_labels,slug";
        if ($this->labelId) $uniqueCondition .= ",{$this->labelId}";
        return [
            "title" => ["required", "string", "max:50"],
            "slug" => ["nullable", "string", "max:50", $uniqueCondition],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "title" => "Заголовок",
            "slug" => "Адресная строка"
        ];
    }

    public function render(): View
    {
        return view('al::livewire.admin.article-labels.index-wire');
    }

    public function showList(): void
    {
        $this->resetFields();
        $this->displayList = true;
    }

    public function store(): void
    {
        $this->validate();

        $labelModelClass = config("article-labels.customLabelModel") ?? ArticleLabel::class;
        $labelModelClass::create([
            "title" => $this->title,
            "slug" => $this->slug,
        ]);

        session()->flash("labels-success", "Метка успешно добавлена");
    }

    public function closeList(): void
    {
        $this->resetFields();
        $this->displayList = false;
    }

    protected function resetFields(): void
    {
        $this->reset("title", "slug", "labelId");
    }
}
