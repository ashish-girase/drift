<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class new_notes extends Model
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
}
