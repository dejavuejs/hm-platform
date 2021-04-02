{!! view_render_event('orca.site.products.view.stock.before', ['product' => $product]) !!}

@if ($product->type == 'simple')
    <div class="stock-status {{! $product->haveSufficientQuantity(1) ? '' : 'active' }}">
        {{ $product->haveSufficientQuantity(1) ? __('site::app.products.in-stock') : __('site::app.products.out-of-stock') }}
    </div>
@else
    <div class="stock-status in-stock active" id="in-stock" style="display: none;">
        {{ __('site::app.products.in-stock') }}
    </div>
@endif

{!! view_render_event('orca.site.products.view.stock.after', ['product' => $product]) !!}