<div>
    @if(!empty($diser_login))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    [{{ $diser_login->account->account_code }} - {{ $diser_login->account->short_name }}]
                    {{ $diser_login->branch->code ?? 'N/A' }} - {{ $diser_login->branch->branch_name }}
                </h3>
                <div class="card-tools">
                    @if(!$confirm_signout)
                        <button class="btn btn-warning btn-sm" wire:click="signOut">
                            <i class="fas fa-sign-out-alt"></i>
                            {{ __('adminlte::home.sign_out') }}
                        </button>
                    @endif
                </div>
            </div>
            @if($confirm_signout)
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="rounded-lg overflow-hidden bg-white/10 backdrop-blur-md backdrop-saturate-125 border border-white/20 ring-1 ring-white/10 shadow-sm p-4">
                                <h5 class="text-lg font-semibold mb-3">Current location</h5>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-3">
                                    <div>
                                        <label for="longitude" class="form-label text-xs text-muted">Longitude</label>
                                        <div class="flex items-center gap-2 mt-1">
                                            <input id="longitude" type="text" readonly wire:model="longitude" class="form-control form-control-sm flex-grow bg-transparent" aria-label="Longitude">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="navigator.clipboard.writeText(document.getElementById('longitude').value)" title="Copy longitude">
                                                Copy
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="latitude" class="form-label text-xs text-muted">Latitude</label>
                                        <div class="flex items-center gap-2 mt-1">
                                            <input id="latitude" type="text" readonly wire:model="latitude" class="form-control form-control-sm flex-grow bg-transparent" aria-label="Latitude">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="navigator.clipboard.writeText(document.getElementById('latitude').value)" title="Copy latitude">
                                                Copy
                                            </button>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="accuracy" class="form-label text-xs text-muted">Accuracy (m)</label>
                                        <div class="flex items-center gap-2 mt-1">
                                            <input id="accuracy" type="text" readonly wire:model="accuracy" class="form-control form-control-sm flex-grow bg-transparent" aria-label="Accuracy in meters">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="navigator.clipboard.writeText(document.getElementById('accuracy').value)" title="Copy accuracy">
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <button
                                        type="button"
                                        wire:click.prevent="$dispatch('load-location')"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-600 text-white rounded-md text-sm"
                                        aria-live="polite"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.49 9A9 9 0 1111 3" />
                                            </svg>

                                            <span>Reload</span>

                                            <span wire:loading wire:target="latitude,longitude,accuracy" class="ml-1 inline-flex items-center">
                                                <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                                                </svg>
                                            </span>
                                        </button>

                                        <small class="text-muted text-sm">Allow your browser to share location.</small>
                                    </div>

                                    <div class="text-right text-sm text-muted">
                                        <span wire:loading wire:target="latitude,longitude,accuracy">Updating…</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-danger btn-sm" wire:click.prevent="cancelSignOut" wire:loading.attr="disabled">
                        <i class="fa fa-ban"></i>
                        CANCEL
                    </button>
                    <button class="btn btn-success btn-sm" wire:click.prevent="updateLogin" wire:loading.attr="disabled">
                        <i class="fa fa-check"></i>
                        CONFIRM SIGNOUT
                    </button>
                </div>
            @endif
        </div>

        @script
        <script>
            $wire.on('load-location', () => {
                getLocation();
            });

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {

                        $wire.set('latitude', position.coords.latitude);
                        $wire.set('longitude', position.coords.longitude);
                        $wire.set('accuracy', position.coords.accuracy);
                    }, function(error) {
                        console.error("Geolocation Error:", error.message);
                    });
                } else {
                    console.log("Geolocation is not supported by this browser.");
                }
            }
        </script>
        @endscript

    @endif

</div>
