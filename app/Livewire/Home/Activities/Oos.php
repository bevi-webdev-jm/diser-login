<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Product;
use App\Models\DiserActivityOOS;
use Illuminate\Support\Facades\Session;

class Oos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $oos_data;
    public $diser_login;
    public $diser_activities;

    public function render()
    {
        $products = Product::orderBy('stock_code', 'ASC')
            ->whereHas('price_codes', function($query) {
                $query->where('code', $this->diser_login->account->price_code)
                    ->where('company_id', $this->diser_login->account->company_id);
            })
            ->when(!empty($this->search), function($query) {
                $query->where(function($qry) {
                    $qry->where('stock_code', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('description', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('size', 'LIKE', '%'.$this->search.'%');
                });
            })
            ->paginate(6, ['*'], 'oos-page');;

        return view('livewire.home.activities.oos')->with([
            'products' => $products
        ]);
    }

    public function mount() {
        $this->oos_data = [];
        $this->diser_login = Session::get('diser_login');
        $this->diser_activities = Session::get('diser_activities');

        if(empty($this->diser_activities['oos_data'])) {
            $diser_oos = DiserActivityOOS::where('diser_activity_id', $this->diser_activities['activity']->id)->get();
            foreach($diser_oos as $oos) {
                $this->oos_data[$oos->product_id] = [
                    'days_of_oos' => $oos->days_of_oos,
                    'maxcap_target' => $oos->mxacap_target
                ];
            }
        } else {
            foreach($this->diser_activities['oos_data'] as $product_id => $data) {
                $this->oos_data[$product_id] = [
                    'days_of_oos' => $data['days_of_oos'] ?? '',
                    'maxcap_target' => $data['maxcap_target'] ?? '',
                ];
            }
        }
    }

    public function updatedSearch() {
        $this->resetPage('oos-page');
    }

    public function saveSession() {
        $this->diser_activities['oos_data'] = $this->oos_data;
        Session::put('diser_activities', $this->diser_activities);
    }

    public function updatedOosData() {
        $this->saveOOS();
        $this->saveSession();
    }

    public function saveOOS() {
        foreach($this->oos_data as $product_id => $data) {
            if(!empty($data['days_of_oos']) || !empty($data['maxcap_target'])) {
                $oos = DiserActivityOOS::where('diser_activity_id', $this->diser_activities['activity']->id)
                    ->where('product_id', $product_id)
                    ->first();
                if(!empty($oos)) {
                    $oos->update([
                        'days_of_oos' => !empty($data['days_of_oos']) ? $data['days_of_oos'] : null,
                        'maxcap_target' => !empty($data['maxcap_target']) ? $data['maxcap_target'] : null
                    ]);
                } else {
                    $oos = new DiserActivityOOS([
                        'diser_activity_id' => $this->diser_activities['activity']->id,
                        'product_id' => $product_id,
                        'days_of_oos' =>  !empty($data['days_of_oos']) ? $data['days_of_oos'] : null,
                        'maxcap_target' => !empty($data['maxcap_target']) ? $data['maxcap_target'] : null
                    ]);
                    $oos->save();
                }
            }

        }
    }
}
