<table class="w-full">
    <thead>
        <tr>
            <th class="px-4 py-2 text-left w-5/12">
                <x-label-control :required="!empty($metadata)">
                    Campo
                </x-label-control>
            </th>
            <th class="px-4 py-2 text-left w-5/12">
                <x-label-control :required="!empty($metadata)">
                    Valor
                </x-label-control>
            </th>
            <th class="px-4 py-2 text-left w-2/12">
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($metadata as $key => $value)
            <tr>
                <td class="px-4 py-2 w-5/12">
                    <x-input-control name="metadata[{{ $key }}][key]" placeholder="Campo Obligatorio"
                        wire:model="metadata.{{ $key }}.key" required />
                </td>
                <td class="px-4 py-2 w-5/12">
                    <x-input-control name="metadata[{{ $key }}][value]" placeholder="Valor Obligatorio"
                        wire:model="metadata.{{ $key }}.value" required />
                </td>
                <td class="px-4 py-2 w-2/12">
                    <x-button type="button" variant="secondary" class="w-full" wire:click="removeMetadata({{ $key }})">
                        <x-heroicon-o-trash class="size-4" />
                    </x-button>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">
                <x-button type="button" class="w-full" wire:click="addMetadata">
                    <x-heroicon-o-plus class="size-4" />
                </x-button>
            </td>
        </tr>
    </tfoot>
</table>