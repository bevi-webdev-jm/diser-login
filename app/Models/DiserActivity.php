<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class DiserActivity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'diser_login_id',
        'area',
        'store_in_charge',
        'total_findings'
    ];

    /**
     * Dynamically set the database connection based on the session.
     */
    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql'); // Default to 'mysql' if not set
    }

    public function diser_login() {
        return $this->belongsTo('App\Models\DiserLogin');
    }
}
