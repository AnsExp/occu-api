- `/api/login`
- `/api/logout`
- `/api/personal_data`
- `/api/doctors`
- `/api/doctors/:id`
- `/api/doctors`
- `/api/doctors/:id`
- `/api/doctors/:id`
- `/api/medications`
- `/api/medications/:id`
- `/api/medications`
- ![GET BADGE](https://img.shields.io/badge/GET-green) `/api/medications/:id`
- `/api/medications/:id`
- `/api/plans`
- `/api/plans/:id`
- `/api/plans`
- `/api/plans/:id`
- `/api/plans/:id`
- `/api/specialties`
- `/api/specialties/:id`
- `/api/specialties`
- `/api/specialties/:id`
- `/api/specialties/:id`
- `/api/agreements`
- `/api/agreements/:id`
- `/api/agreements`
- `/api/agreements/:id`
- `/api/agreements/:id`
- `/api/medical_dates`
- `/api/medical_dates/:id`
- `/api/medical_dates`
- `/api/medical_dates/:id`
- `/api/medical_dates/:id`
- `/api/prescriptions`
- `/api/prescriptions/:id`
- `/api/prescriptions`
- `/api/prescriptions/:id`
- `/api/prescriptions/:id`
- `/api/vital_signs`
- `/api/vital_signs/:id`
- `/api/vital_signs`
- `/api/vital_signs/:id`
- `/api/vital_signs/:id`
- `/api/laboratory_orders`
- `/api/laboratory_orders/:id`
- `/api/laboratory_orders`
- `/api/laboratory_orders/:id`
- `/api/laboratory_orders/:id`
- `/api/laboratory_options`
- `/api/laboratory_options/:id`
- `/api/laboratory_options`
- `/api/laboratory_options/:id`
- `/api/laboratory_options/:id`
- `/api/audit_logs`
- `/api/audit_logs/:id`
- ![GET BADGE](https://img.shields.io/badge/GET-green) `/api/check_ip`
- ![GET BADGE](https://img.shields.io/badge/GET-green) [`/api/abilities`](#apiabilities)
- `/api/certificates/:id`

## `/api/check_ip`

> Consulta si tu dirección IP actual está en la lista blanca de IPs del sistema.

### Condiciones Previas

- Autenticación requerida.

### Método

![GET BADGE](https://img.shields.io/badge/GET-green)

### Headers

```http
Authorization: Bearer <token>
Content-Type: application/json
```

### Response de éxito

```json
[
    "read.doctors",
    "create.doctors",
    "update.doctors",
    "delete.doctors",
    ...
]
```

## `/api/abilities`

> Consulta todos los permisos asignados al token de sesión.

### Condiciones Previas

- Autenticación requerida.

### Método

![GET BADGE](https://img.shields.io/badge/GET-green)

### Headers

```http
Authorization: Bearer <token>
Content-Type: application/json
```

### Response

```json
[
    "read.doctors",
    "create.doctors",
    "update.doctors",
    "delete.doctors",
    ...
]
```