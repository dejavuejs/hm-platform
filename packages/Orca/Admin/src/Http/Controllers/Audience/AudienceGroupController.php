<?php

namespace Orca\Admin\Http\Controllers\Audience;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Admin\Http\Controllers\Controller;
use Orca\Audience\Repositories\AudienceGroupRepository as AudienceGroup;

/**
 * Audience Group controlller
 *
 * @author     <>
 *
 */
class AudienceGroupController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
    */
    protected $_config;

    /**
     * AudienceGroupRepository object
     *
     * @var array
    */
    protected $audienceGroup;

     /**
     * Create a new controller instance.
     *
     * @param \Orca\Audience\Repositories\AudienceGroupRepository as audienceGroup;
     * @return void
     */
    public function __construct(AudienceGroup $audienceGroup)
    {
        $this->_config = request('_config');

        $this->middleware('admin');

        $this->audienceGroup = $audienceGroup;
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
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'code' => ['required', 'unique:audience_groups,code', new \Orca\Core\Contracts\Validations\Code],
            'name' => 'required',
        ]);

        $data = request()->all();

        $data['is_user_defined'] = 1;

        $this->audienceGroup->create($data);

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Audience Group']));

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
        $group = $this->audienceGroup->findOrFail($id);

        return view($this->_config['view'], compact('group'));
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
            'code' => ['required', 'unique:audience_groups,code,' . $id, new \Orca\Core\Contracts\Validations\Code],
            'name' => 'required',
        ]);

        $this->audienceGroup->update(request()->all(), $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Audience Group']));

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
        $audienceGroup = $this->audienceGroup->findOrFail($id);

        if ($audienceGroup->is_user_defined == 0) {
            session()->flash('warning', trans('admin::app.audiences.audiences.group-default'));
        } else if (count($audienceGroup->audience) > 0) {
            session()->flash('warning', trans('admin::app.response.audience-associate', ['name' => 'Audience Group']));
        } else {
            try {
                $this->audienceGroup->delete($id);

                session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Audience Group']));

                return response()->json(['message' => true], 200);
            } catch(\Exception $e) {
                session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Audience Group']));
            }
        }

        return response()->json(['message' => false], 400);
    }
}