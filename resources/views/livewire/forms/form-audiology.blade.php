<form method="post" action="{{ $certificate ? route('audiology.update', $certificate) : route('audiology.store') }}"
    class="space-y-6">
    @csrf
    @if ($certificate)
        @method('PUT')
    @endif
    <input type="hidden" name="medical_date[id]" value="{{ $medicalDate->id }}">
    <input type="hidden" name="specialty[id]" value="{{ $medicalDate->specialty->id }}">
    <x-input-timezone />
    <x-badge :text="'Paciente: ' . $medicalDate->patient->person->fullname" />
    <div class="grid gap-4 xl:grid-cols-12">
        <div class="space-y-3 rounded-xl border border-gray-200 bg-white p-4 xl:col-span-5">
            <h4 class="text-sm font-semibold uppercase tracking-wide text-gray-700">@lang('audiology.hearing')</h4>
            <div class="space-y-2 rounded-lg border border-gray-100 bg-gray-50/50 p-3">
                <div class="grid gap-2 sm:grid-cols-[170px_1fr] sm:items-center">
                    <x-input-control name="medical_exam[hearing][right]" :label="__('audiology.right_ear')"
                        :value="$medical_exam['hearing']['right'] ?? ''" required />
                </div>
                <div class="grid gap-2 sm:grid-cols-[170px_1fr] sm:items-center">
                    <x-input-control name="medical_exam[hearing][left]" :label="__('audiology.left_ear')"
                        :value="$medical_exam['hearing']['left'] ?? ''" required />
                </div>
            </div>
        </div>

        <div class="space-y-4 xl:col-span-7">
            <div class="rounded-xl border border-gray-200 bg-white p-4">
                <h4 class="mb-2 text-sm font-semibold uppercase tracking-wide text-gray-700">
                    @lang('audiology.three_meter_speech_whisper_test')
                </h4>
                <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
                    <table class="min-w-[360px] border-collapse text-xs text-gray-800 sm:text-sm">
                        <thead>
                            <tr>
                                <th class="border border-gray-200 bg-gray-50 px-3 py-2"></th>
                                <th class="border border-gray-200 bg-gray-50 px-3 py-2 text-center">
                                    @lang('audiology.normal')
                                </th>
                                <th class="border border-gray-200 bg-gray-50 px-3 py-2 text-center">
                                    @lang('audiology.whisper')
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['right_ear', 'left_ear'] as $ear)
                                <tr>
                                    <td class="border border-gray-200 bg-gray-50 px-3 py-2 font-medium">
                                        @lang('audiology.' . $ear) <span class="text-red-600">*</span>
                                    </td>
                                    <td class="border border-gray-200 text-center">
                                        <input required type="radio" name="medical_exam[speech_whisper][{{ $ear }}]"
                                            value="normal" @checked(old('medical_exam.speech_whisper.' . $ear, $medical_exam['speech_whisper'][$ear] ?? '') === 'normal')
                                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                    </td>
                                    <td class="border border-gray-200 text-center">
                                        <input required type="radio" name="medical_exam[speech_whisper][{{ $ear }}]"
                                            value="whisper" @checked(old('medical_exam.speech_whisper.' . $ear, $medical_exam['speech_whisper'][$ear] ?? '') === 'whisper')
                                            class="h-4 w-4 border-gray-300 text-gray-900 focus:ring-gray-900" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-button type="submit" variant="base">
        @lang('button.create')
    </x-button>
</form>