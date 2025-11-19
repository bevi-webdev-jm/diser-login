@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::diser-number.diser_numbers'))
@section('content_header_title', __('adminlte::diser-number.diser_number_details'))
@section('content_header_subtitle', __('adminlte::diser-number.diser_numbers'))

{{-- Content body: main page content --}}
@section('content_body')

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header py-2">
                    <div class="row">
                        <div class="col-lg-6 align-middle">
                            <strong class="text-lg">{{__('adminlte::diser-number.diser_number_details')}}</strong>
                        </div>
                        <div class="col-lg-6 text-right">
                            <a href="{{route('diser-number.index')}}" class="btn btn-secondary btn-xs">
                                <i class="fa fa-caret-left"></i>
                                {{__('adminlte::utilities.back')}}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">

                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header py-2">
                            <div class="row">
                                <div class="col-lg-6 align-middle">
                                    <strong class="text-lg">{{__('adminlte::diser-number.diser_number_users')}}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header py-2">
                            <div class="row">
                                <div class="col-lg-6 align-middle">
                                    <strong class="text-lg">{{__('adminlte::diser-number.diser_number_accounts')}}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                        </div>
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
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
