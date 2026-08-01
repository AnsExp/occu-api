<?php

return [
    'receptionist' => [
        'read.medical_date',
        'create.medical_date',

        'read.vital_signs',
        'create.vital_signs',

        'read.laboratory_orders',
        'create.laboratory_orders',

        'read.prescriptions',
        'create.prescriptions',
    ],

    'doctor' => [
        'read.patient',
        'create.patient',
        'update.patient',

        'read.vital_signs',

        'read.laboratory_orders',
        'create.laboratory_orders',

        'read.prescriptions',
        'create.prescriptions',
    ],

    'patient' => [
        'read.patient',

        'read.agreements',

        'read.medical_date',
    ],

    'administrator' => config('occu_permissions', []),
];
