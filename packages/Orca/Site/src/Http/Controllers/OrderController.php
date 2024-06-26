<?php

namespace Orca\Site\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Sales\Repositories\OrderRepository;
use Orca\Sales\Repositories\InvoiceRepository;
use Auth;
use PDF;

/**
 * Customer controlller for the customer basically for the tasks of customers
 * which will be done after customer authenticastion.
 *
 * @author    Prashant Singh <>
 *
 */
class OrderController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * OrderrRepository object
     *
     * @var array
     */
    protected $order;

    /**
     * InvoiceRepository object
     *
     * @var array
     */
    protected $invoice;

    /**
     * Create a new controller instance.
     *
     * @param  \Orca\Order\Repositories\OrderRepository   $order
     * @param  \Orca\Order\Repositories\InvoiceRepository $invoice
     * @return void
     */
    public function __construct(
        OrderRepository $order,
        InvoiceRepository $invoice
    )
    {
        $this->middleware('customer');

        $this->_config = request('_config');

        $this->order = $order;

        $this->invoice = $invoice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $orders = $this->order->findWhere([
            'customer_id' => auth()->guard('customer')->user()->id
        ]);

        return view($this->_config['view'], compact('orders'));
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $order = $this->order->findOneWhere([
            'customer_id' => auth()->guard('customer')->user()->id,
            'id' => $id
        ]);

        if (! $order)
            abort(404);

        return view($this->_config['view'], compact('order'));
    }

    /**
     * Print and download the for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $invoice = $this->invoice->findOrFail($id);

        $pdf = PDF::loadView('site::customers.account.orders.pdf', compact('invoice'))->setPaper('a4');

        return $pdf->download('invoice-' . $invoice->created_at->format('d-m-Y') . '.pdf');
    }
}