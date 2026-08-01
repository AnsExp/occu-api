@php
    $dentalPices = [
        ['16', '17', '55'],
        ['11', '21', '51'],
        ['26', '27', '65'],
        ['36', '37', '75'],
        ['31', '41', '71'],
        ['46', '47', '85']
    ];
@endphp

<form method="post" action="{{ route('odontology.store') }}" class="space-y-6">
    @csrf
    <x-input-timezone />
    <input type="hidden" name="medical_date[id]" value="{{ $medicalDate->id }}">
    <x-badge :text="'Paciente: ' . $medicalDate?->patient?->person?->fullname" />
    <div class="rounded-xl border border-gray-200 bg-white p-4">
        <h4 class="mb-2 text-sm font-semibold uppercase tracking-wide text-gray-700">
            @lang('odontology.details')
        </h4>
        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
            <table class="min-w-[360px] border-collapse text-xs text-gray-800 sm:text-sm">
                <thead>
                    <tr>
                        <th class="border border-gray-200 bg-gray-50 px-3 py-2"></th>
                        <th class="border border-gray-200 bg-gray-50 px-3 py-2 text-center">
                            @lang('odontology.normal')
                        </th>
                        <th class="border border-gray-200 bg-gray-50 px-3 py-2 text-center">
                            @lang('odontology.alterations')
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (['lips', 'cheeks_mejillas', 'cheeks_carrillos', 'upper_jaw', 'lower_jaw', 'tongue', 'palate', 'floor_of_mouth', 'salivary_glands'] as $ear)
                        <tr>
                            <td class="border border-gray-200 bg-gray-50 px-3 py-2 font-medium">
                                @lang('odontology.' . $ear) <span class="text-red-600">*</span>
                            </td>
                            <td class="border border-gray-200 text-center">
                                <input type="radio" name="medical_exam[{{ $ear }}]" value="normal" checked required />
                            </td>
                            <td class="border border-gray-200 text-center">
                                <input type="radio" name="medical_exam[{{ $ear }}]" value="alteration" required />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-4">
        <x-textarea-control name="medical_exam[stomatognathic_exam]" :label="__('odontology.stomatognathic_exam')"
            rows="4" required />
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-4">
        <h4 class="mb-2 text-sm font-semibold uppercase tracking-wide text-gray-700">
            @lang('odontology.odontogram')
        </h4>
        <livewire:components.odontogram />
        <x-textarea-control name="medical_exam[diagnostic]" :label="__('odontology.diagnostic')" rows="4" required />
    </div>
    {{-- <div class="rounded-xl border border-gray-200 bg-white p-4">
        <h4 class="mb-2 text-sm font-semibold uppercase tracking-wide text-gray-700">
            @lang('odontology.examined_teeth')
        </h4>
        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white space-y-4">
            <table class="min-w-[360px] w-full border border-gray-200 rounded-lg shadow-sm text-sm text-gray-800">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th colspan="3" class="px-3 py-2 border border-gray-200"></th>
                        <th class="px-3 py-2 border border-gray-200 text-center font-semibold">Placa 0-1-2-3</th>
                        <th class="px-3 py-2 border border-gray-200 text-center font-semibold">Placa 0-1-2-3</th>
                        <th class="px-3 py-2 border border-gray-200 text-center font-semibold">Gingivitis 0-1</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dentalPices as $row)
                        <tr class="hover  :bg-gray-50 transition-colors">
                            @foreach($row as $tooth)
                                <td class="px-3 py-2 border border-gray-200 bg-gray-50 font-medium text-center">
                                    <x-input-control type="checkbox" name="examined_teeth[{{ $tooth }}][tooth]"
                                        value="{{ $tooth }}" :label="$tooth" />
                                </td>
                            @endforeach
                            @for($i = 0; $i < 3; $i++)
                                <td class="px-3 py-2 border border-gray-200 text-center">
                                    <x-input-control type="text" name="examined_teeth[{{ $row[$i] }}][{{ $i }}]" />
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-100">
                    <tr>
                        <td colspan="3" class="px-3 py-2 border border-gray-200 font-semibold text-center">Total</td>
                        @for($i = 0; $i < 3; $i++)
                            <td class="px-3 py-2 border border-gray-200 text-center">
                                <x-input-control type="text" name="examined_teeth_total[{{ $i }}]" />
                            </td>
                        @endfor
                    </tr>
                </tfoot>
            </table>
            <x-textarea-control name="medical_exam[observations]" :label="__('odontology.observations')" rows="4"
                required />
        </div>
    </div> --}}
    <x-button class="w-full" type="submit" variant="base">
        @lang('button.create')
    </x-button>
</form>