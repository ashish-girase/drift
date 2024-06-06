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
        '/admin/get_companylist',
        '/admin/edit_color',
        '/admin/delete_color',
        '/admin/edit_design',
        '/admin/delete_design',
        '/admin/edit_product',
        '/admin/delete_product',
        '/admin/get_colorlist',
        '/admin/searchCustomer',
        '/admin/add_company',
        '/admin/delete_customer',
        '/admin/customerdataget_single',
        '/admin/delete_producttype',
        '/admin/edit_producttype'
    ];
}
