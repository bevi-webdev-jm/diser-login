<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('adminlte::home.activity_header') }}</h3>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="date">{{ __('adminlte::home.date') }}</label>
                        <input type="date" id="date" class="form-control" wire:model="date" disabled>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="merchandiser_name">{{ __('adminlte::home.merchandiser_name') }}</label>
                        <input type="text" id="merchandiser_name" class="form-control" wire:model.live="merchandiser_name">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="area">{{ __('adminlte::home.area') }}</label>
                        <input type="text" id="area" class="form-control" wire:model.live="area">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="pms_name">{{ __('adminlte::home.pms_name') }}</label>
                        <input type="text" id="pms_name" class="form-control" wire:model="pms_name">
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="store_in_charge">{{ __('adminlte::home.store_in_charge') }}</label>
                        <input type="text" id="store_in_charge" class="form-control" wire:model="store_in_charge">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('adminlte::activities.activities') }}</h3>
        </div>

        <div class="card-body">
            <!-- Stepper header -->
            <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-x-4 md:space-y-0 mb-6">
                @foreach ($steps_arr as $i => $step_str)

                    <button type="button"
                        wire:click="goToStep({{ $i }})"
                        class="flex items-center space-x-2 focus:outline-none text-left w-full md:w-auto">
                        <span
                            class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                            {{ $step === $i ? 'bg-indigo-600 text-white border-indigo-600 shadow-md' : 'bg-gray-200 text-gray-600 border-gray-300 hover:border-indigo-400' }}">
                            {{ $i }}
                        </span>
                        <span class="{{ $step === $i ? 'font-semibold text-gray-900' : 'text-gray-500' }} text-sm">
                            {{ $step_str }}
                        </span>
                    </button>

                    @if (!$loop->last)
                        <div class="hidden md:flex-1 md:block border-t border-gray-300 md:mx-0"></div>

                        <div class="ml-4 md:hidden h-4 border-l border-gray-300"></div>
                    @endif
                @endforeach
            </div>

            <!-- Step content -->
            <div class="space-y-4">
                @if ($step === 1)
                    <div>
                        <h4 class="font-medium">Out of Stock Reports</h4>
                        <livewire:home.activities.oos/>
                    </div>
                @elseif ($step === 2)
                    <div>
                        <h4 class="font-medium">On Shelf Availability Reports</h4>
                        <livewire:home.activities.osa/>
                    </div>
                @elseif ($step === 3)
                    <div>
                        <h4 class="font-medium">Inventory Freshness</h4>
                        <livewire:home.activities.freshness/>
                    </div>
                @elseif ($step === 4)
                    <div>
                        <h4 class="font-medium">Return to Vendor Reports</h4>
                        <livewire:home.activities.rtv/>
                    </div>
                @elseif ($step === 5)
                    <div>
                        <h4 class="font-medium">Share of Shelf Bath</h4>
                        <livewire:home.activities.share_of_shelf_bath/>
                    </div>
                @elseif ($step === 6)
                    <div>
                        <h4 class="font-medium">Share of Shelf Antibac Soap</h4>
                        <livewire:home.activities.share_of_shelf_antibac_soap/>
                    </div>
                @elseif ($step === 7)
                    <div>
                        <h4 class="font-medium">Trade Photos</h4>
                        <livewire:home.activities.trade_photos/>
                    </div>
                @elseif ($step === 8)
                    <div>
                        <h4 class="font-medium">Total Findings</h4>
                        <livewire:home.activities.total_findings/>
                    </div>
                @endif

            </div>

            <!-- Navigation -->
            <div class="mt-6 flex justify-between">
                <button type="button"
                    wire:click="prevStep"
                    @if($step === 1) disabled @endif
                    class="px-4 py-2 rounded border {{ $step === 1 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700' }}">
                    Previous
                </button>

                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600">Step {{ $step }} / {{ count($steps_arr) }}</span>

                    <button type="button"
                        wire:click="nextStep"
                        @if($step === count($steps_arr)) disabled @endif
                        class="px-4 py-2 {{ $step === count($steps_arr) ? 'bg-blue-400 text-white cursor-not-allowed' : 'rounded bg-primary text-white' }}">
                        Next
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
