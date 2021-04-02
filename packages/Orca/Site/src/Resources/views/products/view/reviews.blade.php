@inject ('reviewHelper', 'Orca\Product\Helpers\Review')

{!! view_render_event('orca.site.products.view.reviews.after', ['product' => $product]) !!}

@if ($total = $reviewHelper->getTotalReviews($product))
    <div class="rating-reviews">
        <div class="rating-header">
            {{ __('site::app.products.reviews-title') }}
        </div>

        <div class="overall">
            <div class="review-info">

                <span class="number">
                    {{ $reviewHelper->getAverageRating($product) }}
                </span>

                <span class="stars">
                    @for ($i = 1; $i <= round($reviewHelper->getAverageRating($product)); $i++)

                        <span class="icon star-icon"></span>

                    @endfor
                </span>

                <div class="total-reviews">
                    {{ __('site::app.products.total-reviews', ['total' => $total]) }}
                </div>

            </div>

            @if (core()->getConfigData('catalog.products.review.guest_review') || auth()->guard('audience')->check())
                <a href="{{ route('Site.reviews.create', $product->url_key) }}" class="btn btn-lg btn-primary">
                    {{ __('site::app.products.write-review-btn') }}
                </a>
            @endif

        </div>

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

            <a href="{{ route('Site.reviews.index', $product->url_key) }}" class="view-all">
                {{ __('site::app.products.view-all') }}
            </a>

        </div>
    </div>
@else
    @if (core()->getConfigData('catalog.products.review.guest_review') || auth()->guard('audience')->check())
        <div class="rating-reviews">
            <div class="rating-header">
                <a href="{{ route('Site.reviews.create', $product->url_key) }}" class="btn btn-lg btn-primary">
                    {{ __('site::app.products.write-review-btn') }}
                </a>
            </div>
        </div>
    @endif
@endif

{!! view_render_event('orca.site.products.view.reviews.after', ['product' => $product]) !!}