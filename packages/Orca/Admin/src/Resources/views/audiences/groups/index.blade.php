@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.audiences.groups.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.audiences.groups.title') }}</h1>
            </div>
            <div class="page-action">
                <a href="{{ route('admin.groups.create') }}" class="btn btn-lg btn-primary">
                    {{ __('admin::app.audiences.groups.add-title') }}
                </a>
            </div>
        </div>

        <div class="page-content">
            @inject('audienceGroup','Orca\Admin\DataGrids\AudienceGroupDataGrid')
            {!! $audienceGroup->render() !!}
        </div>
    </div>

@stop