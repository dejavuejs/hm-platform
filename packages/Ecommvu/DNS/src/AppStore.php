<?php

namespace Ecommvu\DNS;

use Ecommvu\AppStore\BaseStore;
//you can make use of all the related models here

class AppStore extends BaseStore
{
    /**
     * To hold guards required by App
     *
     * @var Array
     */
    public $guards = [];

    /**
     * Constructor for dns app store implementation
     */
    public function __construct()
    {
        /**
         * Set application name using the BaseStore class properties
         */
        $this->name = config('subscription-apps.monthly.dns.name');

        /**
         * Set application's code using the BaseStore class properties
         */
        $this->code = config('subscription-apps.monthly.dns.code');

        /**
         * Set the application's description
         */
        $this->description = config('subscription-apps.monthly.dns.description');

        /**
         * Set application trial status
         */
        $this->trial = config('subscription-apps.monthly.dns.trial');

         /**
         * Set application trial days
         */
        $this->trialDays = config('subscription-apps.monthly.dns.trial_days');

         /**
         * Set application trial status
         */
        $this->scopes = config('subscription-apps.monthly.dns.scopes');

        /**
         * Set isFree property for app
         */
        $this->isFree = config('subscription-apps.monthly.dns.free');

        /**
         * To set application guards
         */
        $this->guards = config('subscription-apps.monthly.dns.guards');

        parent::__construct(self::class);
    }

    /**
     * Returns code for the app
     *
     * @return String
     */
    public function getCode() : string
    {
        return $this->code;
    }

    /**
     * Returns name of the app
     *
     * @return String
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Is free app
     *
     * @return Boolean
     */
    public function free() : bool
    {
        return $this->isFree;
    }

    /**
     * To check whether application is scopeless or not.
     *
     * @return Boolean
     */
    public function hasScopes() : bool
    {
        if (count($this->scopes))
            return true;
        else
            return false;
    }

    /**
     * To fetch scopes of the app
     *
     * @return Array
     */
    public function getScopes() : array
    {
        if ($this->hasScopes())
            return $this->scopes;
        else
            return $this->scopes = [];
    }

    /**
     * To fetch app guards
     *
     * @return Array
     */
    public function getGuards() : array
    {
        return $this->guards;
    }
}