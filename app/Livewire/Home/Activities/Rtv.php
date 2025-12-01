<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Product;
use App\Models\DiserActivityRTV;
use Illuminate\Support\Facades\Session;

class Rtv extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $rtv_data;
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
            ->paginate(6, ['*'], 'rtv-page');

        return view('livewire.home.activities.rtv')->with([
            'products' => $products
        ]);
    }

    public function mount() {
        $this->rtv_data = [];
        $this->diser_login = Session::get('diser_login');
        $this->diser_activities = Session::get('diser_activities');

        if(empty($this->diser_activities['rtv_data'])) {
            $rtvs = DiserActivityRTV::where('diser_activity_id', $this->diser_activities['activity']->id)
                ->get();
            foreach($rtvs as $rtv) {
                $this->rtv_data[$rtv->product_id] = [
                    'rtv_number' => $rtv->rtv_number ?? '',
                    'reason' => $rtv->reason ?? '',
                    'inventory_count' => $rtv->inventory_count ?? ''
                ];
            }
        } else {
            foreach($this->diser_activities['rtv_data'] as $product_id => $data) {
                $this->rtv_data[$product_id] = [
                    'rtv_number' => $data['rtv_number'] ?? '',
                    'reason' => $data['reason'] ?? '',
                    'inventory_count' => $data['inventory_count'] ?? ''
                ];
            }
        }
    }

    public function updatedSearch() {
        $this->resetPage('rtv-page');
    }

    public function saveSession() {
        $this->diser_activities['rtv_data'] = $this->rtv_data;
        Session::put('diser_activities', $this->diser_activities);
    }

    public function updated() {
        $this->saveRTV();
        $this->saveSession();
    }

    public function saveRTV() {
        foreach($this->rtv_data as $product_id => $data) {
            if(!empty($data['rtv_number']) || !empty($data['reason']) || !empty($data['inventory_count'])) {
                $rtv = DiserActivityRTV::where('diser_activity_id', $this->diser_activities['activity']->id)
                    ->where('product_id', $product_id)
                    ->first();
                if(!empty($rtv)) {
                    $rtv->update([
                        'rtv_number' => !empty($data['rtv_number']) ? $data['rtv_number'] : NULL,
                        'reason' => !empty($data['reason']) ? $data['reason'] : NULL,
                        'inventory_count' => !empty($data['inventory_count']) ? $data['inventory_count'] : NULL,
                    ]);
                } else {
                    $rtv = new DiserActivityRTV([
                        'diser_activity_id' => $this->diser_activities['activity']->id,
                        'product_id' => $product_id,
                        'rtv_number' => !empty($data['rtv_number']) ? $data['rtv_number'] : NULL,
                        'reason' => !empty($data['reason']) ? $data['reason'] : NULL,
                        'inventory_count' => !empty($data['inventory_count']) ? $data['inventory_count'] : NULL,
                    ]);
                    $rtv->save();
                }
            }
        }
    }
}
