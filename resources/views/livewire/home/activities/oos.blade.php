<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('adminlte::activities.oos_reports') }}</h3>
            <div class="card-tools">
                <input type="text" class="form-control form-control-sm" placeholder="Search" wire:model.live="search">
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="list-group">
                @foreach($products as $product)
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-lg-4">
                                <strong class="text-lg">{{ $product->stock_code }}</strong><br>
                                <span>{{ $product->description }}</span><br>
                                <span>{{ $product->size }}</span>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Days of OOS</label>
                                    <input type="number" class="form-control form-control-sm" wire:model.blur="oos_data.{{ $product->id }}.days_of_oos" placeholder="Days of out of stock">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Maxcap Target</label>
                                    <input type="number" class="form-control form-control-sm" wire:model.blur="oos_data.{{ $product->id }}.maxcap_target" placeholder="Maxcap target">
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
