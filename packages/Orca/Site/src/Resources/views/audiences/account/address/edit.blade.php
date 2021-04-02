@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.audience.account.address.edit.page-title') }}
@endsection

@section('content-wrapper')

    <div class="account-content">
        @include('site::audiences.account.partials.sidemenu')

        <div class="account-layout">

            <div class="account-head mb-15">
                <span class="back-icon"><a href="{{ route('audience.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">{{ __('site::app.audience.account.address.edit.title') }}</span>
                <span></span>
            </div>

            {!! view_render_event('orca.site.audiences.account.address.edit.before', ['address' => $address]) !!}

            <form method="post" action="{{ route('audience.address.edit', $address->id) }}" @submit.prevent="onSubmit">

                <div class="account-table-content">
                    @method('PUT')
                    @csrf

                    {!! view_render_event('orca.site.audiences.account.address.edit_form_controls.before', ['address' => $address]) !!}


                    <?php $addresses = explode(PHP_EOL, $address->address1); ?>

                    <div class="control-group" :class="[errors.has('address1[]') ? 'has-error' : '']">
                        <label for="address_0" class="required">{{ __('site::app.audience.account.address.edit.street-address') }}</label>
                        <input type="text" class="control" name="address1[]" id="address_0" v-validate="'required'" value="{{ isset($addresses[0]) ? $addresses[0] : '' }}" data-vv-as="&quot;{{ __('site::app.audience.account.address.create.street-address') }}&quot;">
                        <span class="control-error" v-if="errors.has('address1[]')">@{{ errors.first('address1[]') }}</span>
                    </div>

                    @if (core()->getConfigData('audience.settings.address.street_lines') && core()->getConfigData('audience.settings.address.street_lines') > 1)
                        <div class="control-group" style="margin-top: -25px;">
                            @for ($i = 1; $i < core()->getConfigData('audience.settings.address.street_lines'); $i++)
                                <input type="text" class="control" name="address1[{{ $i }}]" id="address_{{ $i }}" value="{{ isset($addresses[$i]) ? $addresses[$i] : '' }}">
                            @endfor
                        </div>
                    @endif

                    @include ('site::audiences.account.address.country-state', ['countryCode' => old('country') ?? $address->country, 'stateCode' => old('state') ?? $address->state])

                    <div class="control-group" :class="[errors.has('city') ? 'has-error' : '']">
                        <label for="city" class="required">{{ __('site::app.audience.account.address.create.city') }}</label>
                        <input type="text" class="control" name="city" v-validate="'required|alpha_spaces'" value="{{ $address->city }}" data-vv-as="&quot;{{ __('site::app.audience.account.address.create.city') }}&quot;">
                        <span class="control-error" v-if="errors.has('city')">@{{ errors.first('city') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('postcode') ? 'has-error' : '']">
                        <label for="postcode" class="required">{{ __('site::app.audience.account.address.create.postcode') }}</label>
                        <input type="text" class="control" name="postcode" v-validate="'required'" value="{{ $address->postcode }}" data-vv-as="&quot;{{ __('site::app.audience.account.address.create.postcode') }}&quot;">
                        <span class="control-error" v-if="errors.has('postcode')">@{{ errors.first('postcode') }}</span>
                    </div>

                    <div class="control-group" :class="[errors.has('phone') ? 'has-error' : '']">
                        <label for="phone" class="required">{{ __('site::app.audience.account.address.create.phone') }}</label>
                        <input type="text" class="control" name="phone" v-validate="'required'" value="{{ $address->phone }}" data-vv-as="&quot;{{ __('site::app.audience.account.address.create.phone') }}&quot;">
                        <span class="control-error" v-if="errors.has('phone')">@{{ errors.first('phone') }}</span>
                    </div>

                    {!! view_render_event('orca.site.audiences.account.address.edit_form_controls.after', ['address' => $address]) !!}

                    <div class="button-group">
                        <button class="btn btn-primary btn-lg" type="submit">
                            {{ __('site::app.audience.account.address.create.submit') }}
                        </button>
                    </div>
                </div>

            </form>

            {!! view_render_event('orca.site.audiences.account.address.edit.after', ['address' => $address]) !!}

        </div>
    </div>

@endsection