@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.audience.account.profile.index.title') }}
@endsection

@section('content-wrapper')

<div class="account-content">

    @include('site::audiences.account.partials.sidemenu')

    <div class="account-layout">

        <div class="account-head">

            <span class="back-icon"><a href="{{ route('audience.account.index') }}"><i class="icon icon-menu-back"></i></a></span>

            <span class="account-heading">{{ __('site::app.audience.account.profile.index.title') }}</span>

            <span class="account-action">
                <a href="{{ route('audience.profile.edit') }}">{{ __('site::app.audience.account.profile.index.edit') }}</a>
            </span>

            <div class="horizontal-rule"></div>
        </div>

         {!! view_render_event('orca.site.audiences.account.profile.view.before', ['audience' => $audience]) !!}

        <div class="account-table-content" style="width: 50%;">
            <table style="color: #5E5E5E;">
                <tbody>
                    <tr>
                        <td>{{ __('site::app.audience.account.profile.fname') }}</td>
                        <td>{{ $audience->first_name }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('site::app.audience.account.profile.lname') }}</td>
                        <td>{{ $audience->last_name }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('site::app.audience.account.profile.gender') }}</td>
                        <td>{{ $audience->gender }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('site::app.audience.account.profile.dob') }}</td>
                        <td>{{ $audience->date_of_birth }}</td>
                    </tr>

                    <tr>
                        <td>{{ __('site::app.audience.account.profile.email') }}</td>
                        <td>{{ $audience->email }}</td>
                    </tr>

                    {{-- @if ($audience->subscribed_to_news_letter == 1)
                        <tr>
                            <td> {{ __('site::app.footer.subscribe-newsletter') }}</td>
                            <td>
                                <a class="btn btn-sm btn-primary" href="{{ route('Site.unsubscribe', $audience->email) }}">{{ __('site::app.subscription.unsubscribe') }} </a>
                            </td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
        </div>

         {!! view_render_event('orca.site.audiences.account.profile.view.after', ['audience' => $audience]) !!}
    </div>
</div>
@endsection
