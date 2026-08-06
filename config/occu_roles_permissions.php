<?php

return [
    'receptionist' => [
        'read.patients',

        'read.medical_dates',
        'create.medical_dates',
        'update.medical_dates',

        'read.laboratory_orders',
        'create.laboratory_orders',
        'update.medical_dates',

        'read.prescriptions',
        'create.prescriptions',
        'update.medical_dates',
    ],

    'nurse' => [
        'read.medical_dates',

        'read.vital_signs',
        'create.vital_signs',
    ],

    'doctor' => [
        'read.patients',
        'create.patients',
        'update.patients',

        'read.vital_signs',

        'read.laboratory_orders',
        'create.laboratory_orders',

        'read.prescriptions',
        'create.prescriptions',
    ],

    'patient' => [
        'read.patients',

        'read.agreements',

        'read.medical_dates',
    ],

    'partner' => [
        "read.users",

        "read.specialties",

        "read.agreements",

        "read.certificates",

        "read.plans",

        "read.patients",

        "read.doctors",

        "read.prescriptions",

        "read.medications",

        "read.laboratory_orders",

        "read.laboratory_options",

        "read.medical_dates",

        "read.vital_signs",

        "read.metrics"
    ],

    'administrator' => config('occu_permissions', []),
];
