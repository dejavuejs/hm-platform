<?php

namespace Ecommvu\DNS\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ActivationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Holds the instance of Buckets model
     *
     * @var Ecommvu\DNS\Models\DNS $bucket
     */
    public $activation;

    /**
     * Initiate default tries with this script
     *
     * @var integer
     */
    public $tries = 1;

    /**
     * Constructor dependency injection
     *
     * @param \Illuminate\Database\Eloquent $dns
     */
    public function __construct($activation)
    {
        $this->activation = $activation;
    }

    public function handle()
    {
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