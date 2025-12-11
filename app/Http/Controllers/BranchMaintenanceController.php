<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Area;
use App\Models\Classification;
use App\Models\Region;
use App\Models\BranchMaintenance;

use App\Http\Requests\BranchAddRequest;
use App\Http\Requests\BranchEditRequest;

use App\Http\Traits\SettingTrait;

class BranchMaintenanceController extends Controller
{

    use SettingTrait;

    public function index(Request $request) {

        $search = trim($request->get('search'));

        $view_all = false;
        if(!auth()->user()->can('branch maintenance approve') || !auth()->user()->hasRole('superadmin')) {
            $view_all = true;
        }

        $branches = BranchMaintenance::orderBy('created_at', 'DESC')
            ->when(!$view_all, function($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->paginate($this->getDataPerPage())
            ->appends(request()->query());

        return view('pages.branch-maintenance.index')->with([
            'branches' => $branches,
            'search' => $search
        ]);
    }

    public function create() {
        $accounts = Account::all();
        $accounts_arr = [
            '' => '- select account -'
        ];
        foreach($accounts as $account) {
            $encrypted_id = encrypt($account->id);
            $accounts_arr[$encrypted_id] = '['.$account->account_code.'] '.$account->short_name;
        }

        $areas = Area::all();
        $areas_arr = [
            '' => '- select area -'
        ];
        foreach($areas as $area) {
            $encrypted_id = encrypt($area->id);
            $areas_arr[$encrypted_id] = '['.$area->area_code.'] '.$area->area_name;
        }

        $classifications = Classification::all();
        $classifications_arr = [
            '' => '- select channel -'
        ];
        foreach($classifications as $classification) {
            $encrypted_id = encrypt($classification->id);
            $classifications_arr[$encrypted_id] = '['.$classification->classification_code.'] '.$classification->classification_name;
        }

        $regions = Region::all();
        $regions_arr = [
            '' => '- select region -'
        ];
        foreach($regions as $region) {
            $encrypted_id = encrypt($region->id);
            $regions_arr[$encrypted_id] = $region->region_name;
        }

        return view('pages.branch-maintenance.create')->with([
            'accounts' => $accounts_arr,
            'areas' => $areas_arr,
            'classifications' => $classifications_arr,
            'regions' => $regions_arr
        ]);
    }

    public function store(BranchAddRequest $request) {
        $branch_maintenance = new BranchMaintenance([
            'user_id' => auth()->user()->id,
            'account_id' => decrypt($request->account_id),
            'classification_id' => decrypt($request->classification_id),
            'area_id' => decrypt($request->area_id),
            'region_id' => decrypt($request->region_id),
            'branch_code' => $request->branch_code,
            'branch_name' => $request->branch_name,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'accuracy' => $request->accuracy
        ]);
        $branch_maintenance->save();

        // logs
        activity('created')
            ->performedOn($branch_maintenance)
            ->log(':causer.name has created branch maintenance :subject.branch_code');

        return redirect()->route('branch-maintenance.index')->with([
            'message_success' => 'Branch maintenance has been created.'
        ]);
    }

    public function show($id) {
        $branch = BranchMaintenance::findOrFail(decrypt($id));

        return view('pages.branch-maintenance.show')->with([
            'branch' => $branch
        ]);
    }

    public function edit($id) {
        $branch = BranchMaintenance::findOrFail(decrypt($id));

        $selected_ids = [
            'account_id' => NULL,
            'area_id' => NULL,
            'classification_id' => NULL,
            'region_id' => NULL
        ];

        $accounts = Account::all();
        $accounts_arr = [
            '' => '- select account -'
        ];
        foreach($accounts as $account) {
            $encrypted_id = encrypt($account->id);
            if($account->id == $branch->account_id) {
                $selected_ids['account_id'] = $encrypted_id;
            }
            $accounts_arr[$encrypted_id] = '['.$account->account_code.'] '.$account->short_name;
        }

        $areas = Area::all();
        $areas_arr = [
            '' => '- select area -'
        ];
        foreach($areas as $area) {
            $encrypted_id = encrypt($area->id);
            if($area->id == $branch->area_id) {
                $selected_ids['area_id'] = $encrypted_id;
            }
            $areas_arr[$encrypted_id] = '['.$area->area_code.'] '.$area->area_name;
        }

        $classifications = Classification::all();
        $classifications_arr = [
            '' => '- select channel -'
        ];
        foreach($classifications as $classification) {
            $encrypted_id = encrypt($classification->id);
            if($classification->id == $branch->classification_id) {
                $selected_ids['classification_id'] = $encrypted_id;
            }
            $classifications_arr[$encrypted_id] = '['.$classification->classification_code.'] '.$classification->classification_name;
        }

        $regions = Region::all();
        $regions_arr = [
            '' => '- select region -'
        ];
        foreach($regions as $region) {
            $encrypted_id = encrypt($region->id);
            if($region->id == $branch->region_id) {
                $selected_ids['region_id'] = $encrypted_id;
            }
            $regions_arr[$encrypted_id] = $region->region_name;
        }

        return view('pages.branch-maintenance.edit')->with([
            'branch' => $branch,
            'accounts' => $accounts_arr,
            'areas' => $areas_arr,
            'classifications' => $classifications_arr,
            'regions' => $regions_arr,
            'selected_ids' => $selected_ids
        ]);
    }

    public function update(BranchEditRequest $request, $id) {
        $branch = BranchMaintenance::findOrFail(decrypt($id));

        $changes_arr['old'] = $branch->getOriginal();

        $branch->update([
            'account_id' => decrypt($request->account_id),
            'classification_id' => decrypt($request->classification_id),
            'area_id' => decrypt($request->area_id),
            'region_id' => decrypt($request->region_id),
            'branch_code' => $request->branch_code,
            'branch_name' => $request->branch_name,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'accuracy' => $request->accuracy
        ]);

        $changes_arr['changes'] = $branch->getChanges();

        // logs
        activity('updated')
            ->performedOn($branch)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated branch maintenance :subject.branch_code');

        return back()->with([
            'message_success' => 'Branch has been updated successfuly'
        ]);
    }
}
