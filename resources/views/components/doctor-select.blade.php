<select>
    <option value="" selected disabled>Selecciona un médico</option>
    @foreach ($doctors as $doctor)
        <option value="{{ $doctor['id'] }}">
            {{ $doctor['name'] }}
            {{ $doctor['specialty'] }}
        </option>
    @endforeach
</select>
{{-- <select id="responsible_doctor_id" name="doctor[id]" required
    class="w-full rounded-lg border border-gray-200 bg-white px-3 py-2.5 text-sm text-gray-900 shadow-sm focus:border-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-800">
    <option value="" selected disabled>Selecciona un médico</option>
    @foreach ($doctors as $doctor)
        <option value="{{ $doctor['id'] }}">
            {{ $doctor['name'] }}
            {{ $doctor['specialty'] }}
        </option>
    @endforeach
</select> --}}