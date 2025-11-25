<div>
    @if(!empty($diser_login))
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    [{{ $diser_login->account->account_code }} - {{ $diser_login->account->short_name }}]
                    {{ $diser_login->branch->code ?? 'N/A' }} - {{ $diser_login->branch->branch_name }}
                </h3>
                <div class="card-tools">
                    <button class="btn btn-warning btn-sm" wire:click="signOut">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('adminlte::home.sign_out') }}
                    </button>
                </div>
            </div>
        </div>

        @script
        <script>
            $wire.on('load-location', () => {
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
            });
        </script>
        @endscript

    @endif

</div>
