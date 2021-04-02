@extends('site::layouts.master')
@section('page_title')
    {{ __('site::app.audience.signup-form.page-title') }}
@endsection
@section('content-wrapper')

<div class="auth-content">

    <div class="sign-up-text">
        {{ __('site::app.audience.signup-text.account_exists') }} - <a href="{{ route('audience.session.index') }}">{{ __('site::app.audience.signup-text.title') }}</a>
    </div>

    {!! view_render_event('orca.site.audiences.signup.before') !!}

    <form method="post" action="{{ route('audience.register.create') }}" @submit.prevent="onSubmit">

        {{ csrf_field() }}

        <div class="login-form">
            <div class="login-text">{{ __('site::app.audience.signup-form.title') }}</div>

            {!! view_render_event('orca.site.audiences.signup_form_controls.before') !!}

            <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                <label for="first_name" class="required">{{ __('site::app.audience.signup-form.firstname') }}</label>
                <input type="text" class="control" name="first_name" v-validate="'required'" value="{{ old('first_name') }}" data-vv-as="&quot;{{ __('site::app.audience.signup-form.firstname') }}&quot;">
                <span class="control-error" v-if="errors.has('first_name')">@{{ errors.first('first_name') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                <label for="last_name" class="required">{{ __('site::app.audience.signup-form.lastname') }}</label>
                <input type="text" class="control" name="last_name" v-validate="'required'" value="{{ old('last_name') }}" data-vv-as="&quot;{{ __('site::app.audience.signup-form.lastname') }}&quot;">
                <span class="control-error" v-if="errors.has('last_name')">@{{ errors.first('last_name') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                <label for="email" class="required">{{ __('site::app.audience.signup-form.email') }}</label>
                <input type="email" class="control" name="email" v-validate="'required|email'" value="{{ old('email') }}" data-vv-as="&quot;{{ __('site::app.audience.signup-form.email') }}&quot;">
                <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                <label for="password" class="required">{{ __('site::app.audience.signup-form.password') }}</label>
                <input type="password" class="control" name="password" v-validate="'required|min:6'" ref="password" value="{{ old('password') }}" data-vv-as="&quot;{{ __('site::app.audience.signup-form.password') }}&quot;">
                <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
            </div>

            <div class="control-group" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                <label for="password_confirmation" class="required">{{ __('site::app.audience.signup-form.confirm_pass') }}</label>
                <input type="password" class="control" name="password_confirmation"  v-validate="'required|min:6|confirmed:password'" data-vv-as="&quot;{{ __('site::app.audience.signup-form.confirm_pass') }}&quot;">
                <span class="control-error" v-if="errors.has('password_confirmation')">@{{ errors.first('password_confirmation') }}</span>
            </div>

            {{-- <div class="signup-confirm" :class="[errors.has('agreement') ? 'has-error' : '']">
                <span class="checkbox">
                    <input type="checkbox" id="checkbox2" name="agreement" v-validate="'required'">
                    <label class="checkbox-view" for="checkbox2"></label>
                    <span>{{ __('site::app.audience.signup-form.agree') }}
                        <a href="">{{ __('site::app.audience.signup-form.terms') }}</a> & <a href="">{{ __('site::app.audience.signup-form.conditions') }}</a> {{ __('site::app.audience.signup-form.using') }}.
                    </span>
                </span>
                <span class="control-error" v-if="errors.has('agreement')">@{{ errors.first('agreement') }}</span>
            </div> --}}

            {!! view_render_event('orca.site.audiences.signup_form_controls.after') !!}

            {{-- <div class="control-group" :class="[errors.has('agreement') ? 'has-error' : '']">

                <input type="checkbox" id="checkbox2" name="agreement" v-validate="'required'" data-vv-as="&quot;{{ __('site::app.audience.signup-form.agreement') }}&quot;">
                <span>{{ __('site::app.audience.signup-form.agree') }}
                    <a href="">{{ __('site::app.audience.signup-form.terms') }}</a> & <a href="">{{ __('site::app.audience.signup-form.conditions') }}</a> {{ __('site::app.audience.signup-form.using') }}.
                </span>
                <span class="control-error" v-if="errors.has('agreement')">@{{ errors.first('agreement') }}</span>
            </div> --}}

            <button class="btn btn-primary btn-lg" type="submit">
                {{ __('site::app.audience.signup-form.button_title') }}
            </button>

        </div>
    </form>

    {!! view_render_event('orca.site.audiences.signup.after') !!}
</div>
@endsection
