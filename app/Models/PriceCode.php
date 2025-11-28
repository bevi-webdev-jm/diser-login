<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceCode extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql_sms';
    protected $table = 'price_codes';

    public function products() {
        return $this->hasMany('App\Models\Product');
    }
}
