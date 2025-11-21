<?php

namespace App\Livewire\DiserNumber;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Account;
use Illuminate\Support\Facades\Session;

class AssignAccount extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $search;
    public $selected_accounts;

    public $diser_number;

    public function render()
    {
        $accounts = Account::orderBy('id', 'ASC')
            ->when(!empty($this->search), function($query) {
                $query->where('account_code', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('account_name', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('short_name', 'LIKE', '%'.$this->search.'%');
            })
            ->paginate(15);

        return view('livewire.diser-number.assign-account')->with([
            'accounts' => $accounts
        ]);
    }

    public function mount($diser_number) {
        $this->diser_number = $diser_number;
        $diser_selected_accounts = Session::get('diser_selected_accounts', []);
        if(!empty($diser_number) && empty($diser_selected_accounts)) {
            $assigned_accounts = $diser_number->accounts()->pluck('id')->map(fn($id) => (int) $id)->toArray();
            $this->selected_accounts = array_fill_keys($assigned_accounts, true);
            $this->saveToSession();
        } else {
            $this->selected_accounts = array_fill_keys($diser_selected_accounts, true);
        }
    }

    public function selectAccount($account_id) {
        if(!empty($this->selected_accounts[$account_id])) {
            unset($this->selected_accounts[$account_id]);
        } else {
            $this->selected_accounts[$account_id] = true;
        }

        $this->saveToSession();
    }

    private function saveToSession() {
        $selected = array_keys($this->selected_accounts);
        Session::put('diser_selected_accounts', $selected);
    }
}
