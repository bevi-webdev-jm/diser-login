<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class DiserLogin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'account_id',
        'branch_id',
        'longitude',
        'latitude',
        'accuracy',
        'time_in',
        'time_out',
    ];

    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function account() {
        return $this->belongsTo('App\Models\Account');
    }

    public function branch() {
        return $this->belongsTo('App\Models\Branch');
    }
}
