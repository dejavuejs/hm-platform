@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.audience.login-form.page-title') }}
@endsection

@section('content-wrapper')

    <div class="auth-content">
        <div class="sign-up-text">
            {{ __('site::app.audience.login-text.no_account') }} - <a href="{{ route('audience.register.index') }}">{{ __('site::app.audience.login-text.title') }}</a>
        </div>

        {!! view_render_event('orca.site.audiences.login.before') !!}

        <form method="POST" action="{{ route('audience.session.create') }}" @submit.prevent="onSubmit">
            {{ csrf_field() }}
            <div class="login-form">
                <div class="login-text">{{ __('site::app.audience.login-form.title') }}</div>

                {!! view_render_event('orca.site.audiences.login_form_controls.before') !!}

                <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                    <label for="email" class="required">{{ __('site::app.audience.login-form.email') }}</label>
                    <input type="text" class="control" name="email" v-validate="'required|email'" value="{{ old('email') }}" data-vv-as="&quot;{{ __('site::app.audience.login-form.email') }}&quot;">
                    <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                </div>

                <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                    <label for="password" class="required">{{ __('site::app.audience.login-form.password') }}</label>
                    <input type="password" class="control" name="password" v-validate="'required'" value="{{ old('password') }}" data-vv-as="&quot;{{ __('site::app.audience.login-form.password') }}&quot;">
                    <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
                </div>

                {!! view_render_event('orca.site.audiences.login_form_controls.after') !!}

                <div class="forgot-password-link">
                    <a href="{{ route('audience.forgot-password.create') }}">{{ __('site::app.audience.login-form.forgot_pass') }}</a>

                    <div class="mt-10">
                        @if (Cookie::has('enable-resend'))
                            @if (Cookie::get('enable-resend') == true)
                                <a href="{{ route('audience.resend.verification-email', Cookie::get('email-for-resend')) }}">{{ __('site::app.audience.login-form.resend-verification') }}</a>
                            @endif
                        @endif
                    </div>
                </div>

                <input class="btn btn-primary btn-lg" type="submit" value="{{ __('site::app.audience.login-form.button_title') }}">
            </div>
        </form>

        {!! view_render_event('orca.site.audiences.login.after') !!}
    </div>

@endsection
