<?php

namespace App\Livewire\Home\Activities;

use App\Models\DiserActivityShareOfShelfBath;
use Livewire\Component;
use Illuminate\Support\Facades\Session;

class ShareOfShelfBath extends Component
{
    public $share_of_shelf_data;
    public $diser_login;
    public $diser_activities;

    public function render()
    {
        return view('livewire.home.activities.share-of-shelf-bath');
    }

    public function mount() {

        $this->diser_login = Session::get('diser_login');
        $this->diser_activities = Session::get('diser_activities');

        if(empty($this->diser_activities['share_of_shelf_bath'])) {
            $sos_baths = DiserActivityShareOfShelfBath::where('diser_activity_id', $this->diser_activities['activity']->id)
                ->get();
            if(empty($sos_baths->count())) {
                $this->share_of_shelf_data[] = [
                    'brand' => '',
                    'size'  => ''
                ];
            } else {
                foreach($sos_baths as $sos_bath) {
                    $this->share_of_shelf_data[] = [
                        'brand' => $sos_bath->brand ?? '',
                        'size' => $sos_bath->size ?? ''
                    ];
                }
            }
        } else {
            foreach($this->diser_activities['share_of_shelf_bath'] as $sos_bath) {
                $this->share_of_shelf_data[] = [
                    'brand' => $sos_bath['brand'] ?? '',
                    'size' => $sos_bath['size'] ?? ''
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

    public function removeLine($key) {
        unset($this->share_of_shelf_data[$key]);
        $this->saveSession();
        $this->saveShareOfShelf();
    }

    public function updated() {
        $this->saveShareOfShelf();
        $this->saveSession();
    }

    public function saveSession() {
        $this->diser_activities['share_of_shelf_bath'] = $this->share_of_shelf_data;
        Session::put('diser_activities', $this->diser_activities);
    }

    public function saveShareOfShelf() {
        // check existing data
        $sos_baths = DiserActivityShareOfShelfBath::where('diser_activity_id', $this->diser_activities['activity']->id)
            ->forceDelete();
        foreach($this->share_of_shelf_data as $data) {
            $sos_bath = new DiserActivityShareOfShelfBath([
                'diser_activity_id' => $this->diser_activities['activity']->id,
                'brand' => !empty($data['brand']) ? $data['brand'] : NULL,
                'size' => !empty($data['size']) ? $data['size'] : NULL
            ]);
            $sos_bath->save();
        }
    }
}
