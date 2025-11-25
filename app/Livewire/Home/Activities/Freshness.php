<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Freshness extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $freshness_data;

    public function render()
    {
        $products = Product::orderBy('stock_code', 'ASC')
            ->when(!empty($this->search), function($query) {
                $query->where('stock_code', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('description', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('size', 'LIKE', '%'.$this->search.'%');
            })
            ->paginate(6, ['*'], 'freshness-page');

        return view('livewire.home.activities.freshness')->with([
            'products' => $products
        ]);
    }

    public function mount() {
        $this->freshness_data = [];
    }

    public function updatedSearch() {
        $this->resetPage('freshness-page');
    }

    public function saveSession() {
        $diser_activities = Session::get('diser_activities');
        $diser_activities['freshness_data'] = $this->freshness_data;

        Session::put('diser_activities', $diser_activities);
    }

    public function updatedFreshnessData() {
        $this->saveSession();
    }
}
