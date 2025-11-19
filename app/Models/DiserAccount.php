<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\returnArgument;

class DiserAccount extends Pivot
{
    protected $connection = 'mysql';
    protected $table = 'diser_account';
    public $timestamps = false;

    /**
     * Dynamically set the database connection based on the session.
     */
    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql'); // Default to 'mysql' if not set
    }

    public function diserIdNumber()
    {
        return $this->belongsTo('App\Models\DiserIdNumber', 'diser_id_number_id');
    }

    public function account() {
        return $this->belongsTo('App\Models\Account', 'account_id');
    }
}
