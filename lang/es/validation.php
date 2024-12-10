<?php

return [
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser una dirección de correo válida.',
    'min' => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',
        'string' => 'El campo :attribute no debe ser mayor a :max caracteres.',
    ],
    'date' => 'El campo :attribute no es una fecha válida.',
    'after' => 'El campo :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El campo :attribute debe ser una fecha posterior o igual a :date.',
    'before' => 'El campo :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El campo :attribute debe ser una fecha anterior o igual a :date.',
    'string' => 'El campo :attribute debe ser una cadena de texto.',
    'numeric' => 'El campo :attribute debe ser un número.',
    'in' => 'El campo :attribute seleccionado no es válido.',
    'unique' => 'El valor del campo :attribute ya está en uso.',
    'confirmed' => 'La confirmación del campo :attribute no coincide.',
    'password' => [
        'min' => 'La contraseña debe tener al menos :min caracteres.',
        'letters' => 'La contraseña debe contener al menos una letra.',
        'numbers' => 'La contraseña debe contener al menos un número.',
        'symbols' => 'La contraseña debe contener al menos un símbolo.',
        'uncompromised' => 'La contraseña proporcionada se ha visto en una filtración de datos.',
    ],

    'attributes' => [
        'name' => 'nombre',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'permission_type' => 'tipo de permiso',
        'start_date' => 'fecha de inicio',
        'end_date' => 'fecha de fin',
        'reason' => 'motivo',
        'status' => 'estado',
        'file' => 'archivo',
        'role' => 'rol',
        'position' => 'cargo',
        'rut' => 'RUT',
        'phone' => 'teléfono',
        'address' => 'dirección',
    ],
];
