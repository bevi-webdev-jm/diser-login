<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Product;
use App\Models\DiserActivityOSA;
use Illuminate\Support\Facades\Session;

class Osa extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $osa_data;
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
            ->paginate(6, ['*'], 'osa-page');

        return view('livewire.home.activities.osa')->with([
            'products' => $products
        ]);
    }

    public function mount() {
        $this->osa_data = [];
        $this->diser_login = Session::get('diser_login');
        $this->diser_activities = Session::get('diser_activities');

        if(empty($this->diser_activities['osa_data'])) {
            $diser_osa = DiserActivityOSA::where('diser_activity_id', $this->diser_activities['activity']->id)
                ->get();
            foreach($diser_osa as $osa) {
                $this->osa_data[$osa->product_id] = [
                    'inventory_count' => $osa->inventory_count,
                    'maxcap_target' => $osa->maxcap_target
                ];
            }
        } else {
            foreach($this->diser_activities['osa_data'] as $product_id => $data) {
                $this->osa_data[$product_id] = [
                    'inventory_count' => $data['inventory_count'] ?? '',
                    'maxcap_target' => $data['maxcap_target'] ?? '',
                ];
            }
        }
    }

    public function updatedSearch() {
        $this->resetPage('osa-page');
    }

    public function saveSession() {
        $this->diser_activities['osa_data'] = $this->osa_data;
        Session::put('diser_activities', $this->diser_activities);
    }

    public function updatedOsaData() {
        $this->saveOSA();
        $this->saveSession();
    }

    public function saveOSA() {
        foreach($this->osa_data as $product_id => $data) {
            if(!empty($data['inventory_count']) || !empty($data['maxcap_target'])) {
                $osa = DiserActivityOSA::where('diser_activity_id', $this->diser_activities['activity']->id)
                    ->where('product_id', $product_id)
                    ->first();
                if(!empty($osa)) {
                    $osa->update([
                        'inventory_count' => !empty($data['inventory_count']) ? $data['inventory_count'] : NULL,
                        'maxcap_target' => !empty($data['maxcap_target']) ? $data['maxcap_target'] : NULL
                    ]);
                } else {
                    $osa = new DiserActivityOSA([
                        'diser_activity_id' => $this->diser_activities['activity']->id,
                        'product_id' => $product_id,
                        'inventory_count' => !empty($data['inventory_count']) ? $data['inventory_count'] : NULL,
                        'maxcap_target' => !empty($data['maxcap_target']) ? $data['maxcap_target'] : NULL
                    ]);
                    $osa->save();
                }
            }
        }
    }
}
