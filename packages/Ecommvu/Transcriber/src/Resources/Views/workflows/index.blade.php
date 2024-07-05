@extends('admin::layouts.content')

@section('page_title')
    {{ __('admin::app.marketing.campaigns.title') }}
@stop

@section('content')
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('Therapy Consultations') }}</h1>
            </div>

            <div class="page-action">
                <a href="{{ route('admin.campaigns.create') }}" class="btn btn-lg btn-primary">
                    {{ __('Upload transcripts') }}
                </a>
            </div>
        </div>

        <div class="page-content">

            {!! app('Ecommvu\Transcriber\DataGrids\PatientConsultationDataGrid')->render() !!}

        </div>
    </div>
@stop