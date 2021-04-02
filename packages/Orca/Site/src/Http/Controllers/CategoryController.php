<?php

namespace Orca\Site\Http\Controllers;

use Orca\Site\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Category\Repositories\CategoryRepository as Category;
use Orca\Product\Repositories\ProductRepository as Product;

/**
 * Category controller
 *
 * @author    Prashant Singh <>
 *
 */
class CategoryController extends Controller
{

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * CategoryRepository object
     *
     * @var array
     */
    protected $category;

    /**
     * ProductRepository object
     *
     * @var array
     */
    protected $product;

    /**
     * Create a new controller instance.
     *
     * @param  \Orca\Category\Repositories\CategoryRepository $category
     * @param  \Orca\Product\Repositories\ProductRepository $product
     * @return void
     */
    public function __construct(Category $category, Product $product)
    {
        $this->product = $product;

        $this->category = $category;

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
        $category = $this->category->findBySlugOrFail($slug);

        return view($this->_config['view'], compact('category'));
    }
}
