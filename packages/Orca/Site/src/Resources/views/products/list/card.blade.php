{!! view_render_event('orca.site.products.list.card.before', ['product' => $product]) !!}

<div class="product-card">

    @inject ('productImageHelper', 'Orca\Product\Helpers\ProductImage')

    <?php $productBaseImage = $productImageHelper->getProductBaseImage($product); ?>

    @if ($product->new)
        <div class="sticker new">
            {{ __('site::app.products.new') }}
        </div>
    @endif

    <div class="product-image">
        <a href="{{ route('Site.products.index', $product->url_key) }}" title="{{ $product->name }}">
            <img src="{{ $productBaseImage['medium_image_url'] }}" onerror="this.src='{{ asset('vendor/orca/ui/assets/images/product/meduim-product-placeholder.png') }}'"/>
        </a>
    </div>

    <div class="product-information">

        <div class="product-name">
            <a href="{{ url()->to('/').'/products/' . $product->url_key }}" title="{{ $product->name }}">
                <span>
                    {{ $product->name }}
                </span>
            </a>
        </div>

        @include ('site::products.price', ['product' => $product])

        @include('site::products.add-buttons', ['product' => $product])
    </div>

</div>

{!! view_render_event('orca.site.products.list.card.after', ['product' => $product]) !!}