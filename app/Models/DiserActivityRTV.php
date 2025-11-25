<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class DiserActivityRTV extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'diser_activity_id',
        'product_id',
        'rtv_number',
        'reason',
        'inventory_count',
    ];

    /**
     * Dynamically set the database connection based on the session.
     */
    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql'); // Default to 'mysql' if not set
    }
}
