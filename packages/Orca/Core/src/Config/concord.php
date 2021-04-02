<?php

return [
    'modules' => [
        /**
         * Example:
         * VendorA\ModuleX\Providers\ModuleServiceProvider::class,
         * VendorB\ModuleY\Providers\ModuleServiceProvider::class
         *
         */

        \Orca\Attribute\Providers\ModuleServiceProvider::class,
        \Orca\Category\Providers\ModuleServiceProvider::class,
        \Orca\Checkout\Providers\ModuleServiceProvider::class,
        \Orca\Core\Providers\ModuleServiceProvider::class,
        \Orca\Audience\Providers\ModuleServiceProvider::class,
        \Orca\Inventory\Providers\ModuleServiceProvider::class,
        \Orca\Product\Providers\ModuleServiceProvider::class,
        \Orca\Sales\Providers\ModuleServiceProvider::class,
        \Orca\Tax\Providers\ModuleServiceProvider::class,
        \Orca\User\Providers\ModuleServiceProvider::class,
        \Orca\Discount\Providers\ModuleServiceProvider::class,
    ]
];