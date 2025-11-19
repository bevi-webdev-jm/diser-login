<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class DiserIdNumber extends Model
{
    use SoftDeletes;

    /**
     * Dynamically set the database connection based on the session.
     */
    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql'); // Default to 'mysql' if not set
    }

    protected $fillable = [
        'id_number',
        'area',
    ];

    public function branches() {
        return $this->belongsToMany('App\Models\Branch', 'diser_branch', 'diser_id_number_id');
    }

    public function accounts() {
        $account_ids = \App\Models\DiserAccount::where('diser_id_number_id', $this->id)->pluck('account_id')->map(fn($id) => (int) $id)->toArray();

        return \App\Models\Account::whereIn('id', $account_ids)->get();
    }
}
