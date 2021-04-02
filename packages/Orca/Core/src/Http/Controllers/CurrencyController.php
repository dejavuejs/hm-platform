<?php

namespace Orca\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Event;
use Orca\Core\Repositories\CurrencyRepository as Currency;

/**
 * Currency controller
 *
 * @author     <>
 *
 */
class CurrencyController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * CurrencyRepository object
     *
     * @var array
     */
    protected $currency;

    /**
     * Create a new controller instance.
     *
     * @param  \Orca\Core\Repositories\CurrencyRepository $currency
     * @return void
     */
    public function __construct(Currency $currency)
    {
        $this->currency = $currency;

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->_config['view']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'code' => 'required|min:3|max:3|unique:currencies,code',
            'name' => 'required'
        ]);

        Event::dispatch('core.channel.create.before');

        $currency = $this->currency->create(request()->all());

        Event::dispatch('core.currency.create.after', $currency);

        session()->flash('success', trans('admin::app.settings.currencies.create-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currency = $this->currency->findOrFail($id);

        return view($this->_config['view'], compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'code' => ['required', 'unique:currencies,code,' . $id, new \Orca\Core\Contracts\Validations\Code],
            'name' => 'required'
        ]);

        Event::dispatch('core.currency.update.before', $id);

        $currency = $this->currency->update(request()->all(), $id);

        Event::dispatch('core.currency.update.after', $currency);

        session()->flash('success', trans('admin::app.settings.currencies.update-success'));

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency = $this->currency->findOrFail($id);

        if ($this->currency->count() == 1) {
            session()->flash('warning', trans('admin::app.settings.currencies.last-delete-error'));
        } else {
            try {
                Event::dispatch('core.currency.delete.before', $id);

                $this->currency->delete($id);

                Event::dispatch('core.currency.delete.after', $id);

                session()->flash('success', trans('admin::app.settings.currencies.delete-success'));

                return response()->json(['message' => true], 200);
            } catch (\Exception $e) {
                session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Currency']));
            }
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * Remove the specified resources from database
     *
     * @return response \Illuminate\Http\Response
     */
    public function massDestroy() {
        $suppressFlash = false;

        if (request()->isMethod('post')) {
            $indexes = explode(',', request()->input('indexes'));

            foreach ($indexes as $key => $value) {
                try {
                    Event::dispatch('core.currency.delete.before', $value);

                    $this->currency->delete($value);

                    Event::dispatch('core.currency.delete.after', $value);
                } catch(\Exception $e) {
                    $suppressFlash = true;

                    continue;
                }
            }

            if (! $suppressFlash)
                session()->flash('success', trans('admin::app.datagrid.mass-ops.delete-success', ['resource' => 'currencies']));
            else
                session()->flash('info', trans('admin::app.datagrid.mass-ops.partial-action', ['resource' => 'currencies']));

            return redirect()->back();
        } else {
            session()->flash('error', trans('admin::app.datagrid.mass-ops.method-error'));

            return redirect()->back();
        }
    }
}