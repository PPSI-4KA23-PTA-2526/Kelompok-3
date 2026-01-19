<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'midtrans/webhook',
        'admin/*',
    ];

    protected function addCookieToResponse($request, $response)
    {
        $config = config('session');

        if ($request->secure()) {
            $config['secure'] = true;
            $config['same_site'] = 'none';
        }

        return parent::addCookieToResponse($request, $response);
    }
}
