<?php

namespace App\Http\Controllers;

use App\Http\Filters\DoctorFilter;
use App\Http\Requests\DoctorRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Doctor;
use App\Http\Services\DoctorService;
use App\Http\Resources\DoctorResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @group Médicos
 * 
 * Gestiona los médicos en el sistema.
 */
class DoctorController extends Controller
{
    public function __construct(private DoctorService $doctorService)
    {
    }

    /**
     * Consulta la información de los médicos en el sistema.
     * 
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * 
     * @queryParam per_page integer Número de resultados por página. Por defecto, 15.
     * @queryParam page integer Número de página actual. Por defecto, 1.
     * @queryParam id_occupational_doctor boolean Filtro por si es médico ocupacional. Example: true
     * @queryParam id_card string Filtro por número de identificación. Example: 12345678A
     * @queryParam first_name string Filtro por nombre. Example: Juan
     * @queryParam last_name string Filtro por apellido. Example: Pérez
     * @queryParam specialty_id string Filtro por especialidad. Example: 1
     * @queryParam order_by string Campo por el cual ordenar los resultados. Example: first_name
     * @queryParam order string Orden de los resultados. Valores posibles: asc, desc. Example: asc
     *
     * @response 200 scenario="Consulta exitosa"
     * {
     *     "data": [
     *         {
     *             "id": 1,
     *             "personal_data": {
     *                 "first_name": "Juan",
     *                 "last_name": "Pérez",
     *                 "fullname": "Juan Pérez",
     *                 "phone": "0998745632",
     *                 "id_card": "0958745601",
     *                 "email": "juan.perez@example.com",
     *                 "nationality": "Ecuatoriana",
     *                 "gender": "Masculino"
     *             },
     *             "specialty": {
     *                 "id": 10,
     *                 "name": "Pediatría"
     *             },
     *             "metadata": [
     *                 {
     *                     "key": "experience_years",
     *                     "value": "12"
     *                 },
     *                 {
     *                     "key": "hospital",
     *                     "value": "Hospital del Niño"
     *                 }
     *             ],
     *             "is_occupational_doctor": false
     *         },
     *         {
     *             "id": 2,
     *             "personal_data": {
     *                 "first_name": "María",
     *                 "last_name": "Gómez",
     *                 "fullname": "María Gómez",
     *                 "phone": "0987456321",
     *                 "id_card": "0958745602",
     *                 "email": "maria.gomez@example.com",
     *                 "nationality": "Colombiana",
     *                 "gender": "Femenino"
     *             },
     *             "specialty": {
     *                 "id": 11,
     *                 "name": "Ginecología"
     *             },
     *             "metadata": [
     *                 {
     *                     "key": "experience_years",
     *                     "value": "8"
     *                 },
     *                 {
     *                     "key": "hospital",
     *                     "value": "Clínica San José"
     *                 }
     *             ],
     *             "is_occupational_doctor": true
     *         }
     *     ],
     *     "links": {
     *         "first": "http://example.com/api/doctors?page=1",
     *         "last": "http://example.com/api/doctors?page=10",
     *         "prev": null,
     *         "next": "http://example.com/api/doctors?page=2"
     *     },
     *     "meta": {
     *         "current_page": 1,
     *         "from": 1,
     *         "last_page": 10,
     *         "links": [
     *             {
     *                 "url": null,
     *                 "label": "&laquo; Previous",
     *                 "active": false
     *             },
     *             {
     *                 "url": "http://example.com/api/doctors?page=1",
     *                 "label": "1",
     *                 "active": true
     *             },
     *             {
     *                 "url": "http://example.com/api/doctors?page=2",
     *                 "label": "2",
     *                 "active": false
     *             },
     *             {
     *                 "url": "http://example.com/api/doctors?page=3",
     *                 "label": "3",
     *                 "active": false
     *             }
     *         ],
     *         "path": "http://example.com/api/doctors",
     *         "per_page": 15,
     *         "to": 15,
     *         "total": 150
     *     }
     * }
     * @return JsonResponse
     */
    public function index(Request $request, DoctorFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([DoctorResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Doctors retrieved successfully' : 'No doctors found'
        );
    }

    /**
     * Guarda un nuevo médico en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     *
     * @bodyParam first_name string required Primer nombre del médico. Example: Juan
     * @bodyParam last_name string required Apellido del médico. Example: Pérez
     * @bodyParam email string required Correo electrónico del médico. Example: juan.perez@example.com
     * @bodyParam is_occupational_doctor boolean Indica si el médico es ocupacional. Example: false
     * @bodyParam phone string Teléfono del médico. Example: 0998745632
     * @bodyParam id_card string required Cédula de identidad del médico. Example: 0958745601
     * @bodyParam id_card_file file Archivo PDF de la cédula de identidad del médico. Tamaño máximo: 2MB.
     * @bodyParam nationality string Nacionalidad del médico. Example: Ecuatoriana
     * @bodyParam gender string Género del médico. Valores posibles: Masculino, Femenino, Otro. Example: Masculino
     * @bodyParam specialty.id integer ID de la especialidad del médico. Example: 10
     * @bodyParam metadata array Arreglo de metadatos del médico.
     * @bodyParam metadata[].key string Clave del metadato.
     * @bodyParam metadata[].value string Valor del metadato.
     *
     * @response 201 scenario="Guardado exitoso"
     * {
     *     "data": {
     *         "id": 1,
     *         "personal_data": {
     *             "first_name": "Juan",
     *             "last_name": "Pérez",
     *             "fullname": "Juan Pérez",
     *             "phone": "0998745632",
     *             "id_card": "0958745601",
     *             "email": "juan.perez@example.com",
     *             "nationality": "Ecuatoriana",
     *             "gender": "Masculino"
     *         },
     *         "specialty": {
     *             "id": 10,
     *             "name": "Pediatría"
     *         },
     *         "metadata": [
     *             {
     *                 "key": "experience_years",
     *                 "value": "12"
     *             },
     *             {
     *                 "key": "hospital",
     *                 "value": "Hospital del Niño"
     *             }
     *         ],
     *         "is_occupational_doctor": false
     *     }
     * }
     * @param DoctorRequest $request Request for creation of a new doctor.
     * @return JsonResponse
     */
    public function store(DoctorRequest $request)
    {
        $doctor = $this->doctorService->store($request);
        return ApiResponse::data(DoctorResource::make($doctor), true, 'Doctor created successfully', 201);
    }

    /**
     * Consulta la información de un médico específico en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     *
     * @urlParam doctor_id integer required ID del médico.
     *
     * @response 200 scenario="Consulta exitosa"
     * {
     *     "data": {
     *         "id": 1,
     *         "personal_data": {
     *             "first_name": "Juan",
     *             "last_name": "Pérez",
     *             "fullname": "Juan Pérez",
     *             "phone": "0998745632",
     *             "id_card": "0958745601",
     *             "email": "juan.perez@example.com",
     *             "nationality": "Ecuatoriana",
     *             "gender": "Masculino"
     *         },
     *         "specialty": {
     *             "id": 10,
     *             "name": "Pediatría"
     *         },
     *         "metadata": [
     *             {
     *                 "key": "experience_years",
     *                 "value": "12"
     *             },
     *             {
     *                 "key": "hospital",
     *                 "value": "Hospital del Niño"
     *             }
     *         ],
     *         "is_occupational_doctor": false
     *     }
     * }
     * @return JsonResponse
     */
    public function show($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return ApiResponse::data(null, false, 'Doctor not found', 404);
        }
        return ApiResponse::data(DoctorResource::make($doctor), true, 'Doctor retrieved successfully', 200);
    }

    /**
     * Actualiza la información de un médico específico en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * 
     * @urlParam doctor_id integer required ID del médico.
     *
     * @bodyParam first_name string required Primer nombre del médico. Example: Juan
     * @bodyParam last_name string required Apellido del médico. Example: Pérez
     * @bodyParam email string required Correo electrónico del médico. Example: juan.perez@example.com
     * @bodyParam is_occupational_doctor boolean Indica si el médico es ocupacional. Example: false
     * @bodyParam phone string Teléfono del médico. Example: 0998745632
     * @bodyParam id_card string required Cédula de identidad del médico. Example: 0958745601
     * @bodyParam id_card_file file Archivo PDF de la cédula de identidad del médico. Tamaño máximo: 2MB.
     * @bodyParam nationality string Nacionalidad del médico. Example: Ecuatoriana
     * @bodyParam gender string Género del médico. Valores posibles: Masculino, Femenino, Otro. Example: Masculino
     * @bodyParam specialty.id integer ID de la especialidad del médico. Example: 10
     * @bodyParam metadata array Arreglo de metadatos del médico.
     * @bodyParam metadata[].key string Clave del metadato.
     * @bodyParam metadata[].value string Valor del metadato.
     *
     * @response 200 scenario="Actualización exitosa"
     * {
     *     "data": {
     *         "id": 1,
     *         "personal_data": {
     *             "first_name": "Juan",
     *             "last_name": "Pérez",
     *             "fullname": "Juan Pérez",
     *             "phone": "0998745632",
     *             "id_card": "0958745601",
     *             "email": "juan.perez@example.com",
     *             "nationality": "Ecuatoriana",
     *             "gender": "Masculino"
     *         },
     *         "specialty": {
     *             "id": 10,
     *             "name": "Pediatría"
     *         },
     *         "metadata": [
     *             {
     *                 "key": "experience_years",
     *                 "value": "12"
     *             },
     *             {
     *                 "key": "hospital",
     *                 "value": "Hospital del Niño"
     *             }
     *         ],
     *         "is_occupational_doctor": false
     *     }
     * }
     * @return JsonResponse
     */
    public function update(DoctorRequest $request, $id)
    {
        $doctorUpdated = Doctor::find($id);
        if (!$doctorUpdated) {
            return ApiResponse::data(null, false, 'Doctor not found', 404);
        }
        $doctorUpdated = $this->doctorService->update($request, $doctorUpdated);
        return ApiResponse::data(DoctorResource::make($doctorUpdated), true, 'Doctor updated successfully', 200);
    }

    /**
     * Elimina un médico específico del sistema.
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * @urlParam id integer required ID del médico.
     * @response 200 scenario="Eliminación exitosa"
     * {
     *     "message": "Doctor deleted successfully"
     * }
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        if (!$doctor) {
            return ApiResponse::data(null, false, 'Doctor not found', 404);
        }
        $doctor->delete();
        return ApiResponse::data(null, true, 'Doctor deleted successfully', 200);
    }
}
