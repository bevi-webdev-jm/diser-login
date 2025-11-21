<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Branch;
use App\Models\DiserLogin;

use Illuminate\Support\Facades\Session;

class Branches extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $account;

    public $selected_branch;
    public $accuracy, $longitude, $latitude;

    public function render()
    {
        $branches = Branch::orderBy('branch_code', 'ASC')
            ->where('account_id', $this->account->id)
            ->when(!empty($this->search), function($query) {
                $query->where(function($qry) {
                    $qry->where('branch_code', 'like', '%'.$this->search.'%')
                        ->orWhere('branch_name', 'like', '%'.$this->search.'%');
                });
            })
            ->paginate(12, ['*'], 'branches-page');

        return view('livewire.home.branches')->with([
            'branches' => $branches
        ]);
    }

    public function mount($account) {
        $this->account = $account;

        $this->resetPage('branches-page');
    }

    public function updatedSearch() {
        $this->resetPage('branches-page');
    }

    public function selectBranch($branch_id) {
        $this->selected_branch = Branch::find($branch_id);

        $this->dispatch('load-location');
    }

    public function deselectBranch() {
        $this->selected_branch = null;
    }

    public function signIn() {
        $diser_login = new DiserLogin([
            'user_id' => auth()->user()->id,
            'account_id' => $this->account->id,
            'branch_id' => $this->selected_branch->id,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'accuracy' => $this->accuracy,
            'time_in' => now(),
            'time_out' => null,
        ]);
        $diser_login->save();

        Session::put('diser_login',$diser_login);

        return redirect()->to('/home');
    }
}
