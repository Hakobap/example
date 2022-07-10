<?php

namespace App\Http\Controllers\Traits;

/**
 * Class View
 */
trait View
{
    public function view($p, $prefix = 'pages')
    {
        return $prefix ? view($prefix . '.' . $p) : view($p);
    }
}