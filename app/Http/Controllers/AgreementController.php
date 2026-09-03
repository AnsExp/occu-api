<?php

namespace App\Http\Controllers;

use App\Http\Filters\AgreementFilter;
use App\Http\Requests\AgreementRequest;
use App\Http\Responses\ApiResponse;
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
    public function __construct(private AgreementService $service)
    {
    }

    /**
     * Consulta la información de los convenios en el sistema.
     * 
     * Este endpoint devuelve una lista paginada de convenios registrados,
     * permitiendo aplicar filtros y ordenamientos sobre los resultados.
     * 
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * 
     * @queryParam per_page integer Número de resultados por página. Por defecto, 15.
     * @queryParam page integer Número de página actual. Por defecto, 1.
     * @queryParam institution string Filtrar por institución. Ejemplo: Hospital Central
     * @queryParam discount_type string Filtrar por tipo de descuento. Ejemplo: percentage
     * @queryParam discount_amount integer Filtrar por monto de descuento. Ejemplo: 10
     * @queryParam discount_amount_min integer Filtrar por monto mínimo de descuento. Ejemplo: 5
     * @queryParam discount_amount_max integer Filtrar por monto máximo de descuento.
     * @queryParam order_by string Campo por el cual ordenar los resultados. Ejemplo: institution
     * @queryParam order string Orden de los resultados. Valores posibles: asc, desc. Ejemplo: asc
     * 
     * @return JsonResponse Devuelve un objeto JSON con los convenios paginados, enlaces de navegación y metadatos.
     */
    public function index(Request $request, AgreementFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        $data->getCollection()->transform([AgreementResource::class, 'make']);
        return ApiResponse::pagination(
            $data,
            $data->count() > 0,
            $data->count() > 0 ? 'Agreements retrieved successfully' : 'No agreements found'
        );
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
        $agreement = $this->service->store($request);
        return ApiResponse::data(AgreementResource::make($agreement), true, 'Agreement created successfully', 201);
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
    public function show($id)
    {
        $agreement = Agreement::find($id);
        if (!$agreement) {
            return ApiResponse::data(null, false, 'Agreement not found', 404);
        }
        return ApiResponse::data(AgreementResource::make($agreement), true, 'Agreement retrieved successfully', 200);
    }

    /**
     * Actualiza la información de un convenio específico en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * 
     * @urlParam id integer required ID del convenio.
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
    public function update(Request $request, $id)
    {
        $agreement = Agreement::find($id);
        if (!$agreement) {
            return ApiResponse::data(null, false, 'Agreement not found', 404);
        }
        $agreementUpdated = $this->service->update($request, $agreement);
        return ApiResponse::data(AgreementResource::make($agreementUpdated), true, 'Agreement updated successfully', 200);
    }

    /**
     * Elimina un convenio específico del sistema.
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * @urlParam id integer required ID del convenio.
     * @response 200 scenario="Eliminación exitosa"
     * {
     *     "message": "Agreement deleted successfully"
     * }
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $agreement = Agreement::find($id);
        if (!$agreement) {
            return ApiResponse::data(null, false, 'Agreement not found', 404);
        }
        $agreement->delete();
        return ApiResponse::data(null, true, 'Agreement deleted successfully', 200);
    }
}
