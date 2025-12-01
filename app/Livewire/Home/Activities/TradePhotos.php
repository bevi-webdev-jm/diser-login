<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\DiserActivityTradePhoto;

use App\Helpers\FileSavingHelper;
use Illuminate\Support\Facades\Session;

class TradePhotos extends Component
{
    use WithFileUploads;

    public $photo_files;
    public $pictures_arr;
    public $diser_login;
    public $diser_activities;

    public function render()
    {
        return view('livewire.home.activities.trade-photos');
    }

    public function mount() {
        $this->diser_login = Session::get('diser_login');
        $this->diser_activities = Session::get('diser_activities');

        $trade_photos = DiserActivityTradePhoto::where('diser_activity_id', $this->diser_activities['activity']->id)
            ->get();
        foreach($trade_photos as $trade_photo) {
            $this->pictures_arr[] = [
                'id' => $trade_photo->id,
                'title' => $trade_photo->title ?? '',
                'picture' => $trade_photo->file_path ?? ''
            ];
        }
    }

    public function updatedPhotoFiles() {
        $this->validate([
            'photo_files.*' => 'image|max:2048',
        ]);

        foreach ($this->photo_files as $picture) {
            $this->pictures_arr[] = [
                'id' => NULL,
                'title' => $picture->getClientOriginalName(),
                'picture' => $picture
            ];
        }

        $this->savePhotos();
    }

    public function removeLine($key) {
        if(!empty($this->pictures_arr[$key]['id'])) {
            $trade_photo = DiserActivityTradePhoto::find($this->pictures_arr[$key]['id']);
            FileSavingHelper::deleteFile($trade_photo->file_path);
            $trade_photo->forceDelete();
        }

        unset($this->pictures_arr[$key]);
    }

    public function savePhotos() {
        if(!empty($this->pictures_arr)) {
            foreach($this->pictures_arr as $key => $picture) {
                if(empty($picture['id'])) {
                    $path = FileSavingHelper::saveFile($picture['picture'], $this->diser_activities['activity']->id, 'diser-activities');
                    $trade_photo = new DiserActivityTradePhoto([
                        'diser_activity_id' => $this->diser_activities['activity']->id,
                        'title' => !empty($picture['title']) ? $picture['title'] : NULL,
                        'file_path' => $path
                    ]);
                    $trade_photo->save();

                    $this->pictures_arr[$key] = [
                        'id' => $trade_photo->id,
                        'title' => $trade_photo->title,
                        'picture' => $trade_photo->file_path
                    ];
                } else {
                    $trade_photo = DiserActivityTradePhoto::find($picture['id']);
                    $trade_photo->update([
                        'title' => !empty($picture['title']) ? $picture['title'] : NULL
                    ]);
                }
            }
        }
    }
}
