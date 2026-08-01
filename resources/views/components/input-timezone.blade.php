@props(['name' => 'timezone'])
<input type="hidden" name="{{ $name }}" value class="input-timezone" wire:ignore />
@pushOnce('scripts')
<script src="{{ asset('js/input-timezone.js') }}"></script>
@endpushOnce