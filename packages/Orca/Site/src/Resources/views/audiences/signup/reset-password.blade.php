@extends('site::layouts.master')

@section('page_title')
 {{ __('site::app.audience.reset-password.title') }}
@endsection

@section('content-wrapper')

<div class="auth-content">

    {!! view_render_event('orca.site.audiences.reset_password.before') !!}

    <form method="post" action="{{ route('audience.reset-password.store') }}" >

        {{ csrf_field() }}

        <div class="login-form">

            <div class="login-text">{{ __('site::app.audience.reset-password.title') }}</div>

            <input type="hidden" name="token" value="{{ $token }}">

            {!! view_render_event('orca.site.audiences.reset_password_form_controls.before') !!}

            <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                <label for="email">{{ __('site::app.audience.reset-password.email') }}</label>
                <input type="text" v-validate="'required|email'" class="control" id="email" name="email" value="{{ old('email') }}"/>
                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                <label for="password">{{ __('site::app.audience.reset-password.password') }}</label>
                <input type="password" class="control" name="password" v-validate="'required|min:6'" ref="password">
                <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('confirm_password') ? 'has-error' : '']">
                <label for="confirm_password">{{ __('site::app.audience.reset-password.confirm-password') }}</label>
                <input type="password" class="control" name="password_confirmation"  v-validate="'required|min:6|confirmed:password'">
                <span class="control-error" v-if="errors.has('confirm_password')">@{{ errors.first('confirm_password') }}</span>
            </div>

            {!! view_render_event('orca.site.audiences.reset_password_form_controls.before') !!}

            <input class="btn btn-primary btn-lg" type="submit" value="{{ __('site::app.audience.reset-password.submit-btn-title') }}">

        </div>
    </form>

    {!! view_render_event('orca.site.audiences.reset_password.before') !!}
</div>
@endsection