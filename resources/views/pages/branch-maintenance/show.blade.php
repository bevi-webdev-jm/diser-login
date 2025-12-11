@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::branch-maintenance.branch_maintenance'))
@section('content_header_title', __('adminlte::branch-maintenance.branch_maintenance_details'))
@section('content_header_subtitle', __('adminlte::branch-maintenance.branch_maintenance'))

{{-- Content body: main page content --}}
@section('content_body')
    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::branch-maintenance.branch_maintenance_details')}}</strong>
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
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('adminlte::branch-maintenance.branch_maintenance_details')}}</h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <strong>{{ __('adminlte::branch-maintenance.branch_name') }}:</strong>
                                    <span class="float-right">{{ $branch->branch_code }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('adminlte::branch-maintenance.branch_name') }}:</strong>
                                    <span class="float-right">{{ $branch->branch_name }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('adminlte::branch-maintenance.account') }}:</strong>
                                    <span class="float-right">[{{ $branch->account()->account_code }}] {{ $branch->account()->short_name }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('adminlte::branch-maintenance.channel') }}:</strong>
                                    <span class="float-right">[{{ $branch->classification()->classification_code }}] {{ $branch->classification()->classification_name }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('adminlte::branch-maintenance.area') }}:</strong>
                                    <span class="float-right">[{{ $branch->area()->area_code }}] {{ $branch->area()->area_name }}</span>
                                </li>
                                <li class="list-group-item">
                                    <strong>{{ __('adminlte::branch-maintenance.region') }}:</strong>
                                    <span class="float-right">{{ $branch->region()->region_name }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('adminlte::branch-maintenance.branch_location')}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <span>LONGITUDE: </span>
                                    <strong>{{ $branch->longitude }}</strong>
                                </div>
                                <div class="col-lg-4">
                                    <span>LATITUDE: </span>
                                    <strong>{{ $branch->latitude }}</strong>
                                </div>
                                <div class="col-lg-4">
                                    <span>ACCURACY (m): </span>
                                    <strong>{{ $branch->accuracy }}</strong>
                                </div>
                                <div class="col-12">
                                    <hr>
                                    <strong>ADDRESS: </strong>
                                    <p>{{ \App\Helpers\LocationHelper::instance()->getAddress($branch->latitude, $branch->longitude) }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
        </div>
    </div>
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
        });
    </script>
@endpush
