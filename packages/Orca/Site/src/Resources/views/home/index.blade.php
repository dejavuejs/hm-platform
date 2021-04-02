@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.home.page-title') }}
@endsection

@section('content-wrapper')

    {!! view_render_event('orca.site.home.content.before') !!}

    {!! DbView::make(core()->getCurrentChannel())->field('home_page_content')->with(['sliderData' => $sliderData])->render() !!}

    {{ view_render_event('orca.site.home.content.after') }}

@endsection
