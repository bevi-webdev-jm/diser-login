<div>
    @if(empty($selected_account))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Accounts</h3>
                <div class="card-tools">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('adminlte::utilities.search') }}" wire:model.live="search">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($accounts as $account)
                        <div class="col-lg-3">
                            <div class="small-box">
                                <div class="inner">
                                    <h3>{{ $account->account_code }}</h3>
                                    <p class="text-uppercase mb-0">{{ $account->account_name }}</p>
                                    <small class="text-muted">{{ $account->short_name }}</small>
                                </div>
                                <div class="icon">

                                </div>
                                <a href="#" class="small-box-footer get-location bg-primary" wire:click.prevent="selectAccount({{ $account->id }})">
                                    Sign In
                                    <i class="fas fa-arrow-circle-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card-footer pb-0">
                {{ $accounts->links() }}
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Branches</h3>
                <div class="card-tools">
                    <button class="btn btn-secondary btn-sm" wire:click.prevent="deselectAccount">
                        <i class="fa fa-caret-left"></i>
                        {{ __('adminlte::home.back_to_accounts') }}
                    </button>
                </div>
            </div>
            <div class="card-body pb-0">
                <livewire:home.branches :account="$selected_account" />
            </div>
        </div>
    @endif
</div>
