@props(['message' => null])

@if ($errors->any())
    <div class="mb-6 rounded-xl border border-red-300 bg-red-50 px-4 py-3 shadow-sm">
        @if ($message)
            <div class="flex items-center gap-2 text-red-700">
                <p class="font-semibold">{{ $message }}</p>
            </div>
        @endif
        <ul class="mt-2 space-y-1 text-sm text-red-600 list-disc pl-6">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif