@inject ('productImageHelper', 'Orca\Product\Helpers\ProductImage')

@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.audience.account.review.view.page-title') }}
@endsection

@section('content-wrapper')
    <div class="account-content">
        @include('site::audiences.account.partials.sidemenu')

        <div class="account-layout">
            <div class="account-head">
                <span class="account-heading">Reviews</span>
                <div class="horizontal-rule"></div>
            </div>

            <div class="account-items-list">
                @if (count($reviews))
                    @foreach ($reviews as $review)
                    <div class="account-item-card mt-15 mb-15">
                        <div class="media-info">
                            <?php $image = $productImageHelper->getGalleryImages($review->product); ?>
                            <img class="media" src="{{ $image[0]['small_image_url'] }}" />

                            <div class="info mt-20">
                                <div class="product-name">{{$review->product->name}}</div>

                                <div>
                                    @for($i=0;$i<$review->rating;$i++)
                                        <span class="icon star-icon"></span>
                                    @endfor
                                </div>

                                <div>
                                    {{ $review->comment }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="horizontal-rule mb-10 mt-10"></div>
                    @endforeach
                @else
                    <div class="empty">
                        {{ __('audience::app.reviews.empty') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection