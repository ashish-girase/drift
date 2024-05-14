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
    public $incrementing = true;
    protected $connection = 'mongodb';
    protected $collection = 'order';
    protected $dates = ['deleted_at'];

    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    protected $fillable = [

    'custName',
    'customer_id',
    'prodName',
    'product_id',
    'product_type',
    'Thickness',
    'Width',
    'Colour',
    'Roll_weight',
    'Status',
    'Total_qty',
    'Detail_inst',
    'Billing_address',
    'Delivery_address',
    'Typeof_price',

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