<div class="grid grid-cols-2">
    <div class="flex flex-cols-10 mx-auto gap-2">
        @for ($index = 18; $index >= 11; $index--)
            <livewire:components.tooth-square :index="$index" />
        @endfor
    </div>
    <div class="flex flex-cols-10 mx-auto gap-2">
        @for ($index = 21; $index <= 28; $index++)
            <livewire:components.tooth-square :index="$index" />
        @endfor
    </div>
    <div class="flex flex-cols-10 mx-auto gap-2">
        @for ($index = 55; $index >= 51; $index--)
            <livewire:components.tooth-circle :index="$index" />
        @endfor
    </div>
    <div class="flex flex-cols-10 mx-auto gap-2">
        @for ($index = 61; $index <= 65; $index++)
            <livewire:components.tooth-circle :index="$index" />
        @endfor
    </div>
    <div class="flex flex-cols-10 mx-auto gap-2">
        @for ($index = 85; $index >= 81; $index--)
            <livewire:components.tooth-circle :index="$index" />
        @endfor
    </div>
    <div class="flex flex-cols-10 mx-auto gap-2">
        @for ($index = 71; $index <= 75; $index++)
            <livewire:components.tooth-circle :index="$index" />
        @endfor
    </div>
    <div class="flex flex-cols-10 mx-auto gap-2">
        @for ($index = 48; $index >= 41; $index--)
            <livewire:components.tooth-square :index="$index" />
        @endfor
    </div>
    <div class="flex flex-cols-10 mx-auto gap-2">
        @for ($index = 31; $index <= 38; $index++)
            <livewire:components.tooth-square :index="$index" />
        @endfor
    </div>
</div>
