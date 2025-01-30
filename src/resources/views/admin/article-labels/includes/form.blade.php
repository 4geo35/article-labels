<div class="space-y-indent-half">
    <form wire:submit.prevent="store" class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
        <div>
            <input type="text" aria-label="Заголовок" placeholder="Заголовок*" required
                   class="form-control {{ $errors->has('title') ? 'border-danger' : '' }}"
                   wire:model="title" wire:loading.arrt="disabled">
            <x-tt::form.error name="title" />
        </div>
        <div>
            <input type="text" aria-label="Адресная строка" placeholder="Адресная строка"
                   class="form-control {{ $errors->has('slug') ? 'border-danger' : '' }}"
                   wire:model="slug" wire:loading.arrt="disabled">
            <x-tt::form.error name="slug" />
        </div>
        <button type="submit" class="btn btn-primary" wire:loading.arrt="disabled">Добавить</button>
    </form>
    <x-tt::notifications.error prefix="labels-" />
    <x-tt::notifications.success prefix="labels-" />
</div>
