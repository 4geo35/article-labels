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
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->slug }}</td>
                    <td></td>
                </tr>
            @endforeach
        </x-slot>
    </x-tt::table>
</div>

@include("tt::admin.draggable-script")
