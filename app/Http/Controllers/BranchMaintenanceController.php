<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Classification;
use App\Models\Region;
use App\Models\BranchMaintenance;

use App\Http\Requests\BranchAddRequest;
use App\Http\Requests\BranchEditRequest;

class BranchMaintenanceController extends Controller
{
    public function index(Request $request) {

        $branches = BranchMaintenance::orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('pages.branch-maintenance.index');
    }

    public function create() {
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
            'areas' => $areas_arr,
            'classifications' => $classifications_arr,
            'regions' => $regions_arr
        ]);
    }

    public function store(BranchAddRequest $request) {
        $branch_maintenance = new BranchMaintenance([
            'user_id' => auth()->user()->id,
            'classification_id' => decrypt($request->classification_id),
            'area_id' => decrypt($request->area_id),
            'region_id' => decrypt($request->region_id),
            'branch_code' => $request->branch_code,
            'branch_name' => $request->branch_name,
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

    public function show() {

    }
}
