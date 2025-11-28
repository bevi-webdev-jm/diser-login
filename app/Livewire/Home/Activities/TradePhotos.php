<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithFileUploads;

class TradePhotos extends Component
{
    use WithFileUploads;

    public $photo_files;
    public $pictures_arr;

    public function render()
    {
        return view('livewire.home.activities.trade-photos');
    }

    public function mount() {
    }

    public function updatedPhotoFiles() {
        $this->validate([
            'photo_files.*' => 'image|max:2048',
        ]);

        foreach ($this->photo_files as $picture) {
            $this->pictures_arr[] = [
                'title' => $picture->getClientOriginalName(),
                'picture' => $picture
            ];
        }

    }

    public function removeLine($key) {
        unset($this->pictures_arr[$key]);
    }
}
