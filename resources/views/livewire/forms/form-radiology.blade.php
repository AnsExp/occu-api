<form method="post" action="{{ route('radiology.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    <x-input-timezone />
    <input type="hidden" name="order[id]" value="{{ $order->id }}">
    <input type="hidden" name="order[order_number]" value="{{ $order->order_number }}">
    <x-badge :text="'Orden: ' . $order->order_number" />
    <x-badge :text="'Paciente: ' . $order?->patient?->first_name . ' ' . $order?->patient?->last_name" />
    <div class="space-y-3 rounded-xl border border-gray-200 bg-gray-50/70 p-4">
        @if (user_has_role('administrator'))
            <div class="rounded-xl border border-gray-200 bg-gray-50/70 p-4">
                <x-select-control name="doctor[id]" :label="__('attributes.responsible_doctor')" required>
                    @foreach ($doctors as $doctor)
                        <option value="{{ $doctor->id }}">{{ $doctor->first_name }}
                            {{ $doctor->last_name }}
                        </option>
                    @endforeach
                </x-select-control>
                <p class="mt-1 text-xs text-gray-500">@lang('radiology.test_responsible_doctor')</p>
            </div>
        @endif
        <x-input-control name="medical_exam[technique]" label="Técnica" required />
        <x-textarea-control name="medical_exam[report]" label="Informe" required rows="4" />
        <x-textarea-control name="medical_exam[conclusion]" label="Conclusión" required rows="4" />
    </div>
    <div class="space-y-6 rounded-xl border border-gray-200 bg-gray-50/70 p-4">
        <x-input-control type="file" name="medical_exam[consent_document]" label="Documento de consentimiento"
            accept="application/pdf" required />
        <x-input-control type="file" name="medical_exam[x_ray_files][]" label="Archivos de rayos X"
            accept="application/pdf" multiple required />
    </div>
    <x-button type="submit" variant="base">
        @lang('button.create')
    </x-button>
</form>