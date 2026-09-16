@extends('layouts.web')

@section('content')
    <x-container>
        <div class="max-w-3xl space-y-4">
            <h2 class="text-3xl font-bold leading-tight text-primary sm:text-4xl">
                Todo lo que necesita en un solo lugar.
            </h2>
            <p class="text-base leading-7 text-dark sm:text-lg">
                Servicios médicos ambulatorios diseñados para dar respuesta rápida, confiable y de calidad tanto a pacientes
                particulares como al sector empresarial.
            </p>
        </div>
        <div class="mt-10 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <x-service-card lucide-icon="briefcase" title="Medicina Ocupacional"
                description="Evaluaciones de ingreso, periódicas y de retiro. Fichas médicas ocupacionales y certificación de aptitud laboral para trabajadores de todos los sectores."
                badge-text="Empresas" />
            <x-service-card lucide-icon="users" title="Especialidades Médicas"
                description="Cardiología, endocrinología, ginecología, neurología, traumatología, psicología y más de 30 especialidades con seguimiento integral."
                badge-text="Pacientes" />
            <x-service-card lucide-icon="circle-check-big" title="Laboratorio Clínico"
                description="Biometría hemática, química sanguínea, perfil lipídico, glucosa y otros exámenes con resultados precisos y oportunos para decisiones confiables."
                badge-text="Ambos" />
            <x-service-card lucide-icon="shield" title="Diagnóstico Por Imágenes"
                description="Ecografías, radiografías y estudios de imagen con protocolos de calidad para respaldar decisiones médicas con mayor certeza."
                badge-text="Ambos" />
            <x-service-card lucide-icon="phone" title="Unidades Móviles"
                description="Llevamos servicios de salud a su empresa con brigadas médicas, evaluaciones y fichas ocupacionales sin detener su operación."
                badge-text="Empresas" />
            <x-service-card lucide-icon="phone" title="Atención A Domicilio"
                description="Consulta médica y seguimiento en el hogar para pacientes que requieren control continuo sin necesidad de desplazarse al centro médico."
                badge-text="Pacientes" />
        </div>
    </x-container>
@endsection