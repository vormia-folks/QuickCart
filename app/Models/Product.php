<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['flag'];

    /**
     * Todo: Table Name
     */
    protected $table = 'products';

    /**
     * Todo: With
     */
    //protected $with = [''];
}
