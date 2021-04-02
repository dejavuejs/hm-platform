@auth('audience')
    {!! view_render_event('orca.site.products.wishlist.before') !!}

    <a class="add-to-wishlist" href="{{ route('audience.wishlist.add', $product->product_id) }}" id="wishlist-changer">
        <span class="icon wishlist-icon"></span>
    </a>

    {!! view_render_event('orca.site.products.wishlist.after') !!}
@endauth
