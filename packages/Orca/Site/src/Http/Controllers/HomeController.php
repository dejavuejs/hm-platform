<?php

namespace Orca\Site\Http\Controllers;

use Orca\Site\Http\Controllers\Controller;
use Orca\Core\Repositories\SliderRepository;

/**
 * Home page controller
 *
 * @author    Prashant Singh <>
 *
 */
 class HomeController extends Controller
{
    protected $_config;
    protected $sliderRepository;
    protected $current_channel;

    public function __construct(SliderRepository $sliderRepository)
    {
        $this->_config = request('_config');

        $this->sliderRepository = $sliderRepository;
    }

    /**
     * loads the home page for the storefront
     */
    public function index()
    {
        $currentChannel = core()->getCurrentChannel()->id;
        $sliderData = $this->sliderRepository->findByField('channel_id', $currentChannel)->toArray();

        return view($this->_config['view'], compact('sliderData'));
    }

    /**
     * loads the home page for the storefront
     */
    public function notFound()
    {
        abort(404);
    }
}