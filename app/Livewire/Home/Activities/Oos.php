<?php

namespace App\Livewire\Home\Activities;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class Oos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $oos_data;

    public function render()
    {
        $products = Product::orderBy('stock_code', 'ASC')
            ->when(!empty($this->search), function($query) {
                $query->where('stock_code', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('description', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('size', 'LIKE', '%'.$this->search.'%');
            })
            ->paginate(6, ['*'], 'oos-page');

        return view('livewire.home.activities.oos')->with([
            'products' => $products
        ]);
    }

    public function mount() {
        $this->oos_data = [];
    }

    public function updatedSearch() {
        $this->resetPage('oos-page');
    }

    public function saveSession() {
        $diser_activities = Session::get('diser_activities');
        $diser_activities['oos_data'] = $this->oos_data;

        Session::put('diser_activities', $diser_activities);
    }

    public function updatedOosData() {
        $this->saveSession();
    }
}
