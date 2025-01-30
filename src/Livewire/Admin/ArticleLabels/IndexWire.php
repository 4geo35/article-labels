<?php

namespace GIS\ArticleLabels\Livewire\Admin\ArticleLabels;

use GIS\ArticleLabels\Interfaces\ArticleLabelInterface;
use GIS\ArticleLabels\Models\ArticleLabel;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    public bool $displayList = false;

    public string $title = "";
    public string $slug = "";

    public int|null $labelId = null;

    public bool $hasSearch = false;

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
        $labelModelClass = config("article-labels.customLabelModel") ?? ArticleLabel::class;
        $labels = $labelModelClass::query()
            ->orderBy("priority")
            ->get();
        return view('al::livewire.admin.article-labels.index-wire', compact("labels"));
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

    public function reorderItems(array $newOrder): void
    {
        foreach ($newOrder as $priority => $id) {
            $this->labelId = $id;
            $label = $this->findLabel();
            if (! $label) continue;
            $label->priority = $priority;
            $label->save();
        }
        $this->resetFields();
    }

    protected function resetFields(): void
    {
        $this->reset("title", "slug", "labelId");
    }

    protected function findLabel(): ?ArticleLabelInterface
    {
        $labelModelClass = config("article-labels.customLabelModel") ?? ArticleLabel::class;
        $label = $labelModelClass::find($this->labelId);
        if (! $label) {
            session()->flash("labels-error", "Метка не найдена");
            return null;
        }
        return $label;
    }
}
