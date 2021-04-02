@extends('site::layouts.master')

@section('page_title')
 {{ __('site::app.audience.forgot-password.page_title') }}
@stop

@push('css')
    <style>
        .button-group {
            margin-bottom: 25px;
        }
        .primary-back-icon {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content-wrapper')

<div class="auth-content">

    {!! view_render_event('orca.site.audiences.forget_password.before') !!}

    <form method="post" action="{{ route('audience.forgot-password.store') }}">

        {{ csrf_field() }}

        <div class="login-form">

            <div class="login-text">{{ __('site::app.audience.forgot-password.title') }}</div>

            {!! view_render_event('orca.site.audiences.forget_password_form_controls.before') !!}

            <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                <label for="email">{{ __('site::app.audience.forgot-password.email') }}</label>
                <input type="email" class="control" name="email" v-validate="'required|email'">
                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
            </div>

            {!! view_render_event('orca.site.audiences.forget_password_form_controls.before') !!}

            <div class="button-group">
                <input class="btn btn-primary btn-lg" type="submit" value="{{ __('site::app.audience.forgot-password.submit') }}">
            </div>

            <div class="control-group" style="margin-bottom: 0px;">
                <a href="{{ route('audience.session.index') }}">
                    <i class="icon primary-back-icon"></i>
                    {{ __('site::app.audience.reset-password.back-link-title') }}
                </a>
            </div>

        </div>
    </form>

    {!! view_render_event('orca.site.audiences.forget_password.before') !!}

</div>
@endsection