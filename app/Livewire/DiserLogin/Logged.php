<?php

namespace App\Livewire\DiserLogin;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Logged extends Component
{
    public $diser_login;
    public $longitude, $latitude, $accuracy;
    public $confirm_signout = false;

    public function render()
    {
        return view('livewire.diser-login.logged');
    }

    public function mount() {
        $this->diser_login = Session::get('diser_login');
    }

    public function signOut() {
        $this->dispatch('load-location');
        $this->confirm_signout = true;
    }

    public function cancelSignOut() {
        $this->confirm_signout = false;
    }

    public function updateLogin() {
        $this->diser_login->update([
            'time_out_longitude' => $this->longitude ?? '',
            'time_out_latitude' => $this->latitude ?? '',
            'time_out_accuracy' => $this->accuracy ?? '',
            'time_out' => now()
        ]);

        Session::forget('diser_login');
        Session::forget('diser_activities');

        return redirect()->to('/home')->with([
            'message_success' => 'Signed out successfully'
        ]);
    }
}
