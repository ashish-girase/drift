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
        '/delete_user',
        '/admin/edit_user',
        '/admin/delete_company',
        '/admin/edit_company',
        '/admin/add_customer',
        '/admin/edit_customer',
        '/admin/get_companylist'
    ];
}
