<?php

namespace Ecommvu\Transcriber\Helpers;

use Ecommvu\Transcriber\Repositories\PatientConsultationRepository;
use Ecommvu\Transcriber\Helpers\AssemblyAIHelper;
use Ecommvu\Transcriber\Helpers\TherapyHelper;
use Illuminate\Support\Facades\Storage;

class TherapistHelper {
    protected $assemblyAIHelper;
    protected $therapyHelper;
    protected $patientConsultation;

    public function __construct(
        AssemblyAIHelper $assemblyAIHelper,
        TherapyHelper $therapyHelper,
        PatientConsultation $patientConsultation
    )
    {
        $this->assemblyAIHelper = $assemblyAIHelper;
        $this->therapyHelper = $therapyHelper;
        $this->patientConsultation = $patientConsultation;
    }

    public function main()
    {
        $patientConsultation = [];
        $transcript = null;

        try {
            $transcript = $this->assemblyAIHelper->transcribe();
        } catch (Exception $e) {
            throw new Exception('Error! - Cannot transcribe');
        }

        try {
            $prescriptionGPT = $this->therapyHelper->
        }
    }
}