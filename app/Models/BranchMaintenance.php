<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
use App\Models\Account;
use App\Models\Classification;
use App\Models\Area;
use App\Models\Region;

class BranchMaintenance extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'account_id',
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

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function account() {
        $account = Account::find($this->account_id);
        return $account;
    }

    public function classification() {
        $classification = Classification::find($this->classification_id);
        return $classification;
    }

    public function area() {
        $area = Area::find($this->area_id);
        return $area;
    }

    public function region() {
        $region = Region::find($this->region_id);
        return $region;
    }
}
