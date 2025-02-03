<div class="mt-indent">
    <x-tt::table drag-root>
        <x-slot name="head">
            <tr>
                <x-tt::table.heading></x-tt::table.heading>
                <x-tt::table.heading class="text-left text-nowrap">Заголовок</x-tt::table.heading>
                <x-tt::table.heading class="text-left text-nowrap">Адресная строка</x-tt::table.heading>
                <x-tt::table.heading>Действия</x-tt::table.heading>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach($labels as $key => $item)
                <tr drag-item="{{ $item->id }}" drag-item-order="{{ $key }}" wire:key="{{ $item->id }}">
                    <td>
                        <x-tt::ico.bars drag-grab class="text-secondary mr-indent cursor-grab" />
                    </td>
                    @if ($displayEdit && $labelId === $item->id)
                        <td colspan="3">
                            <form wire:submit.prevent="update" class="flex flex-col space-y-indent-half md:flex-row md:space-x-indent-half md:space-y-0">
                                <div>
                                    <input type="text" aria-label="Заголовок" placeholder="Заголовок*" required
                                           class="form-control form-control-sm {{ $errors->has('updateTitle') ? 'border-danger' : '' }}"
                                           wire:model="updateTitle" wire:loading.arrt="disabled">
                                    <x-tt::form.error name="updateTitle" />
                                </div>
                                <div>
                                    <input type="text" aria-label="Адресная строка" placeholder="Адресная строка"
                                           class="form-control form-control-sm {{ $errors->has('updateSlug') ? 'border-danger' : '' }}"
                                           wire:model="updateSlug" wire:loading.arrt="disabled">
                                    <x-tt::form.error name="updateSlug" />
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary" wire:loading.attr="disabled">Обновить</button>
                                <button type="button" class="btn btn-sm btn-outline-dark" wire:loading.attr="disabled" wire:click="closeEdit">Отмена</button>
                            </form>
                        </td>
                    @else
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->slug }}</td>
                        <td>
                            <div class="flex justify-center">
                                @if ($displayDelete && $labelId === $item->id)
                                    <button type="button" class="btn btn-sm btn-danger rounded-e-none px-btn-x-ico"
                                            wire:loading.attr="disabled" wire:click="confirmDelete">
                                        OK
                                    </button>
                                    <button type="button" class="btn btn-sm btn-dark rounded-s-none px-btn-x-ico"
                                            wire:loading.attr="disabled" wire:click="closeDelete">
                                        <x-tt::ico.cross />
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-dark px-btn-x-ico rounded-e-none"
                                            wire:loading.attr="disabled"
                                            wire:click="showEdit({{ $item->id }})">
                                        <x-tt::ico.edit />
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger px-btn-x-ico rounded-s-none"
                                            wire:loading.attr="disabled"
                                            wire:click="showDelete({{ $item->id }})">
                                        <x-tt::ico.trash />
                                    </button>
                                @endif
                            </div>
                        </td>
                    @endif
                </tr>
            @endforeach
        </x-slot>
    </x-tt::table>
</div>

@include("tt::admin.draggable-script")
