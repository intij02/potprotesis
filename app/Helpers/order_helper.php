<?php

if (! function_exists('pot_work_types')) {
    function pot_work_types(): array
    {
        return [
            'Encerado de diagnóstico',
            'Provisional fijo acrílico',
            'Composite SR Nexco',
            'Metal / cerámica',
            'Disilicato de litio',
            'Zirconia',
            'Prótesis parcial removible',
            'Placa total',
            'Guarda miconfortable',
            'Impresión de modelo 3D',
        ];
    }
}

if (! function_exists('pot_restoration_types')) {
    function pot_restoration_types(): array
    {
        return [
            'Corona',
            'Carilla',
            'Puente',
            'Incrustación',
        ];
    }
}

if (! function_exists('pot_upper_teeth')) {
    function pot_upper_teeth(): array
    {
        return ['18', '17', '16', '15', '14', '13', '12', '11', '21', '22', '23', '24', '25', '26', '27', '28'];
    }
}

if (! function_exists('pot_lower_teeth')) {
    function pot_lower_teeth(): array
    {
        return ['48', '47', '46', '45', '44', '43', '42', '41', '31', '32', '33', '34', '35', '36', '37', '38'];
    }
}

if (! function_exists('pot_all_teeth')) {
    function pot_all_teeth(): array
    {
        return array_merge(pot_upper_teeth(), pot_lower_teeth());
    }
}

if (! function_exists('pot_implant_chimney_options')) {
    function pot_implant_chimney_options(): array
    {
        return [
            'none'    => 'Sin especificar',
            'with'    => 'Con chimenea',
            'without' => 'Sin chimenea',
        ];
    }
}
