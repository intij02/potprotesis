<?php

if (! function_exists('pot_order_status_options')) {
    function pot_order_status_options(): array
    {
        return [
            'recibida' => 'Recibida',
            'en_proceso' => 'En proceso',
            'lista' => 'Lista',
            'entregada' => 'Entregada',
            'cancelada' => 'Cancelada',
        ];
    }
}

if (! function_exists('pot_order_status_label')) {
    function pot_order_status_label(?string $value): string
    {
        $options = pot_order_status_options();

        return $options[$value ?? ''] ?? 'Sin definir';
    }
}
