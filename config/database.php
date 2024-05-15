<?php

use Illuminate\Support\Str;

return [

/*
|--------------------------------------------------------------------------
| Default Database Connection Name
|--------------------------------------------------------------------------
|
| Here you may specify which of the database connections below you wish
| to use as your default connection for all database work. Of course
| you may use many connections at once using the Database library.
|
*/

'default' => env('DB_CONNECTION', 'mongodb'),

/*
|--------------------------------------------------------------------------
| Database Connections
|--------------------------------------------------------------------------
|
| Here are each of the database connections setup for your application.
| Of course, examples of configuring each database platform that is
| supported by Laravel is shown below to make development simple.
|
|
| All database work in Laravel is done through the PHP PDO facilities
| so make sure you have the driver for your particular database of
| choice installed on your machine before you begin development.
|
*/

//mongoDB

    'connections' => [


     'mongodb' => [
            'driver'   => 'mongodb',
            'dsn' => env('DB_URI', 'mongodb://neha:TetMJAXZ2VH35A5y@ac-8a170vo-shard-00-00.hjx5ms5.mongodb.net:27017,ac-8a170vo-shard-00-01.hjx5ms5.mongodb.net:27017,ac-8a170vo-shard-00-02.hjx5ms5.mongodb.net:27017/?replicaSet=atlas-z7c51e-shard-0&ssl=true&authSource=admin'), //server
            'database' => env('DB_DATABASE', 'ERP_Drift'),
            ],
    ],
//mongoDB

        //'connections' => [
          //  'mongodb' => [
            //    'driver' => 'mongodb',
                // 'dsn' => env('DB_URI', 'mongodb://10.188.4.129:27017/WindsonDispatch?readPreference=primary&directConnection=true&ssl=false'), //server
                // 'dsn' => env('DB_URI', 'mongodb+srv://astraportal:astraportal@astra.7uwteaq.mongodb.net/'), //server
                  
              //  'database' => 'ERP_Drift',
            //]

        //],

    /*..
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

'migrations' => 'migrations',

/*
|--------------------------------------------------------------------------
| Redis Databases
|--------------------------------------------------------------------------
|
| Redis is an open source, fast, and advanced key-value store that also
| provides a richer body of commands than a typical key-value system
| such as APC or Memcached. Laravel makes it easy to dig right in.
|
*/

'redis' => [

'client' => env('REDIS_CLIENT', 'phpredis'),

'options' => [
'cluster' => env('REDIS_CLUSTER', 'redis'),
'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '192.168.0.11'),
            'password' => env('REDIS_PASSWORD', 'nbp123456'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        // 'cache' => [
        //     'url' => env('REDIS_URL'),
        //     'host' => env('REDIS_HOST', '127.0.0.1'),
        //     'password' => env('REDIS_PASSWORD', null),
        //     'port' => env('REDIS_PORT', '6379'),
        //     'database' => env('REDIS_CACHE_DB', '1'),
        // ],

],

];