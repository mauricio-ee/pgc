<?php
// Helper global para formatear precios en COP
if (!function_exists('cop')) {
    /**
     * Formatea un valor numérico como precio en pesos colombianos (COP).
     * Ejemplo: cop(25000) => "$25.000"
     */
    function cop(float|int|null $amount): string
    {
        return '$' . number_format($amount ?? 0, 0, ',', '.');
    }
}
