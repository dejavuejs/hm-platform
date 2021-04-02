@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.audience.account.order.index.page-title') }}
@endsection

@section('content-wrapper')

    <div class="account-content">
        @include('site::audiences.account.partials.sidemenu')

        <div class="account-layout">

            <div class="account-head mb-10">
                <span class="back-icon"><a href="{{ route('audience.account.index') }}"><i class="icon icon-menu-back"></i></a></span>
                <span class="account-heading">
                    {{ __('site::app.audience.account.order.index.title') }}
                </span>

                <div class="horizontal-rule"></div>
            </div>

            {!! view_render_event('orca.site.audiences.account.orders.list.before', ['orders' => $orders]) !!}

            <div class="account-items-list">
                <div class="account-table-content">
                    @inject('order','Orca\Site\DataGrids\OrderDataGrid')
                    {!! $order->render() !!}
                </div>
            </div>

            {!! view_render_event('orca.site.audiences.account.orders.list.after', ['orders' => $orders]) !!}

        </div>

    </div>

@endsection