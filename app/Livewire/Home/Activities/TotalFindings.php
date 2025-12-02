<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\DiserActivity;

class TotalFindings extends Component
{
    public $total_findings;
    public $diser_login;
    public $diser_activities;

    public function render()
    {
        return view('livewire.home.activities.total-findings');
    }

    public function mount() {
        $this->diser_login = Session::get('diser_login');
        $this->diser_activities = Session::get('diser_activities');

        $this->total_findings = $this->diser_activities['activity']->total_findings;
    }

    public function updated() {
        $this->saveFindings();
    }

    public function saveFindings() {
        $diser_activity = $this->diser_activities['activity'];
        $diser_activity->update([
            'total_findings' => $this->total_findings
        ]);
    }
}
