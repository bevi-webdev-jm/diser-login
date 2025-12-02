@extends('layouts.app')

{{-- Customize layout sections --}}
@section('subtitle', __('adminlte::branch-maintenance.branch_maintenance'))
@section('content_header_title', __('adminlte::branch-maintenance.new_branch'))
@section('content_header_subtitle', __('adminlte::branch-maintenance.branch_maintenance'))

{{-- Content body: main page content --}}
@section('content_body')
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
                        <label for=""></label>
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
