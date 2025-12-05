<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class BranchMaintenance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'classification_id',
        'area_id',
        'region_id',
        'branch_code',
        'branch_name',
        'status'
    ];

    public function getConnectionName()
    {
        return Session::get('db_connection', 'mysql');
    }
}
