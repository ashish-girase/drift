<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use MongoDB\Laravel\Eloquent\Model;


class New_notes extends Model
{
    use HasApiTokens;
    protected $primaryKey = '_id';
    protected $keyType = 'int';
    public $incrementing = true;
    protected $connection = 'mongodb';
    protected $collection = 'new_notes';
    protected $dates = ['deleted_at'];

    // protected $fillable = [
    //     'status','receipy_code','delivery_date','time','note','orderid',
    // ];

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
