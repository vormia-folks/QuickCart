<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartStatus extends Model
{
    protected $fillable = ['flag'];

    /**
     * Todo: Table Name
     */
    protected $table = 'carts_status';
}
