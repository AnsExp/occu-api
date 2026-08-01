<form method="post" action="{{ route('psychology.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <x-input-timezone />
    <input type="hidden" name="order[order_number]" value="{{ $order->order_number }}">
    <x-badge :text="'Paciente: ' . $patient?->first_name . ' ' . $patient?->last_name" />
    <x-badge :text="'Edad: ' . $patient?->birth_date?->age" />
    <x-badge :text="'Género: ' . __('gender.' . $patient?->gender)" />
    <x-badge :text="'Cédula: ' . $patient?->id_card" />
    <x-badge :text="'Fecha de nacimiento: ' . $patient?->birth_date?->translatedFormat('F j, Y')" />
    @if (user_has_role('administrator'))
        <x-card>
            <x-select-control name="doctor[id]" :label="__('attributes.responsible_doctor')" required>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->first_name }}
                        {{ $doctor->last_name }}
                    </option>
                @endforeach
            </x-select-control>
            <p class="mt-1 text-xs text-gray-500">@lang('ophthalmology.test_responsible_doctor')</p>
        </x-card>
    @endif
    <x-card>
        <div class="grid grid-cols-2 gap-2">
            <x-input-control type="file" accept="application/pdf" name="medical_exam[stress_scale]"
                label="Escala de Estrés" required />
            <x-input-control type="file" accept="application/pdf" name="medical_exam[mcmi_iiab_one]"
                label="MCMI-IIAB (1)" required />
            <x-input-control type="file" accept="application/pdf" name="medical_exam[mcmi_iiab_two]"
                label="MCMI-IIAB (2)" required />
            <x-input-control type="file" accept="application/pdf" name="medical_exam[mini_mental_state]"
                label="Mini Mental State (MMSE)" required />
            <x-input-control type="file" accept="application/pdf" name="medical_exam[consent_and_authorization]"
                label="Consentimiento y Autorización de datos personales" required />
            <x-input-control type="file" accept="application/pdf" name="medical_exam[informed_consent]"
                label="Consentimiento informado para evaluación psicológica" required />
            <x-input-control type="file" accept="application/pdf" name="medical_exam[roadmap]" label="Hoja de ruta"
                required />
        </div>
    </x-card>
    <x-button type="submit" variant="base">
        @lang('button.create')
    </x-button>
</form>