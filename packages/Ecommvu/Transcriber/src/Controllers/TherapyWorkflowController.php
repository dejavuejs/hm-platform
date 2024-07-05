<?php

namespace Ecommvu\Transcriber\Controllers;

use Illuminate\Support\Facades\Event;
use Ecommvu\Transcriber\Repositories\PatientConsultationRepository;

class TherapyWorkflowController extends Controller
{
    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * PatientConsultationRepository object
     *
     * @var \Ecommvu\Core\Repositories\PatientConsultationRepository
     */
    protected $patientConsultationRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Ecommvu\Core\Repositories\PatientConsultationRepository  $campaignRepository
     * @return void
     */
    public function __construct(PatientConsultationRepository $patientConsultationRepository)
    {
        $this->patientConsultationRepository = $patientConsultationRepository;

        $this->_config = request('_config');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }
}