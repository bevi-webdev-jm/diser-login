<?php

namespace App\Livewire\Home;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Account;

class Accounts extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $selected_account;


    public function render()
    {
        $account_ids = [];
        $diser_number = auth()->user()->diser_number;
        if(!empty($diser_number)) {
            foreach($diser_number->accounts() as $account) {
                $account_ids[] = $account->id;
            }
        }

        $accounts = Account::orderBy('id', 'ASC')
            ->when(!auth()->user()->hasRole('superadmin'), function($query) use($account_ids) {
                $query->whereIn('id', $account_ids);
            })
            ->when(!empty($this->search), function($query) {
                $query->where('account_code', 'like', '%'.$this->search.'%')
                    ->orWhere('account_name', 'like', '%'.$this->search.'%')
                    ->orWhere('short_name', 'like', '%'.$this->search.'%');
            })
            ->paginate(12, ['*'], 'accounts-page');

        return view('livewire.home.accounts')->with([
            'accounts' => $accounts,
        ]);
    }

    public function updatedSearch() {
        $this->resetPage('accounts-page');
    }

    public function selectAccount($account_id) {
        $this->selected_account = Account::find($account_id);
    }

    public function deselectAccount() {
        $this->selected_account = null;
    }
}
