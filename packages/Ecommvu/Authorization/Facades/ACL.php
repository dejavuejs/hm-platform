<?php

namespace Ecommvu\Authorization\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * ACL class for resolving ACL helper as static via laravel's DI
 */
class ACL extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'acl';
    }
}
