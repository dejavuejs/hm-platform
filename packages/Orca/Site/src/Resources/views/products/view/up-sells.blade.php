{!! view_render_event('orca.site.products.view.up-sells.after', ['product' => $product]) !!}

<?php
    $productUpSells = $product->up_sells()->get();
?>

@if ($productUpSells->count())
    <div class="attached-products-wrapper">

        <div class="title">
            {{ __('site::app.products.up-sell-title') }}
            <span class="border-bottom"></span>
        </div>

        <div class="product-grid-4">

            @foreach ($productUpSells as $up_sell_product)

                @include ('site::products.list.card', ['product' => $up_sell_product])

            @endforeach

        </div>

    </div>
@endif

{!! view_render_event('orca.site.products.view.up-sells.after', ['product' => $product]) !!}