<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;

class ProductType extends Model
{
    use HasApiTokens;

    protected $primaryKey = '_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $connection = 'mongodb';
    protected $collection = 'producttype';
    protected $dates = ['deleted_at'];
}
