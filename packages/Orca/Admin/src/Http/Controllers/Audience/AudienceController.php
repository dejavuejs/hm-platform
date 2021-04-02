<?php

namespace Orca\Admin\Http\Controllers\Audience;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orca\Admin\Http\Controllers\Controller;
use Orca\Audience\Repositories\AudienceRepository as Audience;
use Orca\Audience\Repositories\AudienceGroupRepository as AudienceGroup;
use Orca\Core\Repositories\ChannelRepository as Channel;
use Orca\Admin\Mail\NewAudienceNotification;
use Mail;

/**
 * Audience controlller
 *
 * @author     <>
 *
 */
class AudienceController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * AudienceRepository object
     *
     * @var array
     */
    protected $audience;

     /**
     * AudienceGroupRepository object
     *
     * @var array
     */
    protected $audienceGroup;

     /**
     * ChannelRepository object
     *
     * @var array
     */
    protected $channel;

    /**
     * Create a new controller instance.
     *
     * @param \Orca\Audience\Repositories\AudienceRepository $audience
     * @param \Orca\Audience\Repositories\AudienceGroupRepository $audienceGroup
     * @param \Orca\Core\Repositories\ChannelRepository $channel
     */
    public function __construct(Audience $audience, AudienceGroup $audienceGroup, Channel $channel)
    {
        $this->_config = request('_config');

        $this->middleware('admin');

        $this->audience = $audience;

        $this->audienceGroup = $audienceGroup;

        $this->channel = $channel;

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
        $audienceGroup = $this->audienceGroup->findWhere([['code', '<>', 'guest']]);

        $channelName = $this->channel->all();

        return view($this->_config['view'], compact('audienceGroup', 'channelName'));
    }

     /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(), [
            'channel_id' => 'required',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'gender' => 'required',
            'email' => 'required|unique:audiences,email',
            'date_of_birth' => 'date|before:today'
        ]);

        $data = request()->all();

        $password = rand(100000,10000000);

        $data['password'] = bcrypt($password);

        $data['is_verified'] = 1;

        $audience = $this->audience->create($data);

        Mail::queue(new NewAudienceNotification($audience, $password));

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Audience']));

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
        $audience = $this->audience->findOrFail($id);

        $audienceGroup = $this->audienceGroup->findWhere([['code', '<>', 'guest']]);

        $channelName = $this->channel->all();

        return view($this->_config['view'], compact('audience', 'audienceGroup', 'channelName'));
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
            'channel_id' => 'required',
            'first_name' => 'string|required',
            'last_name' => 'string|required',
            'gender' => 'required',
            'email' => 'required|unique:audiences,email,'. $id,
            'date_of_birth' => 'date|before:today'
        ]);

        $this->audience->update(request()->all(), $id);

        session()->flash('success', trans('admin::app.response.update-success', ['name' => 'Audience']));

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
        $audience = $this->audience->findorFail($id);

        try {
            $this->audience->delete($id);

            session()->flash('success', trans('admin::app.response.delete-success', ['name' => 'Audience']));

            return response()->json(['message' => true], 200);
        } catch(\Exception $e) {
            session()->flash('error', trans('admin::app.response.delete-failed', ['name' => 'Audience']));
        }

        return response()->json(['message' => false], 400);
    }

    /**
     * To load the note taking screen for the audiences
     *
     * @return view
     */
    public function createNote($id)
    {
        $audience = $this->audience->find($id);

        return view($this->_config['view'])->with('audience', $audience);
    }

    /**
     * To store the response of the note in storage
     *
     * @return redirect
     */
    public function storeNote()
    {
        $this->validate(request(), [
            'notes' => 'string|nullable'
        ]);

        $audience = $this->audience->find(request()->input('_audience'));

        $noteTaken = $audience->update([
            'notes' => request()->input('notes')
        ]);

        if ($noteTaken) {
            session()->flash('success', 'Note taken');
        } else {
            session()->flash('error', 'Note cannot be taken');
        }

        return redirect()->route($this->_config['redirect']);
    }

    /**
     * To mass update the audience
     *
     * @return redirect
     */
    public function massUpdate()
    {
        $audienceIds = explode(',', request()->input('indexes'));
        $updateOption = request()->input('update-options');

        foreach ($audienceIds as $audienceId) {
            $audience = $this->audience->find($audienceId);

            $audience->update([
                'status' => $updateOption
            ]);
        }

        session()->flash('success', trans('admin::app.audiences.audiences.mass-update-success'));

        return redirect()->back();
    }

    /**
     * To mass delete the audience
     *
     * @return redirect
     */
    public function massDestroy()
    {
        $audienceIds = explode(',', request()->input('indexes'));

        foreach ($audienceIds as $audienceId) {
            $this->audience->deleteWhere([
                'id' => $audienceId
            ]);
        }

        session()->flash('success', trans('admin::app.audiences.audiences.mass-destroy-success'));

        return redirect()->back();
    }
}