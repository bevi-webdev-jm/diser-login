<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('adminlte::diser-number.assigned_accounts') }}</h3>
            <div class="card-tools">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control form-control-sm" placeholder="{{ __('adminlte::utilities.search') }}" wire:model.live="search">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($accounts as $account)
                    <div class="col-lg-4 mb-1">
                        <button class="btn {{ !empty($selected_accounts[$account->id]) ? 'btn-primary' : 'btn-default' }} btn-block text-left" wire:click.prevent="selectAccount({{ $account->id }})">
                            [{{ $account->account_code }}] {{ $account->account_name }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="card-footer pb-0">
            {{ $accounts->links() }}
        </div>
    </div>
</div>
