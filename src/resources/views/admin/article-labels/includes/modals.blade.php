<x-tt::modal.dialog wire:model="displayList">
    <x-slot name="title">Доступные метки</x-slot>
    <x-slot name="content">
        @include("al::admin.article-labels.includes.form")
        @include("al::admin.article-labels.includes.table")
    </x-slot>
</x-tt::modal.dialog>
