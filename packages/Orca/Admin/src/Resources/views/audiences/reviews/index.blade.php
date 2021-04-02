@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.audiences.reviews.title') }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('admin::app.audiences.reviews.title') }}</h1>
            </div>
            <div class="page-action">
                {{--  <a href="{{ route('admin.users.create') }}" class="btn btn-lg btn-primary">
                    {{ __('Add Audience') }}
                </a>  --}}
            </div>
        </div>

        <div class="page-content">
            @inject('review','Orca\Admin\DataGrids\AudienceReviewDataGrid')
            {!! $review->render() !!}
        </div>
    </div>

@stop