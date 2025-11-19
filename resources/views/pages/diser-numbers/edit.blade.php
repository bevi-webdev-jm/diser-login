@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::diser-number.diser_numbers'))
@section('content_header_title', __('adminlte::diser-number.new_diser_number'))
@section('content_header_subtitle', __('adminlte::diser-number.diser_numbers'))

{{-- Content body: main page content --}}
@section('content_body')
{{ html()->form('POST', route('diser-number.store'))->open() }}

    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::diser-number.new_diser_number')}}</strong>
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

            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group">
                        {{ html()->label(__('adminlte::diser-number.diser_number'), 'diser_number')->class(['mb-0']) }}
                        {{
                            html()->text('diser_number', $diser_number->id_number)
                            ->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('diser_number')])
                            ->placeholder(__('adminlte::diser-number.diser_number'))
                        }}
                        <small class="text-danger">{{$errors->first('diser_number')}}</small>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="form-group">
                        {{ html()->label(__('adminlte::diser-number.area'), 'area')->class(['mb-0']) }}
                        {{
                            html()->text('area', $diser_number->area)
                            ->class(['form-control', 'form-control-sm', 'is-invalid' => $errors->has('area')])
                            ->placeholder(__('adminlte::diser-number.area'))
                        }}
                        <small class="text-danger">{{$errors->first('area')}}</small>
                    </div>
                </div>

                <div class="col-12">
                    <livewire:diser-number.assign-account :diser_number="$diser_number"/>
                </div>
            </div>

        </div>
        <div class="card-footer text-right">
            {{ html()->submit('<i class="fa fa-save"></i> '.__('adminlte::companies.save_company'))->class(['btn', 'btn-primary', 'btn-sm']) }}
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
        });
    </script>
@endpush
