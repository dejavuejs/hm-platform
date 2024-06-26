@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.customer.account.profile.index.title') }}
@endsection

@section('content-wrapper')

<div class="account-content">

    @include('site::customers.account.partials.sidemenu')

    <div class="account-layout">

        <div class="account-head">

            <span class="back-icon"><a href="{{ route('customer.account.index') }}"><i class="icon icon-menu-back"></i></a></span>

            <span class="account-heading">{{ __('site::app.customer.account.profile.index.title') }}</span>

            <span class="account-action">
                <a href="{{ route('customer.profile.edit') }}">{{ __('site::app.customer.account.profile.index.edit') }}</a>
            </span>

            <div class="horizontal-rule"></div>
        </div>

         {!! view_render_event('orca.site.customers.account.profile.view.before', ['customer' => $customer]) !!}

        <div class="account-table-content" style="width: 50%;">
            <table style="color: #5E5E5E;">
                <tbody>
                    <tr>
                        <td>{{ __('site::app.customer.account.profile.fname') }}</td>
                        <td>{{ $customer->first_name }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('site::app.customer.account.profile.lname') }}</td>
                        <td>{{ $customer->last_name }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('site::app.customer.account.profile.gender') }}</td>
                        <td>{{ $customer->gender }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('site::app.customer.account.profile.dob') }}</td>
                        <td>{{ $customer->date_of_birth }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('site::app.customer.account.profile.email') }}</td>
                        <td>{{ $customer->email }}</td>
                    </tr>

                    {{-- @if ($customer->subscribed_to_news_letter == 1)
                        <tr>
                            <td> {{ __('site::app.footer.subscribe-newsletter') }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('Site.unsubscribe', $customer->email) }}">{{ __('site::app.subscription.unsubscribe') }} </a>
                            </td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
        </div>

         {!! view_render_event('orca.site.customers.account.profile.view.after', ['customer' => $customer]) !!}
    </div>
</div>
@endsection
