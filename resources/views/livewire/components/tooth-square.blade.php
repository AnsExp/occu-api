@props(['index'])

<div>
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][north]" value="{{ $north }}" />
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][east]" value="{{ $east }}" />
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][south]" value="{{ $south }}" />
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][west]" value="{{ $west }}" />
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][center]" value="{{ $center }}" />
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="353 385 101 100">
        <text x="403" y="370" font-size="30" text-anchor="middle" fill="black">{{ $index }}</text>
        <polygon class="cursor-pointer" fill="{{ $north === 'normal' ? '#fff' : '#000' }}" stroke="#000"
            stroke-width="2" wire:click="change('north', '{{ $north === 'normal' ? 'alteration' : 'normal' }}')"
            points="453.5,385.5 426,413 381,413 353.5,385.5" />
        <polygon class="cursor-pointer" fill="{{ $west === 'normal' ? '#fff' : '#000' }}" stroke="#000" stroke-width="2"
            wire:click="change('west', '{{ $west === 'normal' ? 'alteration' : 'normal' }}')"
            points="381,413 381,458 353.5,485.5 353.5,385.5" />
        <polygon class="cursor-pointer" fill="{{ $south === 'normal' ? '#fff' : '#000' }}" stroke="#000"
            stroke-width="2" wire:click="change('south', '{{ $south === 'normal' ? 'alteration' : 'normal' }}')"
            points="453.5,485.5 353.5,485.5 381,458 426,458" />
        <polygon class="cursor-pointer" fill="{{ $east === 'normal' ? '#fff' : '#000' }}" stroke="#000" stroke-width="2"
            wire:click="change('east', '{{ $east === 'normal' ? 'alteration' : 'normal' }}')"
            points="453.5,385.5 453.5,485.5 426,458 426,413" />
        <rect class="cursor-pointer" x="381" y="413" width="45" height="45"
            fill="{{ $center === 'normal' ? '#fff' : '#000' }}" stroke="#000" stroke-width="2"
            wire:click="change('center', '{{ $center === 'normal' ? 'alteration' : 'normal' }}')" />
    </svg>
</div>