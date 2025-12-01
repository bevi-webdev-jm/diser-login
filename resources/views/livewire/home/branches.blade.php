<div>
    @if(empty($selected_branch))
        <div class="row mb-4">
            <div class="col-lg-3 mb-2">
                <div class="transition-transform duration-200 ease-in-out transform hover:scale-105 hover:-translate-y-1 rounded-lg overflow-hidden bg-white/10 backdrop-blur-md backdrop-saturate-125 border border-white/20 ring-1 ring-white/10 shadow-lg h-100">
                    <input type="text" name="search" id="search" wire:model.live="search" placeholder="{{ __('adminlte::utilities.search') }}" class="w-full bg-transparent border-none outline-none px-3 py-2 rounded">
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($branches as $branch)
                <div class="col-lg-3 my-2">
                    <a href="" class="text-dark" wire:click.prevent="selectBranch({{ $branch->id }})">
                        <div class="small-box transition-transform duration-200 ease-in-out transform hover:scale-105 hover:-translate-y-1 rounded-lg overflow-hidden bg-white/10 backdrop-blur-md backdrop-saturate-125 border border-white/20 ring-1 ring-white/10 shadow-lg h-100">
                            <div class="inner">
                                <h4 class="text-lg text-bold w-full whitespace-normal break-words">{{$branch->branch_name}}</h4>
                                <p class="text-uppercase mb-0">{{$branch->branch_code ?? 'N/A'}}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="row mt-3">
            <div class="col-12">
                {{ $branches->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">[{{ $selected_branch->branch_code }}] {{ $selected_branch->branch_name }}</h3>
                        <div class="card-tools">
                            <button class="btn btn-secondary btn-sm" wire:click.prevent="deselectBranch">
                                <i class="fa fa-caret-left"></i>
                                {{ __('adminlte::home.back_to_branches') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pb-4">
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

        <div class="row mb-3">
            <div class="col-12 text-right">
                <button class="btn btn-primary" wire:click.prevent="signIn" wire:loading.attr="disabled">
                    <i class="fa fa-sign-in-alt mr-1"></i>
                    Sign In
                </button>
            </div>
        </div>
    @endif

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
</div>
