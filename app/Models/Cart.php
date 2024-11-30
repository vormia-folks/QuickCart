<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['flag'];

    /**
     * Todo: Table Name
     */
    protected $table = 'carts';
}
