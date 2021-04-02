{!! view_render_event('orca.site.products.add_to.before', ['product' => $product]) !!}

<div class="cart-fav-seg">
    @include ('site::products.add-to-cart', ['product' => $product])

    @include('site::products.wishlist')
</div>

{!! view_render_event('orca.site.products.add_to.after', ['product' => $product]) !!}