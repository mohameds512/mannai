<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

class Customer extends Authenticatable
{

    protected $guarded = [];

    protected $table = 'customers';

}
