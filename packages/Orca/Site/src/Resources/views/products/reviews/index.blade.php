@extends('site::layouts.master')

@section('page_title')
    {{ __('site::app.reviews.product-review-page-title') }} - {{ $product->name }}
@endsection

@section('content-wrapper')

    <section class="review">

        <div class="review-layouter">
            @inject ('productImageHelper', 'Orca\Product\Helpers\ProductImage')
            @inject ('reviewHelper', 'Orca\Product\Helpers\Review')
            @inject ('priceHelper', 'Orca\Product\Helpers\Price')

            <?php $productBaseImage = $productImageHelper->getProductBaseImage($product); ?>

            <div class="product-info">
                <div class="product-image">
                    <a href="{{ route('Site.products.index', $product->url_key) }}" title="{{ $product->name }}">
                        <img src="{{ $productBaseImage['medium_image_url'] }}" />
                    </a>
                </div>

                <div class="product-name mt-20">
                    <a href="{{ url()->to('/').'/products/'.$product->url_key }}" title="{{ $product->name }}">
                        <span>{{ $product->name }}</span>
                    </a>
                </div>

                <div class="product-price mt-10">
                    @inject ('priceHelper', 'Orca\Product\Helpers\Price')
                    @if ($product->type == 'configurable')
                        <span class="pro-price">{{ core()->currency($priceHelper->getMinimalPrice($product)) }}</span>
                    @else
                        @if ($priceHelper->haveSpecialPrice($product))
                            <span class="pro-price">{{ core()->currency($priceHelper->getSpecialPrice($product)) }}</span>
                        @else
                            <span class="pro-price">{{ core()->currency($product->price) }}</span>
                        @endif
                    @endif
                </div>
            </div>

            <div class="review-form">
                <div class="heading mt-10">
                    <span> {{ __('site::app.reviews.rating-reviews') }} </span>

                    @if (core()->getConfigData('catalog.products.review.guest_review') || auth()->guard('audience')->check())
                        <a href="{{ route('Site.reviews.create', $product->url_key) }}" class="btn btn-lg btn-primary right">
                            {{ __('site::app.products.write-review-btn') }}
                        </a>
                    @endif
                </div>

                <div class="ratings-reviews mt-35">
                    <div class="left-side">
                        <span class="rate">
                            {{ $reviewHelper->getAverageRating($product) }}
                        </span>

                        <span class="stars">
                            @for ($i = 1; $i <= $reviewHelper->getAverageRating($product); $i++)

                                <span class="icon star-icon"></span>

                            @endfor
                        </span>

                        <div class="total-reviews mt-5">
                            {{ __('site::app.reviews.ratingreviews', [
                                'rating' => $reviewHelper->getTotalRating($product),
                                'review' => $reviewHelper->getTotalReviews($product)])
                            }}
                        </div>
                    </div>

                    <div class="right-side">

                        @foreach ($reviewHelper->getPercentageRating($product) as $key => $count)
                            <div class="rater 5star">
                                <div class="rate-number" id={{ $key }}{{ __('site::app.reviews.id-star')  }}></div>
                                <div class="star-name">{{ __('site::app.reviews.star') }}</div>
                                <div class="line-bar">
                                    <div class="line-value" id="{{ $key }}"></div>
                                </div>
                                <div class="percentage">
                                    <span>
                                        {{ __('site::app.reviews.percentage', ['percentage' => $count]) }}
                                    </span>
                                </div>
                            </div>
                            <br/>
                        @endforeach

                    </div>
                </div>

                <div class="rating-reviews">
                    <div class="reviews">

                        @foreach ($reviewHelper->getReviews($product)->paginate(10) as $review)
                            <div class="review">
                                <div class="title">
                                    {{ $review->title }}
                                </div>

                                <span class="stars">
                                    @for ($i = 1; $i <= $review->rating; $i++)

                                        <span class="icon star-icon"></span>

                                    @endfor
                                </span>

                                <div class="message">
                                    {{ $review->comment }}
                                </div>

                                <div class="reviewer-details">
                                    <span class="by">
                                        {{ __('site::app.products.by', ['name' => $review->name]) }},
                                    </span>

                                    <span class="when">
                                        {{ core()->formatDate($review->created_at, 'F d, Y') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection

@push('scripts')

    <script>

        window.onload = (function() {
            var percentage = {};
            <?php foreach ($reviewHelper->getPercentageRating($product) as $key => $count) { ?>

                percentage = <?php echo "'$count';"; ?>
                id = <?php echo "'$key';"; ?>
                idNumber = id + 'star';

                document.getElementById(id).style.width = percentage + "%";
                document.getElementById(id).style.height = 4 + "px";
                document.getElementById(idNumber).innerHTML = id ;

            <?php } ?>
        })();

    </script>

@endpush