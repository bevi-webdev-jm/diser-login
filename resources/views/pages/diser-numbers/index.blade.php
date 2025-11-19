@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::diser-number.diser_numbers'))
@section('content_header_title', __('adminlte::diser-number.diser_number_list'))
@section('content_header_subtitle', __('adminlte::diser-number.diser_numbers'))

{{-- Content body: main page content --}}
@section('content_body')
    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::diser-number.diser_number_list')}}</strong>
                </div>
                <div class="col-lg-6 text-right">
                    @can('diser id number create')
                        <a href="{{ route('diser-number.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-file"></i>
                            {{ __('adminlte::diser-number.new_diser_number') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">

            {{ html()->form('GET', route('company.index'))->open() }}
                <div class="row mb-1">
                    <div class="col-lg-4">
                        <div class="form-group">
                            {{ html()->label(__('adminlte::utilities.search'), 'search')->class('mb-0') }}
                            {{ html()->input('text', 'search', $search)->placeholder(__('adminlte::utilities.name'))->class(['form-control', 'form-control-sm'])}}
                        </div>
                    </div>
                </div>
            {{ html()->form()->close() }}

            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-sm table-striped table-hover mb-0 rounded">
                        <thead class="tex-center bg-dark">
                            <tr class="text-center">
                                <th>{{__('adminlte::diser-number.diser_number')}}</th>
                                <th>{{__('adminlte::diser-number.area')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($diser_numbers as $diser_number)
                                <tr>
                                    <td class="align-middle text-center">
                                        {{$diser_number->id_number}}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{$diser_number->area}}
                                    </td>
                                    <td class="align-middle text-right p-0 pr-1">
                                        <a href="{{route('diser-number.show', encrypt($diser_number->id))}}" class="btn btn-info btn-xs mb-0 ml-0">
                                            <i class="fa fa-list"></i>
                                            {{__('adminlte::utilities.view')}}
                                        </a>
                                        @can('diser id number edit')
                                            <a href="{{route('diser-number.edit', encrypt($diser_number->id))}}" class="btn btn-success btn-xs mb-0 ml-0">
                                                <i class="fa fa-pen-alt"></i>
                                                {{__('adminlte::utilities.edit')}}
                                            </a>
                                        @endcan
                                        @can('diser id number delete')
                                            <a href="" class="btn btn-danger btn-xs mb-0 ml-0 btn-delete" data-id="{{encrypt($diser_number->id)}}">
                                                <i class="fa fa-trash-alt"></i>
                                                {{__('adminlte::utilities.delete')}}
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="card-footer">
            {{ $diser_numbers->links() }}
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
