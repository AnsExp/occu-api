<?php

namespace App\Http\Controllers;

use App\Http\Filters\AllowedIpFilter;
use App\Http\Requests\AllowedIpRequest;
use App\Http\Services\AllowedIpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\AllowedIpResource;
use App\Models\AllowedIp;

/**
 * @group Direcciones IP permitidas
 * 
 * Gestiona la lista blanca de direcciones IP permitidas para acceder a la API.
 */
class AllowedIpController extends Controller
{
    public function __construct(private AllowedIpService $allowedIpService)
    {
    }

    /**
     * Consulta la información de las direcciones IP permitidas en el sistema.
     * 
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     * 
     * @queryParam per_page integer Número de resultados por página. Por defecto, 15.
     * @queryParam page integer Número de página actual. Por defecto, 1.
     * @queryParam order_by string Campo por el cual ordenar los resultados. Example: ip_address
     * @queryParam order string Orden de los resultados. Valores posibles: asc, desc. Example: asc
     *
     * @response 200 scenario="Consulta exitosa"
     * {
     *     "data": [
     *         {
     *             "id": 1,
     *             "ip_address": "200.100.50.25",
     *             "notes": "Oficina principal",
     *             "expires_at": null
     *         },
     *         {
     *             "id": 2,
     *             "ip_address": "181.45.33.10",
     *             "notes": "Casa del profesor Juan",
     *             "expires_at": "2026-08-15"
     *         }
     *     ],
     *     "links": {
     *         "first": "http://example.com/api/allowed-ips?page=1",
     *         "last": "http://example.com/api/allowed-ips?page=10",
     *         "prev": null,
     *         "next": "http://example.com/api/allowed-ips?page=2"
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
     *                 "url": "http://example.com/api/allowed-ips?page=1",
     *                 "label": "1",
     *                 "active": true
     *             },
     *             {
     *                 "url": "http://example.com/api/allowed-ips?page=2",
     *                 "label": "2",
     *                 "active": false
     *             },
     *             {
     *                 "url": "http://example.com/api/allowed-ips?page=3",
     *                 "label": "3",
     *                 "active": false
     *             }
     *         ],
     *         "path": "http://example.com/api/allowed-ips",
     *         "per_page": 15,
     *         "to": 15,
     *         "total": 150
     *     }
     * }
     * @return JsonResponse
     */
    public function index(Request $request, AllowedIpFilter $filter)
    {
        $perPage = $request->input('per_page', config('app.page_limit'));
        $data = $filter->query($request->all())->paginate($perPage);
        return AllowedIpResource::collection($data);
    }

    /**
     * Guarda una nueva dirección IP permitida en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     *
     * @response 201 scenario="Guardado exitoso"
     * {
     *     "data": {
     *         {
     *             "id": 1,
     *             "ip_address": "200.100.50.25",
     *             "notes": "Oficina principal",
     *             "expires_at": null
     *         }
     *     }
     * }
     * @return JsonResponse
     */
    public function show(AllowedIp $allowedIp)
    {
        return response()->json(AllowedIpResource::make($allowedIp), 200);
    }

    /**
     * Actualiza una dirección IP permitida en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     *
     * @bodyParam ip_address string required Dirección IP. Example: 200.100.50.25
     * @bodyParam notes string Notas adicionales. Example: Oficina principal
     * @bodyParam expires_at date Fecha de expiración. Example: 2024-12-31
     *
     * @response 200 scenario="Actualización exitosa"
     * {
     *     "data": {
     *         "id": 1,
     *         "ip_address": "200.100.50.25",
     *         "notes": "Oficina principal",
     *         "expires_at": "2024-12-31"
     *     }
     * }
     * @return JsonResponse
     */
    public function store(AllowedIpRequest $request)
    {
        $allowedIp = $this->allowedIpService->store($request);
        return response()->json(AllowedIpResource::make($allowedIp), 201);
    }

    /**
     * Actualiza una dirección IP permitida en el sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     *
     * @bodyParam ip_address string required Dirección IP. Example: 200.100.50.25
     * @bodyParam notes string Notas adicionales. Example: Oficina principal
     * @bodyParam expires_at date Fecha de expiración. Example: 2024-12-31
     *
     * @response 200 scenario="Actualización exitosa"
     * {
     *     "data": {
     *         "id": 1,
     *         "ip_address": "200.100.50.25",
     *         "notes": "Oficina principal",
     *         "expires_at": "2024-12-31"
     *     }
     * }
     * @return JsonResponse
     */
    public function update(AllowedIpRequest $request, AllowedIp $allowedIp)
    {
        $allowedIp = $this->allowedIpService->update($request, $allowedIp);
        return response()->json(AllowedIpResource::make($allowedIp), 200);
    }

    /**
     * Elimina una dirección IP permitida del sistema.
     *
     * @authenticated
     * @header Authorization Bearer {tu-token-personal-aqui}.
     *
     * @urlParam allowedIp integer required ID de la dirección IP permitida.
     *
     * @response 200 scenario="Eliminación exitosa"
     * {
     *     "message": "Deleted successfully"
     * }
     * @return JsonResponse
     */
    public function destroy(AllowedIp $allowedIp)
    {
        $allowedIp->delete();
        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
