<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DiserActivityTradePhoto;

use App\Helpers\FileSavingHelper;

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

    public function savePhotos() {
        if(!empty($this->pictures_arr)) {
            foreach($this->pictures_arr as $picture) {
                $path = FileSavingHelper::saveFile($picture['picture'], $this->diser_activities['activity']->id, 'diser-activities');
                $trade_photo = new DiserActivityTradePhoto([
                    'diser_activity_id' => $this->diser_activities['activity']->id,
                    'title' => $picture['title'],
                    'file_path' => $path
                ]);
                $trade_photo->save();
            }
        }
    }
}
