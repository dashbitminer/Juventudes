<?php
return [
    'required' => 'El campo :attribute es obligatorio.',
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'confirmed' => 'La confirmación de :attribute no coincide.',

    'custom' => [
        'current_password' => [
            'required' => 'El campo de la contraseña actual es obligatorio.',
            'password' => [
                'min' => 'La contraseña debe tener al menos 8 caracteres.',
                'confirmed' => 'La confirmación de la contraseña no coincide.',
            ],
        ],
    ],
];
