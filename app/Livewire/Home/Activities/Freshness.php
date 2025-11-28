<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Product;
use App\Models\DiserActivityFreshness;
use Illuminate\Support\Facades\Session;

class Freshness extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $freshness_data;
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
            ->paginate(6, ['*'], 'freshness-page');

        return view('livewire.home.activities.freshness')->with([
            'products' => $products
        ]);
    }

    public function mount() {
        $this->freshness_data = [];
        $this->diser_login = Session::get('diser_login');
        $this->diser_activities = Session::get('diser_activities');

        if(empty($this->diser_activities['freshness_data'])) {
            $freshness = DiserActivityFreshness::where('diser_activity_id', $this->diser_activities['activity']->id)
                ->get();
            foreach($freshness as $data) {
                $this->freshness_data[$data->product_id] = [
                    'inventory_count' => $data->inventory_count ?? '',
                    'expiry_date' => $data->expiry_date ?? ''
                ];
            }
        } else {
            foreach($this->diser_activities['freshness_data'] as $product_id => $data) {
                $this->freshness_data[$product_id] = [
                    'inventory_count' => $data['inventory_count'] ?? '',
                    'expiry_date' => $data['expiry_date'] ?? '',
                ];
            }
        }
    }

    public function updatedSearch() {
        $this->resetPage('freshness-page');
    }

    public function saveSession() {
        $this->diser_activities['freshness_data'] = $this->freshness_data;
        Session::put('diser_activities', $this->diser_activities);
    }

    public function updatedFreshnessData() {
        $this->saveFreshness();
        $this->saveSession();
    }

    public function saveFreshness() {
        foreach($this->freshness_data as $product_id => $data) {
            if(!empty($data['inventory_count']) || !empty($data['expiry_date'])) {
                $freshness = DiserActivityFreshness::where('diser_activity_id', $this->diser_activities['activity']->id)
                    ->where('product_id', $product_id)
                    ->first();
                if(!empty($freshness)) {
                    $freshness->update([
                        'inventory_count' => !empty($data['inventory_count']) ? $data['inventory_count'] : NULL,
                        'expiry_date' => !empty($data['expiry_date']) ? $data['expiry_date'] : NULL
                    ]);
                } else {
                    $freshness = new DiserActivityFreshness([
                        'diser_activity_id' => $this->diser_activities['activity']->id,
                        'product_id' => $product_id,
                        'inventory_count' => !empty($data['inventory_count']) ? $data['inventory_count'] : NULL,
                        'expiry_date' => !empty($data['expiry_date']) ? $data['expiry_date'] : NULL
                    ]);
                    $freshness->save();
                }
            }
        }
    }
}
