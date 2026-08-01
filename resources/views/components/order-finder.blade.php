<form method="get">
    <div class="flex gap-4 items-under">
        <div class="w-full">
            <x-input-control name="order_number" :value="request('order_number')" placeholder="1234567" />
        </div>
        <x-button type="submit" variant="base">
            @lang('button.search')
        </x-button>
    </div>
</form>