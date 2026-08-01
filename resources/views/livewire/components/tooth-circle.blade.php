@props(['index'])

<div>
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][north]" value="{{ $north }}" />
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][east]" value="{{ $east }}" />
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][south]" value="{{ $south }}" />
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][west]" value="{{ $west }}" />
    <input type="hidden" name="medical_exam[odontogram][{{ $index }}][center]" value="{{ $center }}" />
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="60" viewBox="352 520 103 100">
        <text x="403" y="515" font-size="30" text-anchor="middle" fill="black">{{ $index }}</text>
        <path class="cursor-pointer" fill="{{ $north === 'normal' ? '#fff' : '#000' }}"
            wire:click="change('north', '{{ $north === 'normal' ? 'alteration' : 'normal' }}')" stroke="#000"
            stroke-width="2"
            d="M381,574.5c0,6.2,2.5,11.8,6.6,15.9l-19.5,19.5c-9-9-14.6-21.5-14.6-35.4s5.6-26.3,14.6-35.3l19.5,19.4C383.5,562.7,381,568.3,381,574.5z" />
        <path class="cursor-pointer" fill="{{ $east === 'normal' ? '#fff' : '#000' }}"
            wire:click="change('east', '{{ $east === 'normal' ? 'alteration' : 'normal' }}')" stroke="#000"
            stroke-width="2"
            d="M438.9,609.9c-9,9-21.5,14.6-35.4,14.6s-26.3-5.6-35.4-14.6l19.5-19.5c4.1,4.1,9.7,6.6,15.9,6.6c6.2,0,11.8-2.5,15.9-6.6L438.9,609.9z" />
        <path class="cursor-pointer" fill="{{ $south === 'normal' ? '#fff' : '#000' }}"
            wire:click="change('south', '{{ $south === 'normal' ? 'alteration' : 'normal' }}')" stroke="#000"
            stroke-width="2"
            d="M453.5,574.5c0,13.8-5.6,26.3-14.6,35.4l-19.4-19.5c4.1-4.1,6.6-9.7,6.6-15.9s-2.5-11.8-6.6-15.9l19.4-19.4C447.9,548.2,453.5,560.7,453.5,574.5z" />
        <path class="cursor-pointer" fill="{{ $west === 'normal' ? '#fff' : '#000' }}"
            wire:click="change('west', '{{ $west === 'normal' ? 'alteration' : 'normal' }}')" stroke="#000"
            stroke-width="2"
            d="M426,574.5c0,6.2-2.5,11.8-6.6,15.9c-4.1,4.1-9.7,6.6-15.9,6.6c-6.2,0-11.8-2.5-15.9-6.6c-4.1-4.1-6.6-9.7-6.6-15.9s2.5-11.8,6.6-15.9c4.1-4.1,9.7-6.6,15.9-6.6c6.2,0,11.8,2.5,15.9,6.6C423.5,562.7,426,568.3,426,574.5z" />
        <path class="cursor-pointer" fill="{{ $center === 'normal' ? '#fff' : '#000' }}"
            wire:click="change('center', '{{ $center === 'normal' ? 'alteration' : 'normal' }}')" stroke="#000"
            stroke-width="2"
            d="M438.9,539.2l-19.4,19.4c-4.1-4.1-9.7-6.6-15.9-6.6c-6.2,0-11.8,2.5-15.9,6.6l-19.5-19.4c9-9.1,21.5-14.7,35.4-14.7S429.8,530.1,438.9,539.2z" />
    </svg>
</div>