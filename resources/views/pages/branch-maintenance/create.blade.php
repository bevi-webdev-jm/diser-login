@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::branch-maintenance.branch_maintenance'))
@section('content_header_title', __('adminlte::branch-maintenance.new_branch'))
@section('content_header_subtitle', __('adminlte::branch-maintenance.branch_maintenance'))

{{-- Content body: main page content --}}
@section('content_body')
{{ html()->form('POST', route('branch-maintenance.store'))->open() }}

    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::branch-maintenance.new_branch')}}</strong>
                </div>
                <div class="col-lg-6 text-right">
                    <a href="{{ route('branch-maintenance.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fa fa-caret-left"></i>
                        {{ __('adminlte::utilities.back') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        {{ html()->label(__('adminlte::branch-maintenance.branch_code'), 'name')->class(['mb-0']) }}
                        {{ html()->input('text', 'branch_code', '')->placeholder(__('adminlte::branch-maintenance.branch_code'))->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('branch_code')]) }}
                        <small class="text-danger">{{$errors->first('branch_code')}}</small>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        {{ html()->label(__('adminlte::branch-maintenance.branch_name'), 'name')->class(['mb-0']) }}
                        {{ html()->input('text', 'branch_name', '')->placeholder(__('adminlte::branch-maintenance.branch_name'))->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('branch_name')]) }}
                        <small class="text-danger">{{$errors->first('branch_name')}}</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        {{ html()->label(__('adminlte::branch-maintenance.areas'), 'area_id')->class(['mb-0']) }}
                        {{ html()->select('area_id', $areas,'')->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('area_id')]) }}
                        <small class="text-danger">{{$errors->first('area_id')}}</small>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        {{ html()->label(__('adminlte::branch-maintenance.channels'), 'classification_id')->class(['mb-0']) }}
                        {{ html()->select('classification_id', $classifications,'')->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('classification_id')]) }}
                        <small class="text-danger">{{$errors->first('classification_id')}}</small>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        {{ html()->label(__('adminlte::branch-maintenance.regions'), 'region_id')->class(['mb-0']) }}
                        {{ html()->select('region_id', $regions,'')->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('region_id')]) }}
                        <small class="text-danger">{{$errors->first('region_id')}}</small>
                    </div>
                </div>
            </div>

            <div class="card mb-0">
                <div class="card-header py-1">
                    <strong class="text-lg">{{ __('adminlte::branch-maintenance.branch_location') }}</strong>
                    <div class="card-tools">
                        <button type="button" class="btn btn-info btn-sm" id="reload-location">
                            <i class="fa fa-recycle"></i>
                            {{ __('adminlte::branch-maintenance.reload_location') }}
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                {{ html()->label(__('adminlte::utilities.longitude'), 'longitude')->class(['mb-0']) }}
                                {{ html()->input('text', 'longitude', '')->placeholder(__('adminlte::utilities.longitude'))->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('longitude')]) }}
                                <small class="text-danger">{{$errors->first('longitude')}}</small>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                {{ html()->label(__('adminlte::utilities.latitude'), 'latitude')->class(['mb-0']) }}
                                {{ html()->input('text', 'latitude', '')->placeholder(__('adminlte::utilities.latitude'))->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('latitude')]) }}
                                <small class="text-danger">{{$errors->first('latitude')}}</small>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                {{ html()->label(__('adminlte::utilities.accuracy').' (m)', 'accuracy')->class(['mb-0']) }}
                                {{ html()->input('text', 'accuracy', '')->placeholder(__('adminlte::utilities.accuracy'))->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('accuracy')]) }}
                                <smaall class="text-danger">{{$errors->first('accuracy')}}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer text-right">
            {{ html()->submit('<i class="fa fa-save"></i> '.__('adminlte::branch-maintenance.save_branch'))->class(['btn', 'btn-primary', 'btn-sm']) }}
        </div>
    </div>

{{ html()->form()->close() }}
@stop

{{-- Push extra CSS --}}
@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}
@push('js')
    <script>
        $(function() {
            getLocation();

            $('#reload-location').click(function(e) {
                e.preventDefault();
                getLocation();
            });

            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {

                        $('body').find('#latitude').val(position.coords.latitude);
                        $('body').find('#longitude').val(position.coords.longitude);
                        $('body').find('#accuracy').val(position.coords.accuracy);

                        console.log(position);
                    }, function(error) {
                        console.error("Geolocation Error:", error.message);
                    });
                } else {
                    console.log("Geolocation is not supported by this browser.");
                }
            }
        });
    </script>
@endpush
