<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('adminlte::activities.total_findings') }}</h3>
            <div class="card-tools">
                <input type="text" class="form-control form-control-sm" placeholder="Search" wire:model.live="search">
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group mb-0">
                        <label for="total_findings">TOTAL FINDINGS</label>
                        <textarea class="form-control form-control-sm" id="total_findings" wire:model.blur="total_findings"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>
