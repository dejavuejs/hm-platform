<?php

namespace Ecommvu\DNS\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Ecommvu\DNS\Models\DNS;
use Throwable;

class DeactivationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Holds the instance of Buckets model
     *
     * @var Ecommvu\DNS\Models\DNS $bucket
     */
    public $deactivation;

    /**
     * Initiate default tries with this script
     *
     * @var integer
     */
    public $tries = 1;

    /**
     * Constructor property to inject dependencies
     *
     * @param \Ecommvu\DNS\Models\DNS $dns
     * @param Array $deactivation
     */
    public function __construct($dns, $deactivation)
    {
        $this->deactivation = $deactivation;
    }

    public function handle()
    {
        // Activate the module.

        // 1. Authentication script
        if (auth()->guard('admin')->check()) {
            $admin = app('Webkul\SAAS\Models\User\Admin')->where([
                'email' => \Company::getCurrent()->email
            ])->first();

            // if (isset($))
        }


        // 2. Enablement script

        return true;
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $error = 'message =>' . $exception->getMessage() . '|' . $exception->getFile() . '|' . $exception->getLine();

        $this->bucketJob->update([
            'status' => 0,
            'current_status' => 'error',
            'error' => $error
        ]);
    }
}