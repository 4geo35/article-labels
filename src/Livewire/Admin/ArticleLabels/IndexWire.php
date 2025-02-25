<?php

namespace GIS\ArticleLabels\Livewire\Admin\ArticleLabels;

use GIS\ArticleLabels\Interfaces\ArticleLabelInterface;
use GIS\ArticleLabels\Models\ArticleLabel;
use Illuminate\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    public bool $displayList = false;
    public bool $displayEdit = false;
    public bool $displayDelete = false;

    public string $title = "";
    public string $slug = "";

    public string $updateTitle = "";
    public string $updateSlug = "";

    public int|null $labelId = null;

    public bool $hasSearch = false;

    public function rules(): array
    {
        if ($this->labelId) {
            return [
                "updateTitle" => ["required", "string", "max:50"],
                "updateSlug" => ["nullable", "string", "max:50", "unique:article_labels,slug,{$this->labelId}"],
            ];
        } else {
            return [
                "title" => ["required", "string", "max:50"],
                "slug" => ["nullable", "string", "max:50", "unique:article_labels,slug"],
            ];
        }
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
        if (! $this->checkAuth("viewAny")) return;
        $this->displayList = true;
    }

    public function store(): void
    {
        if (! $this->checkAuth("create")) return;
        $this->validate();

        $labelModelClass = config("article-labels.customLabelModel") ?? ArticleLabel::class;
        $labelModelClass::create([
            "title" => $this->title,
            "slug" => $this->slug,
        ]);

        session()->flash("labels-success", "Метка успешно добавлена");
        $this->dispatch("update-list");
    }

    public function closeList(): void
    {
        $this->resetFields();
        $this->displayList = false;
    }

    public function showEdit(int $labelId): void
    {
        $this->resetFields();
        $this->labelId = $labelId;
        $label = $this->findLabel();
        if (! $label) return;
        if (! $this->checkAuth("update", $label)) return;

        $this->displayEdit = true;
        $this->updateTitle = $label->title;
        $this->updateSlug = $label->slug;
    }

    public function update(): void
    {
        $label = $this->findLabel();
        if (! $label) return;
        if (! $this->checkAuth("update", $label)) return;

        $this->validate();
        $label->update([
            "title" => $this->updateTitle,
            "slug" => $this->updateSlug,
        ]);

        session()->flash("labels-success", "Метка успешно обновлена");
        $this->closeEdit();
        $this->dispatch("update-list");
    }

    public function closeEdit(): void
    {
        $this->resetFields();
        $this->displayEdit = false;
    }

    public function showDelete(int $labelId): void
    {
        $this->resetFields();
        $this->labelId = $labelId;
        $label = $this->findLabel();
        if (! $label) return;
        if (! $this->checkAuth("delete", $label)) return;

        $this->displayDelete = true;
    }

    public function confirmDelete(): void
    {
        $label = $this->findLabel();
        if (! $label) return;
        if (! $this->checkAuth("delete", $label)) return;

        $label->delete();
        $this->displayDelete = false;
        $this->resetFields();
        session()->flash("labels-success", "Метка успешно удалена");
        $this->dispatch("update-list");
    }

    public function closeDelete(): void
    {
        $this->resetFields();
        $this->displayDelete = false;
    }

    public function reorderItems(array $newOrder): void
    {
        if (! $this->checkAuth("order")) return;

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
        $this->reset("title", "slug", "labelId", "updateTitle", "updateSlug");
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

    protected function checkAuth(string $action, ArticleLabelInterface $label = null): bool
    {
        try {
            $labelModelClass = config("article-labels.customLabelModel") ?? ArticleLabel::class;
            $this->authorize($action, $label ?? $labelModelClass);
            return true;
        } catch (\Exception $exception) {
            session()->flash("labels-error", __("Unauthorized action"));
            $this->closeDelete();
            $this->closeEdit();
            return false;
        }
    }
}
