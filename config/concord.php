<?php

return [
    'modules' => [
        /**
         * Example:
         * VendorA\ModuleX\Providers\ModuleServiceProvider::class,
         * VendorB\ModuleY\Providers\ModuleServiceProvider::class
         *
         */

        \Orca\Category\Providers\ModuleServiceProvider::class,
        \Orca\Core\Providers\ModuleServiceProvider::class,
        \Orca\Customer\Providers\ModuleServiceProvider::class,
        \Orca\CMS\Providers\ModuleServiceProvider::class,
        \Orca\User\Providers\ModuleServiceProvider::class,
        \Ecommvu\Marketing\Providers\ModuleServiceProvider::class,
        \Ecommvu\Transcriber\Providers\ModuleServiceProvider::class
    ]
];