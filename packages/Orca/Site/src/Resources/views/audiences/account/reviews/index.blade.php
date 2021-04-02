@inject ('productImageHelper', 'Orca\Product\Helpers\ProductImage')

@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.audience.account.review.index.page-title') }}
@endsection

@section('content-wrapper')
    <div class="account-content">
        @include('site::audiences.account.partials.sidemenu')

        <div class="account-layout">

            <div class="account-head">
                <span class="back-icon"><a href="{{ route('audience.account.index') }}"><i class="icon icon-menu-back"></i></a></span>

                <span class="account-heading">{{ __('site::app.audience.account.review.index.title') }}</span>

                @if (count($reviews) > 1)
                    <div class="account-action">
                        <a href="{{ route('audience.review.deleteall') }}">{{ __('site::app.wishlist.deleteall') }}</a>
                    </div>
                @endif

                <span></span>
                <div class="horizontal-rule"></div>
            </div>

            {!! view_render_event('orca.site.audiences.account.reviews.list.before', ['reviews' => $reviews]) !!}

            <div class="account-items-list">
                @if (! $reviews->isEmpty())
                    @foreach ($reviews as $review)
                        <div class="account-item-card mt-15 mb-15">
                            <div class="media-info">
                                <?php $image = $productImageHelper->getProductBaseImage($review->product); ?>

                                <a href="{{ url()->to('/').'/products/'.$review->product->url_key }}" title="{{ $review->product->name }}">
                                    <img class="media" src="{{ $image['small_image_url'] }}"/>
                                </a>

                                <div class="info">
                                    <div class="product-name">
                                        <a href="{{ url()->to('/').'/products/'.$review->product->url_key }}" title="{{ $review->product->name }}">
                                            {{$review->product->name}}
                                        </a>
                                    </div>

                                    <div class="stars mt-10">
                                        @for($i=0 ; $i < $review->rating ; $i++)
                                            <span class="icon star-icon"></span>
                                        @endfor
                                    </div>

                                    <div class="mt-10">
                                        {{ $review->comment }}
                                    </div>
                                </div>
                            </div>

                            <div class="operations">
                                <a class="mb-50" href="{{ route('audience.review.delete', $review->id) }}"><span class="icon trash-icon"></span></a>
                            </div>
                        </div>
                        <div class="horizontal-rule mb-10 mt-10"></div>
                    @endforeach
                @else
                    <div class="empty mt-15">
                        {{ __('audience::app.reviews.empty') }}
                    </div>
                @endif

            </div>

            {!! view_render_event('orca.site.audiences.account.reviews.list.after', ['reviews' => $reviews]) !!}
        </div>
    </div>
@endsection