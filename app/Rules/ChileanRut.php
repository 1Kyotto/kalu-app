<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ChileanRut implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        // Eliminar puntos y convertir a mayúsculas
        $rut = strtoupper(str_replace('.', '', $value));
        
        // Verificar el formato básico (12345678-9 o 12.345.678-9)
        if (!preg_match('/^[0-9]{1,8}-[0-9K]$/', $rut)) {
            return false;
        }

        // Separar número y dígito verificador
        list($numero, $dv) = explode('-', $rut);
        
        // Calcular dígito verificador
        $factor = 2;
        $suma = 0;
        
        // Recorrer cada dígito de derecha a izquierda
        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += $factor * intval($numero[$i]);
            $factor = $factor == 7 ? 2 : $factor + 1;
        }
        
        // Calcular dígito verificador esperado
        $dvEsperado = 11 - ($suma % 11);
        
        if ($dvEsperado == 11) {
            $dvEsperado = '0';
        } elseif ($dvEsperado == 10) {
            $dvEsperado = 'K';
        } else {
            $dvEsperado = strval($dvEsperado);
        }
        
        // Comparar dígito verificador calculado con el proporcionado
        return $dv === $dvEsperado;
    }

    public function message()
    {
        return 'El RUT ingresado no es válido. Debe tener el formato 12345678-9 o 12.345.678-K';
    }
}
