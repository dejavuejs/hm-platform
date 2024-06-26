<?php

namespace Orca\Site\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Product\Repositories\ProductRepository as Product;
use Orca\Product\Repositories\ProductReviewRepository as ProductReview;

/**
 * Review controller
 *
 * @author     <>
 *
 */
class ReviewController extends Controller
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
     * ProductReviewRepository object
     *
     * @var array
     */
    protected $productReview;

    /**
     * Create a new controller instance.
     *
     * @param  \Orca\Product\Repositories\ProductRepository        $product
     * @param  \Orca\Product\Repositories\ProductReviewRepository  $productReview
     * @return void
     */
    public function __construct(Product $product, ProductReview $productReview)
    {
        $this->product = $product;

        $this->productReview = $productReview;

        $this->_config = request('_config');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function create($slug)
    {
        $product = $this->product->findBySlugOrFail($slug);

        $guest_review = core()->getConfigData('catalog.products.review.guest_review');

        return view($this->_config['view'], compact('product', 'guest_review'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id)
    {
        $this->validate(request(), [
            'comment' => 'required',
            'rating'  => 'required|numeric|min:1|max:5',
            'title'   => 'required',
        ]);

        $data = request()->all();

        if (auth()->guard('customer')->user()) {
            $data['customer_id'] = auth()->guard('customer')->user()->id;
            $data['name'] = auth()->guard('customer')->user()->first_name .' ' . auth()->guard('customer')->user()->last_name;
        }

        $data['status'] = 'pending';
        $data['product_id'] = $id;

        $this->productReview->create($data);

        session()->flash('success', trans('site::app.response.submit-success', ['name' => 'Product Review']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Display reviews of particular product.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
    */
    public function show($slug)
    {
        $product = $this->product->findBySlugOrFail($slug);

        return view($this->_config['view'],compact('product'));
    }

    /**
     * Customer delete a reviews from their account
     *
     * @return response
     */
    public function destroy($id)
    {
        $review = $this->productReview->findOneWhere([
            'id' => $id,
            'customer_id' => auth()->guard('customer')->user()->id
        ]);

        if (! $review)
            abort(404);

        $this->productReview->delete($id);

        session()->flash('success', trans('site::app.response.delete-success', ['name' => 'Product Review']));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Customer delete all reviews from their account
     *
     * @return Mixed Response & Boolean
    */
    public function deleteAll() {
        $reviews = auth()->guard('customer')->user()->all_reviews;

        if ($reviews->count() > 0) {
            foreach ($reviews as $review) {
                $this->productReview->delete($review->id);
            }
        }

        session()->flash('success', trans('site::app.reviews.delete-all'));

        return redirect()->route($this->_config['redirect']);
    }
}