<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Http\Requests\DiserIdNumberAddRequest;
use App\Http\Requests\DiserIdNumberEditRequest;
use App\Models\DiserIdNumber;
use App\Models\DiserAccount;

use App\Http\Traits\SettingTrait;

class DiserIdNumberController extends Controller
{
    use SettingTrait;

    public function index(Request $request) {
        $search = trim($request->get('search'));

        $diser_numbers = DiserIdNumber::orderBy('created_at', 'DESC')
            ->paginate($this->getDataPerPage())
            ->appends(request()->query());

        return view('pages.diser-numbers.index')->with([
            'diser_numbers' => $diser_numbers,
            'search' => $search
        ]);
    }

    public function create() {
        return view('pages.diser-numbers.create');
    }

    public function store(DiserIdNumberAddRequest $request) {
        $assigned_accounts = Session::get('diser_selected_accounts');

        $diser_number = new DiserIdNumber([
            'id_number' => $request->diser_number,
            'area' => $request->area,
        ]);
        $diser_number->save();

        $this->syncAccounts($diser_number, $assigned_accounts);

        // logs
        activity('created')
            ->performedOn($diser_number)
            ->log(':causer.name created Diser ID number :subject.diser_id_number');

        return redirect()->route('diser-number.index')->with([
            'message_success' => 'Diser ID Number has been successfully added.'
        ]);
    }

    public function show($id) {
        $diser_number = DiserIdNumber::findOrFail(decrypt($id));

        return view('pages.diser-numbers.show')->with([
            'diser_number' => $diser_number
        ]);
    }

    public function edit($id) {
        $diser_number = DiserIdNumber::findOrFail(decrypt($id));

        return view('pages.diser-numbers.edit')->with([
            'diser_number' => $diser_number
        ]);
    }

    public function update() {

    }

    private function syncAccounts($diser_number, $assigned_accounts) {
        // Manually sync accounts without using Eloquent's sync()
        $assignedAccounts = is_array($assigned_accounts) ? array_values(array_filter($assigned_accounts, fn($v) => $v !== null && $v !== '')) : [];
        $assignedAccounts = array_map('intval', $assignedAccounts);

        // Current related account IDs
        $currentAccountIds = DiserAccount::where('diser_id_number_id', $diser_number->id)
            ->pluck('account_id')
            ->map(fn($id) => (int) $id)
            ->toArray();

        // Determine which ids to attach and detach
        $toAttach = array_values(array_diff($assignedAccounts, $currentAccountIds));
        $toDetach = array_values(array_diff($currentAccountIds, $assignedAccounts));

        if (!empty($toDetach)) {
            $diser_account = DiserAccount::whereIn('account_id', $toDetach)
                ->where('diser_id_number_id', $diser_number->id)
                ->get();
            $diser_account->delete();
        }

        if (!empty($toAttach)) {
            foreach ($toAttach as $accountId) {
                $diser_account = new DiserAccount([
                    'diser_id_number_id' => $diser_number->id,
                    'account_id' => $accountId,
                ]);
                $diser_account->save();
            }
        }
    }
}
