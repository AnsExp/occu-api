<form method="get" wire:submit.prevent="searchPatient">
    <div class="flex gap-4 items-center">
        <div class="w-10/12">
            <x-input-control name="id_card" wire:model="id_card" placeholder="1234567890" required />
        </div>
        <x-button class="w-2/12" type="submit" variant="base">@lang('button.search')</x-button>
    </div>
</form>