<?php

namespace App\Http\Controllers;

use App\Http\Filters\AgreementFilter;
use App\Http\Requests\AgreementRequest;
use App\Models\Agreement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Services\AgreementService;
use App\Http\Resources\AgreementResource;

/**
 * @group Convenios
 * 
 * Gestión de convenios médicos en el sistema.
 */
class AgreementController extends Controller
{
    public function __construct(private AgreementService $agreementService)
    {
    }

    /**
     * Consulta la información de los convenios en el sistema.
     * 
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * 
     * @queryParam per_page integer Número de resultados por página. Por defecto, 15.
     * @queryParam page integer Número de página actual. Por defecto, 1.
     * @queryParam institution string Filtro por institución. Example: Hospital Central
     * @queryParam discount_type string Filtro por tipo de descuento. Example: percentage
     * @queryParam discount_amount integer Filtro por monto de descuento. Example: 10
     * @queryParam discount_amount_min integer Filtro por monto mínimo de descuento. Example: 5
     * @queryParam discount_amount_max integer Filtro por monto máximo de descuento.
     * @queryParam order_by string Campo por el cual ordenar los resultados. Example: institution
     * @queryParam order string Orden de los resultados. Valores posibles: asc, desc. Example: asc
     *
     * @response 200 scenario="Consulta exitosa"
     * {
     *     "data": [
     *         {
     *             "id": 1,
     *             "institution": "Universidad Católica",
     *             "description": "Convenio para estudiantes y personal docente",
     *             "discount_type": "percentage",
     *             "discount_amount": 15,
     *             "requirements": [
     *                 {
     *                     "id": 10,
     *                     "name": "Medicina General"
     *                 },
     *                 {
     *                     "id": 12,
     *                     "name": "Odontología"
     *                 }
     *             ]
     *         },
     *         {
     *             "id": 2,
     *             "institution": "Empresa Eléctrica",
     *             "description": "Beneficio para empleados activos",
     *             "discount_type": "fixed",
     *             "discount_amount": 25,
     *             "requirements": [
     *                 {
     *                     "id": 14,
     *                     "name": "Cardiología"
     *                 }
     *             ]
     *         }
     *     ],
     *     "links": {
     *         "first": "http://example.com/api/agreements?page=1",
     *         "last": "http://example.com/api/agreements?page=10",
     *         "prev": null,
     *         "next": "http://example.com/api/agreements?page=2"
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
     *                 "url": "http://example.com/api/agreements?page=1",
     *                 "label": "1",
     *                 "active": true
     *             },
     *             {
     *                 "url": "http://example.com/api/agreements?page=2",
     *                 "label": "2",
     *                 "active": false
     *             },
     *             {
     *                 "url": "http://example.com/api/agreements?page=3",
     *                 "label": "3",
     *                 "active": false
     *             }
     *         ],
     *         "path": "http://example.com/api/agreements",
     *         "per_page": 15,
     *         "to": 15,
     *         "total": 150
     *     }
     * }
     * @return JsonResponse
     */
    public function index(Request $request, AgreementFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return AgreementResource::collection($data);
    }

    /**
     * Guarda un nuevo convenio en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     *
     * @response 201 scenario="Guardado exitoso"
     * {
     *     "data": {
     *         "id": 1,
     *         "institution": "Universidad Católica",
     *         "description": "Convenio para estudiantes y personal docente",
     *         "discount_type": "percentage",
     *         "discount_amount": 15,
     *         "requirements": [
     *             {
     *                 "id": 10,
     *                 "name": "Medicina General"
     *             },
     *             {
     *                 "id": 12,
     *                 "name": "Odontología"
     *             }
     *         ]
     *     }
     * }
     * @return JsonResponse
     */
    public function store(AgreementRequest $request)
    {
        $agreement = $this->agreementService->store($request);
        return response()->json(AgreementResource::make($agreement), 201);
    }

    /**
     * Consulta la información de un convenio específico en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     *
     * @urlParam agreement_id integer required ID del convenio.
     *
     * @response 200 scenario="Consulta exitosa"
     * {
     *     "data": {
     *         "id": 1,
     *         "id": 1,
     *         "institution": "Universidad Católica",
     *         "description": "Convenio para estudiantes y personal docente",
     *         "discount_type": "percentage",
     *         "discount_amount": 15,
     *         "requirements": [
     *             {
     *                 "id": 10,
     *                 "name": "Medicina General"
     *             },
     *             {
     *                 "id": 12,
     *                 "name": "Odontología"
     *             }
     *         ]
     *     }
     * }
     * @return JsonResponse
     */
    public function show(Agreement $agreement)
    {
        return response()->json(AgreementResource::make($agreement), 200);
    }

    /**
     * Actualiza la información de un convenio específico en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * 
     * @urlParam agreement_id integer required ID del convenio.
     *
     * @bodyParam institution string required Nombre de la institución. Example: Hospital Central
     * @bodyParam discount_type string required Tipo de descuento. Example: Porcentaje
     * @bodyParam discount_amount float required Monto del descuento. Example: 10
     * @bodyParam description string Descripción del convenio. Example: Descuento especial para empleados.
     * @bodyParam requirement array IDs de las especialidades asociadas al convenio. Example: [1, 2, 3]
     *
     * @response 200 scenario="Actualización exitosa"
     * {
     *     "data": {
     *         "id": 1,
     *         "institution": "Universidad Católica",
     *         "description": "Convenio para estudiantes y personal docente",
     *         "discount_type": "percentage",
     *         "discount_amount": 15,
     *         "requirements": [
     *             {
     *                 "id": 10,
     *                 "name": "Medicina General"
     *             },
     *             {
     *                 "id": 12,
     *                 "name": "Odontología"
     *             }
     *         ]
     *     }
     * }
     * @return JsonResponse
     */
    public function update(Request $request, Agreement $agreement)
    {
        $agreement = $this->agreementService->update($request, $agreement);
        return response()->json(AgreementResource::make($agreement), 200);
    }

    /**
     * Elimina un convenio específico del sistema.
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * @urlParam agreement_id integer required ID del convenio.
     * @response 200 scenario="Eliminación exitosa"
     * {
     *     "message": "Agreement deleted successfully"
     * }
     * @param Agreement $agreement
     * @return JsonResponse
     */
    public function destroy(Agreement $agreement)
    {
        $agreement->delete();
        return response()->json(['message' => 'Agreement deleted successfully.'], 200);
    }
}
