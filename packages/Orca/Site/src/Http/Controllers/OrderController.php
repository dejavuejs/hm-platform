<?php

namespace Orca\Site\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Sales\Repositories\OrderRepository;
use Orca\Sales\Repositories\InvoiceRepository;
use Auth;
use PDF;

/**
 * Audience controlller for the audience basically for the tasks of audiences
 * which will be done after audience authenticastion.
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
        $this->middleware('audience');

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
            'audience_id' => auth()->guard('audience')->user()->id
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
            'audience_id' => auth()->guard('audience')->user()->id,
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

        $pdf = PDF::loadView('site::audiences.account.orders.pdf', compact('invoice'))->setPaper('a4');

        return $pdf->download('invoice-' . $invoice->created_at->format('d-m-Y') . '.pdf');
    }
}