{!! view_render_event('orca.site.products.view.product-add.after', ['product' => $product]) !!}

<div class="add-to-buttons">
    @include ('site::products.add-to-cart', ['product' => $product])

    @include ('site::products.buy-now')
</div>

{!! view_render_event('orca.site.products.view.product-add.after', ['product' => $product]) !!}