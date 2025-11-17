<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/webhook/update/payment',
        'https://3d10-119-155-16-241.ngrok.io/webhook/update/payment',
        '/webhook/failed/payment',
        'https://3d10-119-155-16-241.ngrok.io/webhook/failed/payment'
    ];
}
