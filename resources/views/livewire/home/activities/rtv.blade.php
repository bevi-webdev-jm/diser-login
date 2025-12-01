<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('adminlte::activities.rtv_reports') }}</h3>
            <div class="card-tools">
                <input type="text" class="form-control form-control-sm" placeholder="Search" wire:model.live="search">
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="list-group">
                @foreach($products as $product)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-3">
                                <strong>{{ $product->stock_code }}</strong><br>
                                <span>{{ $product->description }}</span><br>
                                <span>{{ $product->size }}</span>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">RTV Number</label>
                                    <input type="text" class="form-control form-control-sm" wire:model.blur="rtv_data.{{ $product->id }}.rtv_number" placeholder="RTV Number">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Reason of RTV</label>
                                    <input type="text" class="form-control form-control-sm" wire:model.blur="rtv_data.{{ $product->id }}.reason" placeholder="Reason">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label for="">Inventory Count</label>
                                    <input type="number" class="form-control form-control-sm" wire:model.blur="rtv_data.{{ $product->id }}.inventory_count" placeholder="Inventory count">
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="card-footer">
            {{ $products->links(data: ['scrollTo' => false]) }}
        </div>
    </div>
</div>
