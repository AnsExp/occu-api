<form method="post"
    action="{{ $medicalDate->certificate_id ? route('ophthalmology.update', $medicalDate->certificate) : route('ophthalmology.store') }}"
    class="space-y-6">
    @csrf
    @if ($medicalDate->certificate_id)
        @method('PUT')
    @endif
    <x-input-timezone />
    <input type="hidden" name="medical_date[id]" value="{{ $medicalDate->id }}">
    <input type="hidden" name="specialty[id]" value="{{ $medicalDate->specialty->id }}">
    <x-badge :text="'Paciente: ' . $medicalDate->patient->personalData->fullname" />
    <div class="rounded-xl border border-gray-200 bg-gray-50/60 p-4">
        <div class="grid gap-4 lg:grid-cols-2">
            <div>
                <x-select-control name="medical_exam[corrective_lenses][usage]"
                    :label="__('ophthalmology.corrective_lenses_usage')" wire:model.lazy="correctiveLenses" required>
                    @foreach (['no_usage', 'glasses', 'contact_lenses', 'both'] as $option)
                        <option value="{{ $option }}" @selected(old('medical_exam.corrective_lenses.usage', $snapshot['corrective_lenses']['usage'] ?? '') === $option)>
                            {{ __('ophthalmology.lenses_usage.' . $option) }}
                        </option>
                    @endforeach
                </x-select-control>
            </div>
            @if($correctiveLenses && $correctiveLenses !== 'no_usage')
                <div>
                    <x-textarea-control name="medical_exam[corrective_lenses][function]" label="Función de los lentes"
                        required
                        rows="4">{{ old('medical_exam.corrective_lenses.function', $snapshot['corrective_lenses']['function'] ?? '') }}</x-textarea-control>
                </div>
            @endif
        </div>
    </div>

    <div class="space-y-3 rounded-xl border border-gray-200 bg-white p-4">
        <h4 class="text-sm font-semibold tracking-wide text-gray-800">@lang('ophthalmology.vision') <span
                class="text-red-600">*</span></h4>
        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
            <table class="w-full min-w-[760px] border-collapse text-xs text-gray-800 sm:text-sm" wire:ignore>
                <thead>
                    <tr>
                        <th class="border border-gray-200 bg-gray-50 px-2 py-2"></th>
                        <th colspan="3" class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                            @lang('ophthalmology.without_correction')
                        </th>
                        <th colspan="3" class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                            @lang('ophthalmology.with_correction')
                        </th>
                    </tr>
                    <tr>
                        <th class="border border-gray-200 bg-gray-50 px-2 py-2"></th>
                        <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                            @lang('ophthalmology.right_eye')
                        </th>
                        <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                            @lang('ophthalmology.left_eye')
                        </th>
                        <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                            @lang('ophthalmology.both_eyes')
                        </th>
                        <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                            @lang('ophthalmology.right_eye')
                        </th>
                        <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                            @lang('ophthalmology.left_eye')
                        </th>
                        <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                            @lang('ophthalmology.both_eyes')
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-200 bg-gray-50 px-2 py-2 font-medium">
                            @lang('ophthalmology.distance')
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][distance][without][right]"
                                :value="old('medical_exam.visual_acuity.distance.without.right', $snapshot['visual_acuity']['distance']['without']['right'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][distance][without][left]"
                                :value="old('medical_exam.visual_acuity.distance.without.left', $snapshot['visual_acuity']['distance']['without']['left'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][distance][without][both]"
                                :value="old('medical_exam.visual_acuity.distance.without.both', $snapshot['visual_acuity']['distance']['without']['both'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][distance][with][right]"
                                :value="old('medical_exam.visual_acuity.distance.with.right', $snapshot['visual_acuity']['distance']['with']['right'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][distance][with][left]"
                                :value="old('medical_exam.visual_acuity.distance.with.left', $snapshot['visual_acuity']['distance']['with']['left'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][distance][with][both]"
                                :value="old('medical_exam.visual_acuity.distance.with.both', $snapshot['visual_acuity']['distance']['with']['both'] ?? '')" required />
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-200 bg-gray-50 px-2 py-2 font-medium">
                            @lang('ophthalmology.near')
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][near][without][right]"
                                :value="old('medical_exam.visual_acuity.near.without.right', $snapshot['visual_acuity']['near']['without']['right'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][near][without][left]"
                                :value="old('medical_exam.visual_acuity.near.without.left', $snapshot['visual_acuity']['near']['without']['left'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][near][without][both]"
                                :value="old('medical_exam.visual_acuity.near.without.both', $snapshot['visual_acuity']['near']['without']['both'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][near][with][right]"
                                :value="old('medical_exam.visual_acuity.near.with.right', $snapshot['visual_acuity']['near']['with']['right'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][near][with][left]"
                                :value="old('medical_exam.visual_acuity.near.with.left', $snapshot['visual_acuity']['near']['with']['left'] ?? '')" required />
                        </td>
                        <td class="border border-gray-200 p-1">
                            <x-input-control name="medical_exam[visual_acuity][near][with][both]"
                                :value="old('medical_exam.visual_acuity.near.with.both', $snapshot['visual_acuity']['near']['with']['both'] ?? '')" required />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="space-y-3 rounded-xl border border-gray-200 bg-white p-4">
            <h4 class="text-sm font-semibold tracking-wide text-gray-800">@lang('ophthalmology.visual_fields')</h4>
            <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                <table class="w-full min-w-[300px] border-collapse text-xs text-gray-800 sm:text-sm">
                    <thead>
                        <tr>
                            <th class="border border-gray-200 bg-gray-50 px-2 py-2"></th>
                            <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                                @lang('ophthalmology.normal')
                            </th>
                            <th class="border border-gray-200 bg-gray-50 px-2 py-2 text-center">
                                @lang('ophthalmology.defective')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['right', 'left'] as $eyeKey)
                            <tr>
                                <td class="border border-gray-200 bg-gray-50 px-2 py-2 font-medium">
                                    {{ ucfirst($eyeKey) }} <span class="text-red-600">*</span>
                                </td>
                                <td class="border border-gray-200 text-center">
                                    <input required type="radio" name="medical_exam[visual_field][{{ $eyeKey }}]"
                                        value="normal" @checked(old('medical_exam.visual_field.' . $eyeKey, $snapshot['visual_field'][$eyeKey] ?? '') === 'normal')
                                        class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                </td>
                                <td class="border border-gray-200 text-center">
                                    <input required type="radio" name="medical_exam[visual_field][{{ $eyeKey }}]"
                                        value="defective" @checked(old('medical_exam.visual_field.' . $eyeKey, $snapshot['visual_field'][$eyeKey] ?? '') === 'defective')
                                        class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-3 rounded-xl border border-gray-200 bg-white p-4">
            <h4 class="text-sm font-semibold tracking-wide text-gray-800">Visión cromática <span
                    class="text-red-600">*</span></h4>
            <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                <table class="w-full min-w-[260px] border-collapse text-xs text-gray-800 sm:text-sm">
                    <tbody>
                        @foreach (['not_tested', 'doubtful', 'normal', 'defective'] as $index => $statusLabel)
                            <tr>
                                <td class="border border-gray-200 bg-gray-50 px-2 py-2 font-medium">
                                    <label class="inline-block h-full w-full" for="color_vision_{{ $index }}">
                                        {{ $statusLabel }}
                                    </label>
                                </td>
                                <td class="border border-gray-200 text-center">
                                    <input required id="color_vision_{{ $index }}" type="radio"
                                        name="medical_exam[color_vision]" value="{{ $statusLabel }}"
                                        @checked(old('medical_exam.color_vision', $snapshot['color_vision'] ?? '') === $statusLabel)
                                        class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-3 rounded-xl border border-gray-200 bg-white p-4">
        <h4 class="text-sm font-semibold tracking-wide text-gray-800">
            @lang('ophthalmology.ishihara_test')
        </h4>
        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
            <table class="w-full min-w-[320px] border-collapse text-xs text-gray-800 sm:text-sm">
                <thead>
                    <tr>
                        <th class="border border-gray-200 bg-gray-50 px-3 py-2"></th>
                        <th class="border border-gray-200 bg-gray-50 px-3 py-2 text-center">N</th>
                        <th class="border border-gray-200 bg-gray-50 px-3 py-2 text-center">CP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (['yellow', 'green', 'red', 'blue'] as $colorKey)
                        <tr>
                            <td class="border border-gray-200 bg-gray-50 px-3 py-2 font-medium">
                                @lang('ophthalmology.colors.' . $colorKey) <span class="text-red-600">*</span>
                            </td>
                            <td class="border border-gray-200 text-center"><input required type="radio"
                                    name="medical_exam[ishihara][{{ $colorKey }}]" value="N" @checked(
                                        old('medical_exam.ishihara.' . $colorKey, $snapshot['ishihara'][$colorKey]
                                            ?? '') === 'N'
                                    ) class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                            </td>
                            <td class="border border-gray-200 text-center"><input required type="radio"
                                    name="medical_exam[ishihara][{{ $colorKey }}]" value="CP" @checked(
                                        old('medical_exam.ishihara.' . $colorKey, $snapshot['ishihara'][$colorKey]
                                            ?? '') === 'CP'
                                    ) class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <x-button class="w-full" type="submit" variant="base">
        @lang('button.create')
    </x-button>
</form>