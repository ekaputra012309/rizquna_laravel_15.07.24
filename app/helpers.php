<?php 

if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $f = new \NumberFormatter("id", \NumberFormatter::SPELLOUT);
        return $f->format($angka);
    }
}
