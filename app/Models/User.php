<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use MongoDB\Laravel\Eloquent\Model;//changes
use MongoDB\Laravel\Auth\User as Authenticatable;//changes
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    
    protected $primaryKey = '_id';
    protected $keyType = 'int';
    public $incrementing = true;

    public $collection = 'users';
    protected $connection = 'mongodb';
    

    protected $fillable = [
        'userEmail',
        'userPass',
        'userFirstName',
        'userLastName',
        'userAddress',
        'user_type',
        'userCode',
        'userDob',
        'userNote',
        'userZip',
        'userCity',
        'userState',
        'userTelephone',
        'department',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'password' => 'hashed',
    // ];
}
