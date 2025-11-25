<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('adminlte::activities.share_of_shelf_bath') }}</h3>
        </div>
        <div class="card-body p-1">

            <ul class="list-group">
                @foreach($share_of_shelf_data as $data)
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Brand</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Size in mm.</label>
                            <input type="text" class="form-control form-control-sm">
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>

        </div>
        <div class="card-footer text-right">
            <button class="btn btn-info btn-sm" wire:click.prevent="addLine">
                <i class="fa fa-plus mr-1"></i>
                Add Line
            </button>
        </div>
    </div>
</div>
