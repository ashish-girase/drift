<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;

class NewOrder extends Model
{
    use HasApiTokens;

    protected $primaryKey = '_id';
    protected $keyType = 'int';
    public $incrementing = true; // Assuming you want this, though MongoDB typically uses ObjectIDs
    protected $connection = 'mongodb';
    protected $collection = 'new'; // Ensure this matches your collection name
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
        'ColourName',
        'total_quantity',
        'price',
        'Billing_address',
        'Delivery_address',
        'price_type',
        'status',
        'status_New_time',
        'status_Processing_time',
        'status_dispatch_time',
        'status_Completed_time',
        'status_Cancelled_time'
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