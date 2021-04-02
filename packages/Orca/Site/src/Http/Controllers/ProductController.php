<?php

namespace Orca\Site\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Product\Repositories\ProductRepository as Product;
use Orca\Product\Repositories\ProductAttributeValueRepository as ProductAttributeValue;
use Illuminate\Support\Facades\Storage;

/**
 * Product controller
 *
 * @author     <>
 *
 */
class ProductController extends Controller
{

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * ProductRepository object
     *
     * @var array
     */
    protected $product;

    /**
     * ProductAttributeValueRepository object
     *
     * @var array
     */
    protected $productAttributeValue;

    /**
     * Create a new controller instance.
     *
     * @param  \Orca\Product\Repositories\ProductRepository      $product
     * @param  \Orca\Product\Repositories\ProductAttributeValue  $productAttributeValue
     * @return void
     */
    public function __construct(Product $product, ProductAttributeValue $productAttributeValue)
    {
        $this->product = $product;

        $this->productAttributeValue = $productAttributeValue;

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $product = $this->product->findBySlugOrFail($slug);

        $audience = auth()->guard('audience')->user();

        return view($this->_config['view'], compact('product','audience'));
    }

    /**
     * Download image or file
     *
     * @param  int $productId, $attributeId
     * @return \Illuminate\Http\Response
     */
    public function download($productId, $attributeId)
    {
        $productAttribute = $this->productAttributeValue->findOneWhere([
            'product_id'   => $productId,
            'attribute_id' => $attributeId
        ]);

        return Storage::download($productAttribute['text_value']);
    }
}
