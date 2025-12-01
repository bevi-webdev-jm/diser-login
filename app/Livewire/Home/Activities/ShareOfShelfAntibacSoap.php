<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\DiserActivityShareOfShelfAntibacSoap;

class ShareOfShelfAntibacSoap extends Component
{
    public $share_of_shelf_data;
    public $diser_login;
    public $diser_activities;

    public function render()
    {
        return view('livewire.home.activities.share-of-shelf-antibac-soap');
    }

    public function mount() {
        $this->diser_login = Session::get('diser_login');
        $this->diser_activities = Session::get('diser_activities');

        if(empty($this->diser_activities['share_of_shelf_antibac_soap'])) {
            $sos_antibac_soaps = DiserActivityShareOfShelfAntibacSoap::where('diser_activity_id', $this->diser_activities['activity']->id)
                ->get();
            if(empty($sos_antibac_soaps->count())) {
                $this->share_of_shelf_data[] = [
                    'brand' => '',
                    'size'  => ''
                ];
            } else {
                foreach($sos_antibac_soaps as $sos_antibac_soap) {
                    $this->share_of_shelf_data[] = [
                        'brand' => $sos_antibac_soap->brand ?? '',
                        'size' => $sos_antibac_soap->size ?? ''
                    ];
                }
            }
        } else {
            foreach($this->diser_activities['share_of_shelf_antibac_soap'] as $data) {
                $this->share_of_shelf_data[] = [
                    'brand' => $data['brand'] ?? '',
                    'size' => $data['size'] ?? ''
                ];
            }
        }
    }

    public function addLine() {
        $this->share_of_shelf_data[] = [
            'brand' => '',
            'size'  => ''
        ];
    }

    public function removeLine($key){
        unset($this->share_of_shelf_data[$key]);
        $this->saveSession();
        $this->saveShareOfShelf();
    }

    public function updated() {
        $this->saveShareOfShelf();
        $this->saveSession();
    }

    public function saveSession() {
        $this->diser_activities['share_of_shelf_antibac_soap'] = $this->share_of_shelf_data;
        Session::put('diser_activities', $this->diser_activities);
    }

    public function saveShareOfShelf() {
        $sos_antibac_soaps = DiserActivityShareOfShelfAntibacSoap::where('diser_activity_id', $this->diser_activities['activity']->id)
            ->forceDelete();
        foreach($this->share_of_shelf_data as $data) {
            $sos_antibac_soap = new DiserActivityShareOfShelfAntibacSoap([
                'diser_activity_id' => $this->diser_activities['activity']->id,
                'brand' => !empty($data['brand']) ? $data['brand'] : NULL,
                'size' => !empty($data['size']) ? $data['size'] : NULL
            ]);
            $sos_antibac_soap->save();
        }
    }
}
