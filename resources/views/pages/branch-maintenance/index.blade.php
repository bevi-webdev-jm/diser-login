@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::branch-maintenance.branch_maintenance'))
@section('content_header_title', __('adminlte::branch-maintenance.branch_maintenance_list'))
@section('content_header_subtitle', __('adminlte::branch-maintenance.branch_maintenance'))

{{-- Content body: main page content --}}
@section('content_body')
    <div class="card">
        <div class="card-header py-2">
            <div class="row">
                <div class="col-lg-6 align-middle">
                    <strong class="text-lg">{{__('adminlte::branch-maintenance.branch_maintenance_list')}}</strong>
                </div>
                <div class="col-lg-6 text-right">
                    @can('branch maintenance create')
                        <a href="{{ route('branch-maintenance.create') }}" class="btn btn-primary btn-sm">
                            <i class="fa fa-file"></i>
                            {{ __('adminlte::branch-maintenance.new_branch') }}
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        <div class="card-body">

            {{ html()->form('GET', route('branch-maintenance.index'))->open() }}
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
                                <th>{{__('adminlte::branch-maintenance.account')}}</th>
                                <th>{{__('adminlte::branch-maintenance.branch_code')}}</th>
                                <th>{{__('adminlte::branch-maintenance.branch_name')}}</th>
                                <th>{{ __('adminlte::utilities.status') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                                <tr>
                                    <td class="align-middle text-center">
                                        [{{$branch->account()->account_code}}] {{ $branch->account()->short_name }}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{$branch->branch_code}}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{$branch->branch_name}}
                                    </td>
                                    <td class="align-middle text-center">
                                        {{$branch->status}}
                                    </td>
                                    <td class="align-middle text-right p-0 pr-1">
                                        <a href="{{route('company.show', encrypt($branch->id))}}" class="btn btn-info btn-xs mb-0 ml-0">
                                            <i class="fa fa-list"></i>
                                            {{__('adminlte::utilities.view')}}
                                        </a>
                                        @can('company edit')
                                            <a href="{{route('company.edit', encrypt($branch->id))}}" class="btn btn-success btn-xs mb-0 ml-0">
                                                <i class="fa fa-pen-alt"></i>
                                                {{__('adminlte::utilities.edit')}}
                                            </a>
                                        @endcan
                                        @can('company delete')
                                            <a href="" class="btn btn-danger btn-xs mb-0 ml-0 btn-delete" data-id="{{encrypt($branch->id)}}">
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
