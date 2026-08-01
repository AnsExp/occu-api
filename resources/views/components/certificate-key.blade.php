
<div class="bg-yellow-50 border border-yellow-300 rounded-md p-6 mb-6 shadow-sm">
    <div class="flex items-center mb-3">
        <svg class="h-6 w-6 text-yellow-600 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v2m0 4h.01M12 5a7 7 0 100 14a7 7 0 000-14z" />
        </svg>
        <h3 class="text-lg font-semibold text-yellow-800">Atención</h3>
    </div>

    <p class="text-sm text-yellow-700 leading-relaxed">
        Ya se generó un certificado previamente. Si desea corregirlo, solicite una llave de informe al área de sistemas.
        Si ya tiene una llave, ingrésela a continuación.
    </p>

    <form method="get" class="mt-4">
        <div class="flex gap-3 items-center">
            <div class="flex-1">
                <x-input-control name="certificate_key"
                    placeholder="Ej: f0da559ea59ced68b4d657496bee9753c0447d70702af1a351c7577226d97723" />
            </div>
            <x-button type="submit" :text="__('button.validate')"
                class="bg-yellow-600 hover:bg-yellow-700 text-white" />
        </div>
    </form>

    <div class="mt-5">
        <p class="font-medium text-yellow-800">Para solicitar la llave debe proporcionar:</p>
        <ul class="list-disc list-inside text-sm text-yellow-700 mt-2 space-y-1">
            <li>Su correo</li>
            <li>Firma del certificado a corregir</li>
            <li>Motivo de la solicitud</li>
        </ul>
    </div>
</div>