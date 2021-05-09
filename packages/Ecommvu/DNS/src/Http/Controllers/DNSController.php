<?php

namespace Ecommvu\DNS\Http\Controllers;

use Ecommvu\DNS\Http\Controllers\Controller;
use Alphametric\Validation\Rules\Domain;
use Ecommvu\DNS\Models\DNS;
use AppStore;

class DNSController extends Controller
{
    /**
     * Constructor property to inject the dependencies
     */
    public function __construct()
    {
        /**
         * To ensure the guards are well set for app
         */
        dd(AppStore::status());

        $this->_config = request('_config');

        $interfaces = class_implements($admin);

        $this->middleware('auth:admin');
    }

    public function index()
    {
        $dns = new DNS;

        $existing = $dns::where('company_id', \Company::getCurrent()->id)->first();

        return view($this->_config['view'])->with([
            'existing' => $existing
        ]);
            // throw new \Exception('AdminInterface for App store is not implemented');
    }

    public function store()
    {
        $data = request()->all();

        $validator = \Validator::make($data, [
            'channel_id' => 'required|integer',
            'old_domain' => ['required', new Domain],
            'new_domain' => ['required', new Domain],
            'step_1' => 'required|accepted'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => 'false',
                'errors'  => $validator->errors(),
            ], 400);
        }

        $dns = new DNS;

        $newDomain = request()->input('new_domain');

        if (\str_contains($newDomain, 'https://')) {
            $newDomain = explode('https://', $newDomain)[1];
        } else if (\str_contains($newDomain, 'http://')) {
            $newDomain = explode('http://', $newDomain)[1];
        }

        $data['new_domain'] = $newDomain;

        $uniqueNewDomain = \Validator::make($data, [
            'new_domain' => 'required|unique:companies,domain'
        ]);

        $isNewDomainIP = \Validator::make($data, [
            'new_domain' => 'required|ip'
        ]);

        if (! $isNewDomainIP->fails() || $uniqueNewDomain->fails()) {
            return response()->json([
                'success' => false,
                'type' => 'error',
                'message' => 'Error! Validation',
                'errors' => [
                    'ip_or_unique' => ['Either IP address entered or Domain entered is already having assigned to a shop']
                ]
            ], 400);
        }

        $existing = $dns::where('company_id', \Company::getCurrent()->id)->get();

        if ($existing->count()) {
            $existing = $existing->first();

            if ($newDomain !== $existing->current) {
                $result = $existing->first()->update([
                    'old' => $existing->current,
                    'current' => $newDomain
                ]);

                $company = \Company::getCurrent();

                $company->update([
                    'domain' => $newDomain
                ]);

                auth()->guard('admin')->logout();
            } else {
                $result = false;
            }
        } else {
            $dns->company_id = \Company::getCurrent()->id;
            $dns->channel_id = request()->input('channel_id');
            $dns->base = \Company::getCurrent()->username . '.bryg.test';
            $dns->current = $newDomain;
            $dns->status = 1;
            $dns->old = request()->input('old_domain');

            $result = $dns->save();

            if ($result) {
                $company = \Company::getCurrent();

                $company->update([
                    'domain' => $newDomain
                ]);

                $channel = app('Webkul\Core\Repositories\ChannelRepository')->findOneWhere([
                    'company_id' => \Company::getCurrent()->id
                ]);

                $channel->update([
                    'hostname' => $newDomain
                ]);
            }
        }

        if (! $result) {
            return response()->json([
                'success' => false,
                'type' => 'error',
                'message' => 'Cannot create a new custom domain request'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'type' => 'success',
            'message' => 'You request have succeeded, kindly open a new tab and hit new url'
        ], 200);
    }
}