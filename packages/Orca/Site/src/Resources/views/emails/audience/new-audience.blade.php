@component('site::emails.layouts.master')

    <div>
        <div style="text-align: center;">
            <a href="{{ config('app.url') }}">
                <img src="{{ orca_asset('images/logo.svg') }}">
            </a>
        </div>

        <div  style="font-size:16px; color:#242424; font-weight:600; margin-top: 60px; margin-bottom: 15px">
            Hi {{ $audience['name'] }}, your new account has been created in orca.
            Your account details are below
        </div>

        <div>
            <b>UserName/Email</b> - {{ $audience['email'] }} <br>
            <b>Password</b> - {{ $password}}
        </div>

    </div>

@endcomponent