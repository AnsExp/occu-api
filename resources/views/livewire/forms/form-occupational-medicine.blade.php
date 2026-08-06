<form method="post" action="{{ route('occupational_medicine.store') }}" class="space-y-6">
    @csrf
    <x-input-timezone />
    <input type="hidden" name="medical_date[id]" value="{{ $medicalDate->id }}">
    <x-badge :text="'Paciente: ' . $medicalDate?->patient?->person->fullname" />
    <x-section-header title="Declaración jurada del paciente" />
    <x-card>
        <div class="space-y-6">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($declarationQuestionsPart1 as $question)
                    <div class="rounded-lg border border-gray-200 bg-white p-3">
                        <x-label-control required>
                            {{ __('occupational_medicine.' . $question) }}
                        </x-label-control>
                        <div class="mt-3 flex items-center gap-4">
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input type="radio" value="1"
                                    name="medical_exam[declarations][0][questions][{{ $question }}]" required
                                    class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900"
                                    wire:model.lazy="declarationResultsPart1.{{ $loop->index }}" />
                                @lang('attributes.yes')
                            </label>
                            <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                <input type="radio" value="0"
                                    name="medical_exam[declarations][0][questions][{{ $question }}]" required
                                    class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900"
                                    wire:model.lazy="declarationResultsPart1.{{ $loop->index }}" />
                                @lang('attributes.no')
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            @if (in_array(1, $declarationResultsPart1))
                <x-textarea-control name="medical_exam[declarations][0][aclarations]"
                    wire:model.lazy="declarationAcclarationsPart1"
                    label="Si respondió 'Sí' a alguna de las preguntas, indique detalles" rows="5" required />
            @endif
        </div>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($declarationQuestionsPart2 as $question)
                <div class="rounded-lg border border-gray-200 bg-white p-3">
                    <x-label-control required>
                        {{ __('occupational_medicine.' . $question) }}
                    </x-label-control>
                    <div class="mt-3 flex items-center gap-4">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="radio" name="medical_exam[declarations][1][questions][{{ $question }}]" value="1"
                                wire:model.lazy="declarationResultsPart2.{{ $loop->index }}" required
                                class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                            @lang('attributes.yes')
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="radio" name="medical_exam[declarations][1][questions][{{ $question }}]" value="0"
                                wire:model.lazy="declarationResultsPart2.{{ $loop->index }}" required
                                class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                            @lang('attributes.no')
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        @if (in_array(1, $declarationResultsPart2))
            <x-textarea-control name="medical_exam[declarations][1][aclarations]"
                wire:model.lazy="declarationAcclarationsPart2"
                label="Si respondió 'Sí' a alguna de las preguntas, indique detalles" rows="5" required />
        @endif
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($declarationQuestionsPart3 as $question)
                <div class="rounded-lg border border-gray-200 bg-white p-3">
                    <x-label-control required>
                        {{ __('occupational_medicine.' . $question) }}
                    </x-label-control>
                    <div class="mt-3 flex items-center gap-4">
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="radio" name="medical_exam[declarations][2][questions][{{ $question }}]" value="1"
                                wire:model.lazy="declarationResultsPart3.{{ $loop->index }}" required
                                class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                            @lang('attributes.yes')
                        </label>
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                            <input type="radio" name="medical_exam[declarations][2][questions][{{ $question }}]" value="0"
                                wire:model.lazy="declarationResultsPart3.{{ $loop->index }}" required
                                class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                            @lang('attributes.no')
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
        @if (in_array(1, $declarationResultsPart3))
            <x-textarea-control name="medical_exam[declarations][2][aclarations]"
                wire:model.lazy="declarationAcclarationsPart3"
                label="Si respondió 'Sí' a alguna de las preguntas, indique detalles" rows="5" required />
        @endif
    </x-card>
    <x-section-header title="Datos Clínicos" />
    <x-card>
        <div class="space-y-4">
            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4" wire:ignore>
                <div>
                    <x-input-control name="medical_exam[clinical_data][height]" label="Altura" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[clinical_data][weight]" label="Peso (kg)" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[clinical_data][pulse]" label="Pulso" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[clinical_data][blood_pressure_systolic]"
                        label="Presión arterial sistólica" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[clinical_data][blood_pressure_diastolic]"
                        label="Presión arterial diastólica (mmHg)" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[clinical_data][emo]" label="EMO" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[clinical_data][glucose]" label="Glucosa" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[clinical_data][protein]" label="Proteína" required />
                </div>
                <div>
                    <x-select-control name="medical_exam[clinical_data][blood_type]" label="Tipo de sangre" required>
                        @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bloodType)
                            <option value="{{ $bloodType }}">{{ $bloodType }}</option>
                        @endforeach
                    </x-select-control>
                </div>
            </div>
            <div class="grid gap-4 lg:grid-cols-3">
                <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                    <table class="min-w-[320px] w-full border-collapse text-xs text-gray-800 sm:text-sm">
                        <thead>
                            <tr>
                                <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-left">Evaluación</th>
                                <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">Normal</th>
                                <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">Anormal</th>
                            </tr>
                        </thead>
                        @foreach ($clinicalChecks as $chunk)
                            <tbody>
                                <tr>
                                    <td class="border border-gray-200 px-2 py-2 font-medium">
                                        <x-label-control name="medical_exam[clinical_data][checks][{{ $chunk }}]" required>
                                            {{ __('occupational_medicine.' . $chunk) }}
                                        </x-label-control>
                                    </td>
                                    <td class="border border-gray-200 text-center">
                                        <input required type="radio"
                                            name="medical_exam[clinical_data][checks][{{ $chunk }}]" value="normal"
                                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                    </td>
                                    <td class="border border-gray-200 text-center">
                                        <input required type="radio"
                                            name="medical_exam[clinical_data][checks][{{ $chunk }}]" value="abnormal"
                                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
            <x-textarea-control name="medical_exam[clinical_data][observations]" :label="__('attributes.observations')"
                rows="4" />
            <div class="grid gap-3 grid-cols-2">
                <x-label-control name="medical_exam[clinical_data][chest_xray][status]" required>
                    Radiografía de tórax
                </x-label-control>
                <div class="flex items-center gap-2">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input required type="radio" name="medical_exam[clinical_data][chest_xray][status]"
                            value="was_done" wire:model.lazy="do_torax_radiography"
                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                        Se hizo
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input required type="radio" name="medical_exam[clinical_data][chest_xray][status]"
                            value="not_done" wire:model.lazy="do_torax_radiography"
                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                        No se hizo
                    </label>
                </div>
            </div>
            @if ($do_torax_radiography === 'was_done')
                <div wire:ignore>
                    <x-input-control type="date" name="medical_exam[clinical_data][chest_xray][date]"
                        label="Fecha en que se realizó" required />
                    <x-textarea-control name="medical_exam[clinical_data][chest_xray][result]" label="Resultado" rows="4"
                        required />
                </div>
            @endif
        </div>
    </x-card>
    <x-section-header title="Otras pruebas de diagnóstico y resultados" />
    <x-card>
        <div class="space-y-4">
            <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                <table class="min-w-[820px] w-full border-collapse text-xs text-gray-800 sm:text-sm">
                    <thead>
                        <tr>
                            <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-left">Prueba</th>
                            <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">Normal</th>
                            <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">Anormal</th>
                            <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-left">Resultado / detalle
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($diagnostics as $diagnostic)
                            <tr>
                                <td class="border border-gray-200 bg-gray-50 px-2 py-2 font-medium">
                                    <x-label-control name="medical_exam[other_tests][{{ $loop->index }}][result]" required>
                                        {{ __('occupational_medicine.' . $diagnostic) }}
                                    </x-label-control>
                                </td>
                                <td class="border border-gray-200 text-center">
                                    <input required type="radio"
                                        name="medical_exam[other_tests][{{ $loop->index }}][status]" value="normal"
                                        class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                </td>
                                <td class="border border-gray-200 text-center">
                                    <input required type="radio"
                                        name="medical_exam[other_tests][{{ $loop->index }}][status]" value="abnormal"
                                        class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                </td>
                                <td class="border border-gray-200 p-1.5">
                                    <input type="hidden" name="medical_exam[other_tests][{{ $loop->index }}][test]"
                                        value="{{ $diagnostic }}" />
                                    <x-input-control name="medical_exam[other_tests][{{ $loop->index }}][result]" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="grid gap-3 sm:grid-cols-1 lg:grid-cols-2" wire:ignore>
                <div>
                    <x-input-control name="medical_exam[ecg]" label="ECG" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[koh]" label="KOH" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[vdrl]" label="VDRL" required />
                </div>
                <div>
                    <x-input-control name="medical_exam[copro]" label="Copro" required />
                </div>
                <div>
                    <x-textarea-control name="medical_exam[psychological_assessment]" label="Valoración psicológica"
                        rows="4" />
                </div>
                <div>
                    <x-textarea-control name="medical_exam[dental_assessment]" label="Valoración odontológica"
                        rows="4" />
                </div>
                <div>
                    <x-textarea-control name="medical_exam[extra_tests]" label="Otras pruebas" rows="4" />
                </div>
            </div>
        </div>
    </x-card>
    <x-section-header title="Evaluación de la aptitud para servicio en el mar"
        description="Sobre la base de la declaración de la persona examinada, mi conocimiento clínico y los resultados de las pruebas de diagnóstico, declaro que la persona examinada es:" />
    <x-card>
        <div class="space-y-4">
            <div class="my-6 grid grid-cols-3 gap-6 items-center space-beetween">
                <x-label-control required>
                    Apto para el servicio de vigía
                </x-label-control>
                <div class="inline-block gap-2">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input required type="radio" name="medical_exam[aptitude_eval][watchkeeping]" value="fit"
                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                        Apto
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input required type="radio" name="medical_exam[aptitude_eval][watchkeeping]" value="unfit"
                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                        No apto
                    </label>
                </div>
            </div>
            <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                <table class="min-w-[760px] w-full border-collapse text-xs text-gray-800 sm:text-sm">
                    <thead>
                        <tr>
                            <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-left"> </th>
                            @foreach ($services as $service)
                                <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                                    @lang('occupational_medicine.' . $service)
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-gray-200 bg-gray-50 px-2 py-2 font-medium">Apto</td>
                            @foreach ($services as $service)
                                <td class="border border-gray-200 text-center">
                                    <input required type="radio"
                                        name="medical_exam[aptitude_eval][service_matrix][{{ $service }}]" value="fit"
                                        class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                </td>
                            @endforeach
                        </tr>
                        <tr>
                            <td class="border border-gray-200 bg-gray-50 px-2 py-2 font-medium">No apto</td>
                            @foreach ($services as $service)
                                <td class="border border-gray-200 text-center">
                                    <input required type="radio"
                                        name="medical_exam[aptitude_eval][service_matrix][{{ $service }}]" value="unfit"
                                        class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="grid gap-3 sm:grid-cols-2">
                <div class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2">
                    <label class="text-sm font-medium text-gray-700">
                        Sin restricciones
                        <input required type="radio" name="medical_exam[aptitude_eval][restrictions]" value="0"
                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900"
                            wire:model.lazy="has_restrictions" />
                    </label>
                </div>
                <div class="flex items-center gap-3 rounded-lg border border-gray-200 bg-white px-3 py-2">
                    <label class="text-sm font-medium text-gray-700">
                        Con restricciones
                        <input required type="radio" name="medical_exam[aptitude_eval][restrictions]" value="1"
                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900"
                            wire:model.lazy="has_restrictions" />
                    </label>
                </div>
            </div>
            <div class="space-y-3">
                @if ($has_restrictions === '1')
                    <div>
                        <x-textarea-control name="medical_exam[aptitude_eval][restriction_description]"
                            :label="__('attributes.description')" rows="4" required />
                    </div>
                @endif
                <div>
                    <x-textarea-control name="medical_exam[aptitude_eval][observations]"
                        :label="__('attributes.observations')" rows="4" />
                </div>
            </div>
            <div class="my-6 grid grid-cols-2 gap-6 items-center space-beetween">
                <x-label-control required>
                    Obligación de llevar lentes correctores
                </x-label-control>
                <div class="inline-block gap-2">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input required type="radio" name="medical_exam[aptitude_eval][corrective_lenses]" value="1"
                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                        Sí
                    </label>
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                        <input required type="radio" name="medical_exam[aptitude_eval][corrective_lenses]" value="0"
                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                        No </label>
                </div>
            </div>
        </div>
    </x-card>
    <x-button class="w-full" type="submit" variant="base">
        @lang('button.create')
    </x-button>
</form>