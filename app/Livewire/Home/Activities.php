<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

use App\Models\DiserActivity;

class Activities extends Component
{
    public $diser_login;
    public $activity;
    public $step;
    public $merchandiser_name;
    public $area, $store_in_charge, $pms_name;

    public $steps_arr = [
        1 => 'OOS Reports',
        2 => 'OSA Reports',
        3 => 'Freshness',
        4 => 'RTV Reports',
        5 => 'Share of Shelf Bath',
        6 => 'Share of Shelf Antibac Soap',
        7 => 'Trade Photos',
        8 => 'Total Findings',
    ];

    public function render()
    {
        $this->saveActivity();
        return view('livewire.home.activities');
    }

    public function mount() {
        $this->step = 4;
        $this->merchandiser_name = auth()->user()->name;

        $this->activity = DiserActivity::where('diser_login_id', $this->diser_login->id)
            ->first();
        $this->area = $this->activity->area ?? '';
        $this->pms_name = $this->activity->pms_name ?? '';
        $this->store_in_charge = $this->activity->store_in_charge ?? '';

        $this->saveActivity();
    }

    public function nextStep() {
        $this->step++;
    }

    public function prevStep() {
        $this->step--;
    }

    public function goToStep($step) {
        $this->step = $step;
    }

    public function saveSession() {
        $diser_activities = Session::get('diser_activities');
        $diser_activities['step'] = $this->step;
        $diser_activities['activity'] = $this->activity;
        Session::put('diser_activities', $diser_activities);
    }

    public function saveActivity() {

        if(!empty($this->activity)) {
            $this->activity->update([
                'area' => $this->area,
                'pms_name' => $this->pms_name,
                'store_in_charge' => $this->store_in_charge
            ]);
        } else {
            $this->activity = new DiserActivity([
                'diser_login_id' => $this->diser_login->id,
                'area' => $this->area,
                'pms_name' => $this->pms_name,
                'store_in_charge' => $this->store_in_charge,
                'total_findings' => NULL
            ]);
            $this->activity->save();
        }

        $this->saveSession();
    }
}
