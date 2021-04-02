@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.audience.account.profile.edit-profile.page-title') }}
@endsection

@section('content-wrapper')
    <div class="account-content">

        @include('site::audiences.account.partials.sidemenu')

        <div class="account-layout">

            <div class="account-head mb-10">
                <span class="back-icon"><a href="{{ route('audience.account.index') }}"><i class="icon icon-menu-back"></i></a></span>

                <span class="account-heading">{{ __('site::app.audience.account.profile.edit-profile.title') }}</span>

                <span></span>
            </div>

            {!! view_render_event('orca.site.audiences.account.profile.edit.before', ['audience' => $audience]) !!}

            <form method="post" action="{{ route('audience.profile.edit') }}" @submit.prevent="onSubmit">

                <div class="edit-form">
                    @csrf

                    {!! view_render_event('orca.site.audiences.account.profile.edit_form_controls.before', ['audience' => $audience]) !!}

                    <div class="control-group" :class="[errors.has('first_name') ? 'has-error' : '']">
                        <label for="first_name" class="required">{{ __('site::app.audience.account.profile.fname') }}</label>

                        <input type="text" class="control" name="first_name" value="{{ old('first_name') ?? $audience->first_name }}" v-validate="'required'" data-vv-as="&quot;{{ __('site::app.audience.account.profile.fname') }}&quot;">
                        <span class="control-error" v-if="errors.has('first_name')">@{{ errors.first('first_name') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('last_name') ? 'has-error' : '']">
                        <label for="last_name" class="required">{{ __('site::app.audience.account.profile.lname') }}</label>

                        <input type="text" class="control" name="last_name" value="{{ old('last_name') ?? $audience->last_name }}" v-validate="'required'" data-vv-as="&quot;{{ __('site::app.audience.account.profile.lname') }}&quot;">
                        <span class="control-error" v-if="errors.has('last_name')">@{{ errors.first('last_name') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('gender') ? 'has-error' : '']">
                        <label for="email" class="required">{{ __('site::app.audience.account.profile.gender') }}</label>

                        <select name="gender" class="control" v-validate="'required'" data-vv-as="&quot;{{ __('site::app.audience.account.profile.gender') }}&quot;">
                            <option value=""  @if ($audience->gender == "") selected @endif></option>
                            <option value="Other"  @if ($audience->gender == "Other") selected @endif>Other</option>
                            <option value="Male"  @if ($audience->gender == "Male") selected @endif>Male</option>
                            <option value="Female" @if ($audience->gender == "Female") selected @endif>Female</option>
                        </select>
                        <span class="control-error" v-if="errors.has('gender')">@{{ errors.first('gender') }}</span>
                    </div>

                    <div class="control-group"  :class="[errors.has('date_of_birth') ? 'has-error' : '']">
                        <label for="date_of_birth">{{ __('site::app.audience.account.profile.dob') }}</label>
                        <input type="date" class="control" name="date_of_birth" value="{{ old('date_of_birth') ?? $audience->date_of_birth }}" v-validate="" data-vv-as="&quot;{{ __('site::app.audience.account.profile.dob') }}&quot;">
                        <span class="control-error" v-if="errors.has('date_of_birth')">@{{ errors.first('date_of_birth') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('email') ? 'has-error' : '']">
                        <label for="email" class="required">{{ __('site::app.audience.account.profile.email') }}</label>
                        <input type="email" class="control" name="email" value="{{ old('email') ?? $audience->email }}" v-validate="'required'" data-vv-as="&quot;{{ __('site::app.audience.account.profile.email') }}&quot;">
                        <span class="control-error" v-if="errors.has('email')">@{{ errors.first('email') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('oldpassword') ? 'has-error' : '']">
                        <label for="password">{{ __('site::app.audience.account.profile.opassword') }}</label>
                        <input type="password" class="control" name="oldpassword" data-vv-as="&quot;{{ __('site::app.audience.account.profile.opassword') }}&quot;" v-validate="'min:6'">
                        <span class="control-error" v-if="errors.has('oldpassword')">@{{ errors.first('oldpassword') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('password') ? 'has-error' : '']">
                        <label for="password">{{ __('site::app.audience.account.profile.password') }}</label>

                        <input type="password" id="password" class="control" name="password" data-vv-as="&quot;{{ __('site::app.audience.account.profile.password') }}&quot;" v-validate="'min:6'">
                        <span class="control-error" v-if="errors.has('password')">@{{ errors.first('password') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('password_confirmation') ? 'has-error' : '']">
                        <label for="password">{{ __('site::app.audience.account.profile.cpassword') }}</label>

                        <input type="password" id="password_confirmation" class="control" name="password_confirmation" data-vv-as="&quot;{{ __('site::app.audience.account.profile.cpassword') }}&quot;" v-validate="'min:6|confirmed:password'">
                        <span class="control-error" v-if="errors.has('password_confirmation')">@{{ errors.first('password_confirmation') }}</span>
                    </div>

                    {!! view_render_event('orca.site.audiences.account.profile.edit_form_controls.after', ['audience' => $audience]) !!}

                    <div class="button-group">
                        <input class="btn btn-primary btn-lg" type="submit" value="{{ __('site::app.audience.account.profile.submit') }}">
                    </div>
                </div>

            </form>

            {!! view_render_event('orca.site.audiences.account.profile.edit.after', ['audience' => $audience]) !!}

        </div>

    </div>
@endsection
