<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\PatientConsultationRepository;
use Ecommvu\Transcriber\Helpers\AssemblyAIHelper;
use Ecommvu\Transcriber\Helpers\TherapyHelper;
use Illuminate\Support\Facades\Storage;

class DriverHelper {
    protected $assemblyAIHelper;
    protected $therapyHelper;

    public function __construct(
        AssemblyAIHelper $assemblyAIHelper,
        TherapyHelper $therapyHelper
    )
    {
        $this->assemblyAIHelper = $assemblyAIHelper;
        $this->therapyHelper = $therapyHelper;
    }

    public function main()
    {
        // prepare model
    }
}