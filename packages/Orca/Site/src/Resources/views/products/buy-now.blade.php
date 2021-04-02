{!! view_render_event('orca.site.products.buy_now.before', ['product' => $product]) !!}

<button type="submit" data-href="{{ route('Site.product.buynow', $product->product_id)}}" class="btn btn-lg btn-primary buynow" {{ $product->type != 'configurable' && ! $product->haveSufficientQuantity(1) ? 'disabled' : '' }}>
    {{ __('site::app.products.buy-now') }}
</button>

{!! view_render_event('orca.site.products.buy_now.after', ['product' => $product]) !!}