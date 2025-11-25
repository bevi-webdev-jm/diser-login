<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;

class ShareOfShelfBath extends Component
{
    public $share_of_shelf_data;

    public function render()
    {
        return view('livewire.home.activities.share-of-shelf-bath');
    }

    public function mount() {
        $this->share_of_shelf_data[] = [
            'brand' => '',
            'size'  => ''
        ];
    }

    public function addLine() {
        $this->share_of_shelf_data[] = [
            'brand' => '',
            'size'  => ''
        ];
    }
}
