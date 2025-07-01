<?php

if (!function_exists('dateFormat')) {
    function dateFormat($date)
    {
        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        if (!$date) return '-';

        $timestamp = strtotime($date);
        return date('d', $timestamp) . ' ' . $bulan[date('n', $timestamp) - 1] . ' ' . date('Y', $timestamp);
    }
}
