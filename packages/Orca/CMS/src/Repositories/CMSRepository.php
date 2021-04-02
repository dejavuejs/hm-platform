<?php

namespace Orca\CMS\Repositories;

use Orca\Core\Eloquent\Repository;
use Illuminate\Container\Container as App;
use Orca\Core\Repositories\ChannelRepository as Channel;
use Orca\Core\Repositories\LocaleRepository as Locale;

/**
 * CMS Reposotory
 *
 * @author  Prashant Singh <>
 *
 */

class CMSRepository extends Repository
{
    /**
     * To hold the channel reposotry instance
     */
    protected $channel;

    /**
     * To hold the locale reposotry instance
     */
    protected $locale;

    public function __construct(Channel $channel, Locale $locale, App $app)
    {
        $this->channel = $channel;

        $this->locale = $locale;

        parent::__construct($app);
    }
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'Orca\CMS\Contracts\CMS';
    }

    public function create(array $data)
    {
        $result = $this->model->create($data);

        if ($result) {
            return $result;
        } else {
            return $result;
        }
    }
}