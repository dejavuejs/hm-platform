<?php

namespace Orca\CMS\Http\Controllers\Site;

use Orca\CMS\Http\Controllers\Controller;
use Orca\CMS\Repositories\CMSRepository as CMS;
use Orca\Core\Repositories\ChannelRepository as Channel;
use Orca\Core\Repositories\LocaleRepository as Locale;

/**
 * PagePresenter controller
 *
 * @author  Prashant Singh <>
 *
 */
 class PagePresenterController extends Controller
{
    /**
     * To hold the request variables from route file
     */
    protected $_config;

    /**
     * To hold the channel reposotry instance
     */
    protected $channel;

    /**
     * To hold the locale reposotry instance
     */
    protected $locale;

    /**
     * To hold the CMSRepository instance
     */
    protected $cms;

    public function __construct(Channel $channel, Locale $locale, CMS $cms)
    {
        /**
         * Channel repository instance
         */
        $this->channel = $channel;

        /**
         * Locale repository instance
         */
        $this->locale = $locale;

        /**
         * CMS repository instance
         */
        $this->cms = $cms;

        $this->_config = request('_config');
    }

    /**
     * To extract the page content and load it in the respective view file\
     *
     * @return view
     */
    public function presenter($slug)
    {
        $currentChannel = core()->getCurrentChannel();
        $currentLocale = app()->getLocale();

        $currentLocale = $this->locale->findOneWhere([
            'code' => $currentLocale
        ]);

        $page = $this->cms->findOneWhere([
            'url_key' => $slug,
            'locale_id' => $currentLocale->id,
            'channel_id' => $currentChannel->id
        ]);

        if ($page) {
            return view('site::cms.page')->with('page', $page);
        } else {
            abort(404);
        }

    }
}