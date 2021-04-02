@extends('admin::layouts.master')

@section('page_title')
    {{ __('admin::app.dashboard.title') }}
@stop

@section('content-wrapper')

    <div class="content full-page dashboard">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.dashboard.title') }}</h1>
            </div>

            <div class="page-action">
                <date-filter></date-filter>
            </div>
        </div>

        <div class="page-content">
            <h1>dashboard</h1>
        </div>
    </div>

@stop

@push('scripts')
@endpush