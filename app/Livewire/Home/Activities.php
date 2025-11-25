<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Activities extends Component
{
    public $diser_login;
    public $step;

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
        return view('livewire.home.activities');
    }

    public function mount() {
        $this->step = 1;

        $diser_activities = [
            'step' => $this->step,
            'oos_data' => [],
            'osa_data' => [],
            'freshness_data' => [],
            'rtv_data' => [],
            'diser_login' => $this->diser_login
        ];

        Session::put('diser_activities', $diser_activities);
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
        Session::put('diser_activities', $diser_activities);
    }
}
