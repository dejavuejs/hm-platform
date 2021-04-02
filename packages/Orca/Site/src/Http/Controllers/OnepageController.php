<?php

namespace Orca\Site\Http\Controllers;

use Orca\Site\Http\Controllers\Controller;
use Orca\Checkout\Facades\Cart;
use Orca\Shipping\Facades\Shipping;
use Orca\Payment\Facades\Payment;
use Orca\Checkout\Http\Requests\AudienceAddressForm;
use Orca\Sales\Repositories\OrderRepository;
use Orca\Discount\Helpers\Cart\CouponAbleRule as Coupon;
use Orca\Discount\Helpers\Cart\NonCouponAbleRule as NonCoupon;
use Orca\Discount\Helpers\Cart\ValidatesDiscount;

/**
 * Chekout controller for the audience and guest for placing order
 *
 * @author   <>
 * @author  Prashant Singh <>
 *
 */
class OnepageController extends Controller
{
    /**
     * OrderRepository object
     *
     * @var array
     */
    protected $orderRepository;

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * CouponAbleRule instance object
     *
     */
    protected $coupon;

    /**
     * NoncouponAbleRule instance object
     *
     */
    protected $nonCoupon;

    /**
     * ValidatesDiscount instance object
     */
    protected $validatesDiscount;

    /**
     * Create a new controller instance.
     *
     * @param  \Orca\Attribute\Repositories\OrderRepository  $orderRepository
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        Coupon $coupon,
        NonCoupon $nonCoupon,
        ValidatesDiscount $validatesDiscount
    )
    {
        $this->coupon = $coupon;

        $this->nonCoupon = $nonCoupon;

        $this->orderRepository = $orderRepository;

        $this->validatesDiscount = $validatesDiscount;

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if (Cart::hasError())
            return redirect()->route('Site.checkout.cart.index');

        // $this->nonCoupon->apply();
        $this->nonCoupon->apply();

        Cart::collectTotals();

        return view($this->_config['view'])->with('cart', Cart::getCart());
    }

    /**
     * Return order short summary
     *
     * @return \Illuminate\Http\Response
    */
    public function summary()
    {
        $cart = Cart::getCart();

        return response()->json([
                'html' => view('site::checkout.total.summary', compact('cart'))->render()
            ]);
    }

    /**
     * Saves audience address.
     *
     * @param  \Orca\Checkout\Http\Requests\AudienceAddressForm $request
     * @return \Illuminate\Http\Response
    */
    public function saveAddress(AudienceAddressForm $request)
    {
        $data = request()->all();

        $data['billing']['address1'] = implode(PHP_EOL, array_filter($data['billing']['address1']));
        $data['shipping']['address1'] = implode(PHP_EOL, array_filter($data['shipping']['address1']));

        if (Cart::hasError() || !Cart::saveAudienceAddress($data) || ! $rates = Shipping::collectRates())
            return response()->json(['redirect_url' => route('Site.checkout.cart.index')], 403);

        $this->nonCoupon->apply();

        Cart::collectTotals();

        return response()->json($rates);
    }

    /**
     * Saves shipping method.
     *
     * @return \Illuminate\Http\Response
    */
    public function saveShipping()
    {
        $shippingMethod = request()->get('shipping_method');

        if (Cart::hasError() || !$shippingMethod || !Cart::saveShippingMethod($shippingMethod))
            return response()->json(['redirect_url' => route('Site.checkout.cart.index')], 403);

        $this->nonCoupon->apply();

        Cart::collectTotals();

        return response()->json(Payment::getSupportedPaymentMethods());
    }

    /**
     * Saves payment method.
     *
     * @return \Illuminate\Http\Response
    */
    public function savePayment()
    {
        $payment = request()->get('payment');

        if (Cart::hasError() || !$payment || !Cart::savePaymentMethod($payment))
            return response()->json(['redirect_url' => route('Site.checkout.cart.index')], 403);

        $this->nonCoupon->apply();

        Cart::collectTotals();

        $cart = Cart::getCart();

        return response()->json([
            'jump_to_section' => 'review',
            'html' => view('site::checkout.onepage.review', compact('cart'))->render()
        ]);
    }

    /**
     * Saves order.
     *
     * @return \Illuminate\Http\Response
    */
    public function saveOrder()
    {
        if (Cart::hasError())
            return response()->json(['redirect_url' => route('Site.checkout.cart.index')], 403);

        Cart::collectTotals();

        $this->validateOrder();

        $cart = Cart::getCart();

        if ($redirectUrl = Payment::getRedirectUrl($cart)) {
            return response()->json([
                'success' => true,
                'redirect_url' => $redirectUrl
            ]);
        }

        $order = $this->orderRepository->create(Cart::prepareDataForOrder());

        Cart::deActivateCart();

        session()->flash('order', $order);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Order success page
     *
     * @return \Illuminate\Http\Response
    */
    public function success()
    {
        if (! $order = session('order'))
            return redirect()->route('Site.checkout.cart.index');

        return view($this->_config['view'], compact('order'));
    }

    /**
     * Validate order before creation
     *
     * @return mixed
     */
    public function validateOrder()
    {
        $cart = Cart::getCart();

        $this->validatesDiscount->validate();

        if (! $cart->shipping_address) {
            throw new \Exception(trans('Please check shipping address.'));
        }

        if (! $cart->billing_address) {
            throw new \Exception(trans('Please check billing address.'));
        }

        if (! $cart->selected_shipping_rate) {
            throw new \Exception(trans('Please specify shipping method.'));
        }

        if (! $cart->payment) {
            throw new \Exception(trans('Please specify payment method.'));
        }
    }

    /**
     * To apply couponable rule requested
     *
     * @return JSON
     */
    public function applyCoupon()
    {
        $this->validate(request(), [
            'code' => 'string|required'
        ]);

        $code = request()->input('code');

        $result = $this->coupon->apply($code);

        if ($result) {
            Cart::collectTotals();

            return response()->json([
                'success' => true,
                'message' => trans('site::app.checkout.total.coupon-applied'),
                'result' => $result
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('site::app.checkout.total.cannot-apply-coupon'),
                'result' => null
            ], 422);
        }

        return $result;
    }

    /**
     * Initiates the removal of couponable cart rule
     *
     * @return Void
     */
    public function removeCoupon()
    {
        $result = $this->coupon->remove();

        if ($result) {
            Cart::collectTotals();

            return response()->json([
                    'success' => true,
                    'message' => trans('admin::app.promotion.status.coupon-removed'),
                    'data' => [
                        'grand_total' => core()->currency(Cart::getCart()->grand_total)
                    ]
                ], 200);
        } else {
            return response()->json([
                    'success' => false,
                    'message' => trans('admin::app.promotion.status.coupon-remove-failed'),
                    'data' => null
                ], 422);
        }
    }
}