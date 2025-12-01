<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ __('adminlte::activities.trade_photos') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="">UPLOAD PHOTO</label>
                        <input type="file" class="form-control" wire:model.live="photo_files" multiple>
                    </div>
                </div>
            </div>

            <table class="table table-sm table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Photo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(!empty($pictures_arr))
                        @foreach($pictures_arr as $key => $picture)
                            <tr>
                                <td class="p-0 align-middle">
                                    <input type="text" class="form-control form-control-sm border-0" wire:model.live="pictures_arr.{{$key}}.title">
                                </td>
                                <td class="p-0 align-middle text-center">
                                    @if(empty($picture['id']) && $picture['picture'])
                                        <img src="{{$picture['picture']->temporaryUrl()}}" style="max-height: 50px">
                                    @else
                                        <img src="{{asset($picture['picture'])}}" style="max-height: 50px">
                                    @endif
                                </td>
                                <td class="p-0 text-center align-middle">
                                    <button class="btn btn-xs btn-danger py-0" wire:click.prevent="removeLine({{ $key }})">
                                        <i class="fa fa-trash-alt fa-xs"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
        </div>
    </div>
</div>
