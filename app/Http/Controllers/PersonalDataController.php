<?php

namespace App\Http\Controllers;

use App\Http\Filters\PersonalDataFilter;
use App\Http\Resources\PersonalDataResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;

/**
 * @group Información personal
 * 
 * Consulta la información personal de los usuarios.
 */
class PersonalDataController extends Controller
{
    /**
     * Consulta la información personal de los usuarios.
     * 
     * @authenticated
     * @header Authorization Bearer {token} Token de autenticación de Sanctum.
     * 
     * @queryParam per_page integer Número de resultados por página. Por defecto, 15.
     * @queryParam page integer Número de página actual. Por defecto, 1.
     * @queryParam first_name string Filtro por nombre. Example: Juan
     * @queryParam last_name string Filtro por apellido. Example: Pérez
     * @queryParam phone string Filtro por número de teléfono. Example: +34123456789
     * @queryParam id_card string Filtro por número de identificación. Example: 12345678A
     * @queryParam gender string Filtro por género. Valores posibles: male, female, other. Example: male
     * @queryParam birth_date string Filtro por fecha de nacimiento. Example: 1990-01-01
     * @queryParam nationality string Filtro por nacionalidad. Example: España
     * @queryParam email string Filtro por correo electrónico. Example: usuario@occumaster.test
     * @queryParam order_by string Campo por el cual ordenar los resultados. Example: first_name
     * @queryParam order string Orden de los resultados. Valores posibles: asc, desc. Example: asc
     *
     * @response 200 scenario="Consulta exitosa"
     * {
     *     "data": [
     *         {
     *             "id": 1,
     *             "first_name": "Juan",
     *             "last_name": "Pérez",
     *             "fullname": "Juan Pérez",
     *             "phone": "+34123456789",
     *             "id_card": "12345678A",
     *             "gender": "male",
     *             "email": "usuario@occumaster.test",
     *             "birth_date": "1990-01-01",
     *             "nationality": "España"
     *         }
     *     ],
     *     "links": {
     *         "first": "http://example.com/api/personal-data?page=1",
     *         "last": "http://example.com/api/personal-data?page=10",
     *         "prev": null,
     *         "next": "http://example.com/api/personal-data?page=2"
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
     *                 "url": "http://example.com/api/personal-data?page=1",
     *                 "label": "1",
     *                 "active": true
     *             },
     *             {
     *                 "url": "http://example.com/api/personal-data?page=2",
     *                 "label": "2",
     *                 "active": false
     *             },
     *             {
     *                 "url": "http://example.com/api/personal-data?page=3",
     *                 "label": "3",
     *                 "active": false
     *             }
     *         ],
     *         "path": "http://example.com/api/personal-data",
     *         "per_page": 15,
     *         "to": 15,
     *         "total": 150
     *     }
     * }
     */
    public function index(Request $request, PersonalDataFilter $filter)
    {
        $perPage = $request->input('per_page', 15);
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([PersonalDataResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Personal data retrieved successfully' : 'No personal data found'
        );
    }
}
