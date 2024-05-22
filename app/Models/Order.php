<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;

class Order extends Model
{
    use HasApiTokens;

    protected $primaryKey = '_id';
    protected $keyType = 'int'; 
    public $incrementing = true; // MongoDB IDs are not incrementing integers
    protected $connection = 'mongodb';
    protected $collection = 'order_data';
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'custName',
        'companylistcust',
        'email',
        'phoneno',
        'address',
        'city',
        'zipcode',
        'state',
        'country',
        'custref',
        'prodName',
        'product_type',
        'prod_code',
        'prod_qty',
        'Thickness',
        'Width',
        'Roll_weight',
        'ColourName',
        'total_quantity',
        'price',
        'Billing_address',
        'Delivery_address',
        'price_type',
        'status',
        'notes'
        
    ];


    /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
    */
    // protected $hidden = [
    // 'password',
    // 'remember_token',
    // ];

    /**
    * The attributes that should be cast.
    *
    * @var array<string, string>
    */
    // protected $casts = [
    // 'email_verified_at' => 'datetime',
    // ];
}