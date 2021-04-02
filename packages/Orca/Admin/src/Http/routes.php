<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {

        Route::get('/', 'Orca\Admin\Http\Controllers\Controller@redirectToLogin');

        // Login Routes
        Route::get('/login', 'Orca\User\Http\Controllers\SessionController@create')->defaults('_config', [
            'view' => 'admin::users.sessions.create'
        ])->name('admin.session.create');

        //login post route to admin auth controller
        Route::post('/login', 'Orca\User\Http\Controllers\SessionController@store')->defaults('_config', [
            'redirect' => 'admin.dashboard.index'
        ])->name('admin.session.store');

        // Forget Password Routes
        Route::get('/forget-password', 'Orca\User\Http\Controllers\ForgetPasswordController@create')->defaults('_config', [
            'view' => 'admin::users.forget-password.create'
        ])->name('admin.forget-password.create');

        Route::post('/forget-password', 'Orca\User\Http\Controllers\ForgetPasswordController@store')->name('admin.forget-password.store');

        // Reset Password Routes
        Route::get('/reset-password/{token}', 'Orca\User\Http\Controllers\ResetPasswordController@create')->defaults('_config', [
            'view' => 'admin::users.reset-password.create'
        ])->name('admin.reset-password.create');

        Route::post('/reset-password', 'Orca\User\Http\Controllers\ResetPasswordController@store')->defaults('_config', [
            'redirect' => 'admin.dashboard.index'
        ])->name('admin.reset-password.store');


        // Admin Routes
        Route::group(['middleware' => ['admin']], function () {
            Route::get('/logout', 'Orca\User\Http\Controllers\SessionController@destroy')->defaults('_config', [
                'redirect' => 'admin.session.create'
            ])->name('admin.session.destroy');

            // Dashboard Route
            Route::get('dashboard', 'Orca\Admin\Http\Controllers\DashboardController@index')->defaults('_config', [
                'view' => 'admin::dashboard.index'
            ])->name('admin.dashboard.index');

            //Audience Management Routes
            Route::get('audiences', 'Orca\Admin\Http\Controllers\Audience\AudienceController@index')->defaults('_config', [
                'view' => 'admin::audiences.index'
            ])->name('admin.audience.index');

            Route::get('audiences/create', 'Orca\Admin\Http\Controllers\Audience\AudienceController@create')->defaults('_config',[
                'view' => 'admin::audiences.create'
            ])->name('admin.audience.create');

            Route::post('audiences/create', 'Orca\Admin\Http\Controllers\Audience\AudienceController@store')->defaults('_config',[
                'redirect' => 'admin.audience.index'
            ])->name('admin.audience.store');

            Route::get('audiences/edit/{id}', 'Orca\Admin\Http\Controllers\Audience\AudienceController@edit')->defaults('_config',[
                'view' => 'admin::audiences.edit'
            ])->name('admin.audience.edit');

            Route::get('audiences/note/{id}', 'Orca\Admin\Http\Controllers\Audience\AudienceController@createNote')->defaults('_config',[
                'view' => 'admin::audiences.note'
            ])->name('admin.audience.note.create');

            Route::put('audiences/note/{id}', 'Orca\Admin\Http\Controllers\Audience\AudienceController@storeNote')->defaults('_config',[
                'redirect' => 'admin.audience.index'
            ])->name('admin.audience.note.store');

            Route::put('audiences/edit/{id}', 'Orca\Admin\Http\Controllers\Audience\AudienceController@update')->defaults('_config', [
                'redirect' => 'admin.audience.index'
            ])->name('admin.audience.update');

            Route::post('audiences/delete/{id}', 'Orca\Admin\Http\Controllers\Audience\AudienceController@destroy')->name('admin.audience.delete');

            Route::post('audiences/masssdelete', 'Orca\Admin\Http\Controllers\Audience\AudienceController@massDestroy')->name('admin.audience.mass-delete');

            Route::post('audiences/masssupdate', 'Orca\Admin\Http\Controllers\Audience\AudienceController@massUpdate')->name('admin.audience.mass-update');

            Route::get('reviews', 'Orca\Product\Http\Controllers\ReviewController@index')->defaults('_config',[
                'view' => 'admin::audiences.reviews.index'
            ])->name('admin.audience.review.index');

            // Configuration routes
            Route::get('configuration/{slug?}/{slug2?}', 'Orca\Admin\Http\Controllers\ConfigurationController@index')->defaults('_config', [
                'view' => 'admin::configuration.index'
            ])->name('admin.configuration.index');

            Route::post('configuration/{slug?}/{slug2?}', 'Orca\Admin\Http\Controllers\ConfigurationController@store')->defaults('_config', [
                'redirect' => 'admin.configuration.index'
            ])->name('admin.configuration.index.store');

            Route::get('configuration/{slug?}/{slug2?}/{path}', 'Orca\Admin\Http\Controllers\ConfigurationController@download')->defaults('_config', [
                'redirect' => 'admin.configuration.index'
            ])->name('admin.configuration.download');

            // Reviews Routes
            Route::get('reviews/edit/{id}', 'Orca\Product\Http\Controllers\ReviewController@edit')->defaults('_config',[
                'view' => 'admin::audiences.reviews.edit'
            ])->name('admin.audience.review.edit');

            Route::put('reviews/edit/{id}', 'Orca\Product\Http\Controllers\ReviewController@update')->defaults('_config', [
                'redirect' => 'admin.audience.review.index'
            ])->name('admin.audience.review.update');

            Route::post('reviews/delete/{id}', 'Orca\Product\Http\Controllers\ReviewController@destroy')->defaults('_config', [
                'redirect' => 'admin.audience.review.index'
            ])->name('admin.audience.review.delete');

            //mass destroy
            Route::post('reviews/massdestroy', 'Orca\Product\Http\Controllers\ReviewController@massDestroy')->defaults('_config', [
                'redirect' => 'admin.audience.review.index'
            ])->name('admin.audience.review.massdelete');

            //mass update
            Route::post('reviews/massupdate', 'Orca\Product\Http\Controllers\ReviewController@massUpdate')->defaults('_config', [
                'redirect' => 'admin.audience.review.index'
            ])->name('admin.audience.review.massupdate');

            // Audience Groups Routes
            Route::get('groups', 'Orca\Admin\Http\Controllers\Audience\AudienceGroupController@index')->defaults('_config',[
                'view' => 'admin::audiences.groups.index'
            ])->name('admin.groups.index');

            Route::get('groups/create', 'Orca\Admin\Http\Controllers\Audience\AudienceGroupController@create')->defaults('_config',[
                'view' => 'admin::audiences.groups.create'
            ])->name('admin.groups.create');

            Route::post('groups/create', 'Orca\Admin\Http\Controllers\Audience\AudienceGroupController@store')->defaults('_config',[
                'redirect' => 'admin.groups.index'
            ])->name('admin.groups.store');

            Route::get('groups/edit/{id}', 'Orca\Admin\Http\Controllers\Audience\AudienceGroupController@edit')->defaults('_config',[
                'view' => 'admin::audiences.groups.edit'
            ])->name('admin.groups.edit');

            Route::put('groups/edit/{id}', 'Orca\Admin\Http\Controllers\Audience\AudienceGroupController@update')->defaults('_config',[
                'redirect' => 'admin.groups.index'
            ])->name('admin.groups.update');

            Route::post('groups/delete/{id}', 'Orca\Admin\Http\Controllers\Audience\AudienceGroupController@destroy')->name('admin.groups.delete');


            // Sales Routes
            Route::prefix('sales')->group(function () {
                // Sales Order Routes
                Route::get('/orders', 'Orca\Admin\Http\Controllers\Sales\OrderController@index')->defaults('_config', [
                    'view' => 'admin::sales.orders.index'
                ])->name('admin.sales.orders.index');

                Route::get('/orders/view/{id}', 'Orca\Admin\Http\Controllers\Sales\OrderController@view')->defaults('_config', [
                    'view' => 'admin::sales.orders.view'
                ])->name('admin.sales.orders.view');

                Route::get('/orders/cancel/{id}', 'Orca\Admin\Http\Controllers\Sales\OrderController@cancel')->defaults('_config', [
                    'view' => 'admin::sales.orders.cancel'
                ])->name('admin.sales.orders.cancel');


                // Sales Invoices Routes
                Route::get('/invoices', 'Orca\Admin\Http\Controllers\Sales\InvoiceController@index')->defaults('_config', [
                    'view' => 'admin::sales.invoices.index'
                ])->name('admin.sales.invoices.index');

                Route::get('/invoices/create/{order_id}', 'Orca\Admin\Http\Controllers\Sales\InvoiceController@create')->defaults('_config', [
                    'view' => 'admin::sales.invoices.create'
                ])->name('admin.sales.invoices.create');

                Route::post('/invoices/create/{order_id}', 'Orca\Admin\Http\Controllers\Sales\InvoiceController@store')->defaults('_config', [
                    'redirect' => 'admin.sales.orders.view'
                ])->name('admin.sales.invoices.store');

                Route::get('/invoices/view/{id}', 'Orca\Admin\Http\Controllers\Sales\InvoiceController@view')->defaults('_config', [
                    'view' => 'admin::sales.invoices.view'
                ])->name('admin.sales.invoices.view');

                Route::get('/invoices/print/{id}', 'Orca\Admin\Http\Controllers\Sales\InvoiceController@print')->defaults('_config', [
                    'view' => 'admin::sales.invoices.print'
                ])->name('admin.sales.invoices.print');


                // Sales Shipments Routes
                Route::get('/shipments', 'Orca\Admin\Http\Controllers\Sales\ShipmentController@index')->defaults('_config', [
                    'view' => 'admin::sales.shipments.index'
                ])->name('admin.sales.shipments.index');

                Route::get('/shipments/create/{order_id}', 'Orca\Admin\Http\Controllers\Sales\ShipmentController@create')->defaults('_config', [
                    'view' => 'admin::sales.shipments.create'
                ])->name('admin.sales.shipments.create');

                Route::post('/shipments/create/{order_id}', 'Orca\Admin\Http\Controllers\Sales\ShipmentController@store')->defaults('_config', [
                    'redirect' => 'admin.sales.orders.view'
                ])->name('admin.sales.shipments.store');

                Route::get('/shipments/view/{id}', 'Orca\Admin\Http\Controllers\Sales\ShipmentController@view')->defaults('_config', [
                    'view' => 'admin::sales.shipments.view'
                ])->name('admin.sales.shipments.view');
            });

            // Catalog Routes
            Route::prefix('catalog')->group(function () {
                Route::get('/sync', 'Orca\Product\Http\Controllers\ProductController@sync');

                // Catalog Product Routes
                Route::get('/products', 'Orca\Product\Http\Controllers\ProductController@index')->defaults('_config', [
                    'view' => 'admin::catalog.products.index'
                ])->name('admin.catalog.products.index');

                Route::get('/products/create', 'Orca\Product\Http\Controllers\ProductController@create')->defaults('_config', [
                    'view' => 'admin::catalog.products.create'
                ])->name('admin.catalog.products.create');

                Route::post('/products/create', 'Orca\Product\Http\Controllers\ProductController@store')->defaults('_config', [
                    'redirect' => 'admin.catalog.products.edit'
                ])->name('admin.catalog.products.store');

                Route::get('/products/edit/{id}', 'Orca\Product\Http\Controllers\ProductController@edit')->defaults('_config', [
                    'view' => 'admin::catalog.products.edit'
                ])->name('admin.catalog.products.edit');

                Route::put('/products/edit/{id}', 'Orca\Product\Http\Controllers\ProductController@update')->defaults('_config', [
                    'redirect' => 'admin.catalog.products.index'
                ])->name('admin.catalog.products.update');

                //product delete
                Route::post('/products/delete/{id}', 'Orca\Product\Http\Controllers\ProductController@destroy')->name('admin.catalog.products.delete');

                //product massaction
                Route::post('products/massaction', 'Orca\Product\Http\Controllers\ProductController@massActionHandler')->name('admin.catalog.products.massaction');

                //product massdelete
                Route::post('products/massdelete', 'Orca\Product\Http\Controllers\ProductController@massDestroy')->defaults('_config', [
                    'redirect' => 'admin.catalog.products.index'
                ])->name('admin.catalog.products.massdelete');

                //product massupdate
                Route::post('products/massupdate', 'Orca\Product\Http\Controllers\ProductController@massUpdate')->defaults('_config', [
                    'redirect' => 'admin.catalog.products.index'
                ])->name('admin.catalog.products.massupdate');

                //product search for linked products
                Route::get('products/search', 'Orca\Product\Http\Controllers\ProductController@productLinkSearch')->defaults('_config', [
                    'view' => 'admin::catalog.products.edit'
                ])->name('admin.catalog.products.productlinksearch');

                Route::get('/products/{id}/{attribute_id}', 'Orca\Product\Http\Controllers\ProductController@download')->defaults('_config', [
                    'view' => 'admin.catalog.products.edit'
                ])->name('admin.catalog.products.file.download');

                // Catalog Category Routes
                Route::get('/categories', 'Orca\Category\Http\Controllers\CategoryController@index')->defaults('_config', [
                    'view' => 'admin::catalog.categories.index'
                ])->name('admin.catalog.categories.index');

                Route::get('/categories/create', 'Orca\Category\Http\Controllers\CategoryController@create')->defaults('_config', [
                    'view' => 'admin::catalog.categories.create'
                ])->name('admin.catalog.categories.create');

                Route::post('/categories/create', 'Orca\Category\Http\Controllers\CategoryController@store')->defaults('_config', [
                    'redirect' => 'admin.catalog.categories.index'
                ])->name('admin.catalog.categories.store');

                Route::get('/categories/edit/{id}', 'Orca\Category\Http\Controllers\CategoryController@edit')->defaults('_config', [
                    'view' => 'admin::catalog.categories.edit'
                ])->name('admin.catalog.categories.edit');

                Route::put('/categories/edit/{id}', 'Orca\Category\Http\Controllers\CategoryController@update')->defaults('_config', [
                    'redirect' => 'admin.catalog.categories.index'
                ])->name('admin.catalog.categories.update');

                Route::post('/categories/delete/{id}', 'Orca\Category\Http\Controllers\CategoryController@destroy')->name('admin.catalog.categories.delete');


                // Catalog Attribute Routes
                Route::get('/attributes', 'Orca\Attribute\Http\Controllers\AttributeController@index')->defaults('_config', [
                    'view' => 'admin::catalog.attributes.index'
                ])->name('admin.catalog.attributes.index');

                Route::get('/attributes/create', 'Orca\Attribute\Http\Controllers\AttributeController@create')->defaults('_config', [
                    'view' => 'admin::catalog.attributes.create'
                ])->name('admin.catalog.attributes.create');

                Route::post('/attributes/create', 'Orca\Attribute\Http\Controllers\AttributeController@store')->defaults('_config', [
                    'redirect' => 'admin.catalog.attributes.index'
                ])->name('admin.catalog.attributes.store');

                Route::get('/attributes/edit/{id}', 'Orca\Attribute\Http\Controllers\AttributeController@edit')->defaults('_config', [
                    'view' => 'admin::catalog.attributes.edit'
                ])->name('admin.catalog.attributes.edit');

                Route::put('/attributes/edit/{id}', 'Orca\Attribute\Http\Controllers\AttributeController@update')->defaults('_config', [
                    'redirect' => 'admin.catalog.attributes.index'
                ])->name('admin.catalog.attributes.update');

                Route::post('/attributes/delete/{id}', 'Orca\Attribute\Http\Controllers\AttributeController@destroy')->name('admin.catalog.attributes.delete');

                Route::post('/attributes/massdelete', 'Orca\Attribute\Http\Controllers\AttributeController@massDestroy')->name('admin.catalog.attributes.massdelete');

                // Catalog Family Routes
                Route::get('/families', 'Orca\Attribute\Http\Controllers\AttributeFamilyController@index')->defaults('_config', [
                    'view' => 'admin::catalog.families.index'
                ])->name('admin.catalog.families.index');

                Route::get('/families/create', 'Orca\Attribute\Http\Controllers\AttributeFamilyController@create')->defaults('_config', [
                    'view' => 'admin::catalog.families.create'
                ])->name('admin.catalog.families.create');

                Route::post('/families/create', 'Orca\Attribute\Http\Controllers\AttributeFamilyController@store')->defaults('_config', [
                    'redirect' => 'admin.catalog.families.index'
                ])->name('admin.catalog.families.store');

                Route::get('/families/edit/{id}', 'Orca\Attribute\Http\Controllers\AttributeFamilyController@edit')->defaults('_config', [
                    'view' => 'admin::catalog.families.edit'
                ])->name('admin.catalog.families.edit');

                Route::put('/families/edit/{id}', 'Orca\Attribute\Http\Controllers\AttributeFamilyController@update')->defaults('_config', [
                    'redirect' => 'admin.catalog.families.index'
                ])->name('admin.catalog.families.update');

                Route::post('/families/delete/{id}', 'Orca\Attribute\Http\Controllers\AttributeFamilyController@destroy')->name('admin.catalog.families.delete');
            });

            // User Routes
            //datagrid for backend users
            Route::get('/users', 'Orca\User\Http\Controllers\UserController@index')->defaults('_config', [
                'view' => 'admin::users.users.index'
            ])->name('admin.users.index');

            //create backend user get
            Route::get('/users/create', 'Orca\User\Http\Controllers\UserController@create')->defaults('_config', [
                'view' => 'admin::users.users.create'
            ])->name('admin.users.create');

            //create backend user post
            Route::post('/users/create', 'Orca\User\Http\Controllers\UserController@store')->defaults('_config', [
                'redirect' => 'admin.users.index'
            ])->name('admin.users.store');

            //delete backend user view
            Route::get('/users/edit/{id}', 'Orca\User\Http\Controllers\UserController@edit')->defaults('_config', [
                'view' => 'admin::users.users.edit'
            ])->name('admin.users.edit');

            //edit backend user submit
            Route::put('/users/edit/{id}', 'Orca\User\Http\Controllers\UserController@update')->defaults('_config', [
                'redirect' => 'admin.users.index'
            ])->name('admin.users.update');

            //delete backend user
            Route::post('/users/delete/{id}', 'Orca\User\Http\Controllers\UserController@destroy')->name('admin.users.delete');

            Route::post('/confirm/destroy', 'Orca\User\Http\Controllers\UserController@destroySelf')->defaults('_config', [
                'redirect' => 'admin.users.index'
            ])->name('admin.users.confirm.destroy');

            // User Role Routes
            Route::get('/roles', 'Orca\User\Http\Controllers\RoleController@index')->defaults('_config', [
                'view' => 'admin::users.roles.index'
            ])->name('admin.roles.index');

            Route::get('/roles/create', 'Orca\User\Http\Controllers\RoleController@create')->defaults('_config', [
                'view' => 'admin::users.roles.create'
            ])->name('admin.roles.create');

            Route::post('/roles/create', 'Orca\User\Http\Controllers\RoleController@store')->defaults('_config', [
                'redirect' => 'admin.roles.index'
            ])->name('admin.roles.store');

            Route::get('/roles/edit/{id}', 'Orca\User\Http\Controllers\RoleController@edit')->defaults('_config', [
                'view' => 'admin::users.roles.edit'
            ])->name('admin.roles.edit');

            Route::put('/roles/edit/{id}', 'Orca\User\Http\Controllers\RoleController@update')->defaults('_config', [
                'redirect' => 'admin.roles.index'
            ])->name('admin.roles.update');

            Route::post('/roles/delete/{id}', 'Orca\User\Http\Controllers\RoleController@destroy')->name('admin.roles.delete');


            // Locale Routes
            Route::get('/locales', 'Orca\Core\Http\Controllers\LocaleController@index')->defaults('_config', [
                'view' => 'admin::settings.locales.index'
            ])->name('admin.locales.index');

            Route::get('/locales/create', 'Orca\Core\Http\Controllers\LocaleController@create')->defaults('_config', [
                'view' => 'admin::settings.locales.create'
            ])->name('admin.locales.create');

            Route::post('/locales/create', 'Orca\Core\Http\Controllers\LocaleController@store')->defaults('_config', [
                'redirect' => 'admin.locales.index'
            ])->name('admin.locales.store');

            Route::get('/locales/edit/{id}', 'Orca\Core\Http\Controllers\LocaleController@edit')->defaults('_config', [
                'view' => 'admin::settings.locales.edit'
            ])->name('admin.locales.edit');

            Route::put('/locales/edit/{id}', 'Orca\Core\Http\Controllers\LocaleController@update')->defaults('_config', [
                'redirect' => 'admin.locales.index'
            ])->name('admin.locales.update');

            Route::post('/locales/delete/{id}', 'Orca\Core\Http\Controllers\LocaleController@destroy')->name('admin.locales.delete');


            // Currency Routes
            Route::get('/currencies', 'Orca\Core\Http\Controllers\CurrencyController@index')->defaults('_config', [
                'view' => 'admin::settings.currencies.index'
            ])->name('admin.currencies.index');

            Route::get('/currencies/create', 'Orca\Core\Http\Controllers\CurrencyController@create')->defaults('_config', [
                'view' => 'admin::settings.currencies.create'
            ])->name('admin.currencies.create');

            Route::post('/currencies/create', 'Orca\Core\Http\Controllers\CurrencyController@store')->defaults('_config', [
                'redirect' => 'admin.currencies.index'
            ])->name('admin.currencies.store');

            Route::get('/currencies/edit/{id}', 'Orca\Core\Http\Controllers\CurrencyController@edit')->defaults('_config', [
                'view' => 'admin::settings.currencies.edit'
            ])->name('admin.currencies.edit');

            Route::put('/currencies/edit/{id}', 'Orca\Core\Http\Controllers\CurrencyController@update')->defaults('_config', [
                'redirect' => 'admin.currencies.index'
            ])->name('admin.currencies.update');

            Route::post('/currencies/delete/{id}', 'Orca\Core\Http\Controllers\CurrencyController@destroy')->name('admin.currencies.delete');

            Route::post('/currencies/massdelete', 'Orca\Core\Http\Controllers\CurrencyController@massDestroy')->name('admin.currencies.massdelete');


            // Exchange Rates Routes
            Route::get('/exchange_rates', 'Orca\Core\Http\Controllers\ExchangeRateController@index')->defaults('_config', [
                'view' => 'admin::settings.exchange_rates.index'
            ])->name('admin.exchange_rates.index');

            Route::get('/exchange_rates/create', 'Orca\Core\Http\Controllers\ExchangeRateController@create')->defaults('_config', [
                'view' => 'admin::settings.exchange_rates.create'
            ])->name('admin.exchange_rates.create');

            Route::post('/exchange_rates/create', 'Orca\Core\Http\Controllers\ExchangeRateController@store')->defaults('_config', [
                'redirect' => 'admin.exchange_rates.index'
            ])->name('admin.exchange_rates.store');

            Route::get('/exchange_rates/edit/{id}', 'Orca\Core\Http\Controllers\ExchangeRateController@edit')->defaults('_config', [
                'view' => 'admin::settings.exchange_rates.edit'
            ])->name('admin.exchange_rates.edit');

            Route::get('/exchange_rates/update-rates/{service}', 'Orca\Core\Http\Controllers\ExchangeRateController@updateRates')->name('admin.exchange_rates.update-rates');

            Route::put('/exchange_rates/edit/{id}', 'Orca\Core\Http\Controllers\ExchangeRateController@update')->defaults('_config', [
                'redirect' => 'admin.exchange_rates.index'
            ])->name('admin.exchange_rates.update');

            Route::post('/exchange_rates/delete/{id}', 'Orca\Core\Http\Controllers\ExchangeRateController@destroy')->name('admin.exchange_rates.delete');


            // Inventory Source Routes
            Route::get('/inventory_sources', 'Orca\Inventory\Http\Controllers\InventorySourceController@index')->defaults('_config', [
                'view' => 'admin::settings.inventory_sources.index'
            ])->name('admin.inventory_sources.index');

            Route::get('/inventory_sources/create', 'Orca\Inventory\Http\Controllers\InventorySourceController@create')->defaults('_config', [
                'view' => 'admin::settings.inventory_sources.create'
            ])->name('admin.inventory_sources.create');

            Route::post('/inventory_sources/create', 'Orca\Inventory\Http\Controllers\InventorySourceController@store')->defaults('_config', [
                'redirect' => 'admin.inventory_sources.index'
            ])->name('admin.inventory_sources.store');

            Route::get('/inventory_sources/edit/{id}', 'Orca\Inventory\Http\Controllers\InventorySourceController@edit')->defaults('_config', [
                'view' => 'admin::settings.inventory_sources.edit'
            ])->name('admin.inventory_sources.edit');

            Route::put('/inventory_sources/edit/{id}', 'Orca\Inventory\Http\Controllers\InventorySourceController@update')->defaults('_config', [
                'redirect' => 'admin.inventory_sources.index'
            ])->name('admin.inventory_sources.update');

            Route::post('/inventory_sources/delete/{id}', 'Orca\Inventory\Http\Controllers\InventorySourceController@destroy')->name('admin.inventory_sources.delete');

            // Channel Routes
            Route::get('/channels', 'Orca\Core\Http\Controllers\ChannelController@index')->defaults('_config', [
                'view' => 'admin::settings.channels.index'
            ])->name('admin.channels.index');

            Route::get('/channels/create', 'Orca\Core\Http\Controllers\ChannelController@create')->defaults('_config', [
                'view' => 'admin::settings.channels.create'
            ])->name('admin.channels.create');

            Route::post('/channels/create', 'Orca\Core\Http\Controllers\ChannelController@store')->defaults('_config', [
                'redirect' => 'admin.channels.index'
            ])->name('admin.channels.store');

            Route::get('/channels/edit/{id}', 'Orca\Core\Http\Controllers\ChannelController@edit')->defaults('_config', [
                'view' => 'admin::settings.channels.edit'
            ])->name('admin.channels.edit');

            Route::put('/channels/edit/{id}', 'Orca\Core\Http\Controllers\ChannelController@update')->defaults('_config', [
                'redirect' => 'admin.channels.index'
            ])->name('admin.channels.update');

            Route::post('/channels/delete/{id}', 'Orca\Core\Http\Controllers\ChannelController@destroy')->name('admin.channels.delete');


            // Admin Profile route
            Route::get('/account', 'Orca\User\Http\Controllers\AccountController@edit')->defaults('_config', [
                'view' => 'admin::account.edit'
            ])->name('admin.account.edit');

            Route::put('/account', 'Orca\User\Http\Controllers\AccountController@update')->name('admin.account.update');


            // Admin Store Front Settings Route
            Route::get('/subscribers','Orca\Core\Http\Controllers\SubscriptionController@index')->defaults('_config',[
                'view' => 'admin::audiences.subscribers.index'
            ])->name('admin.audiences.subscribers.index');

            //destroy a newsletter subscription item
            Route::post('subscribers/delete/{id}', 'Orca\Core\Http\Controllers\SubscriptionController@destroy')->name('admin.audiences.subscribers.delete');

            Route::get('subscribers/edit/{id}', 'Orca\Core\Http\Controllers\SubscriptionController@edit')->defaults('_config', [
                'view' => 'admin::audiences.subscribers.edit'
            ])->name('admin.audiences.subscribers.edit');

            Route::put('subscribers/update/{id}', 'Orca\Core\Http\Controllers\SubscriptionController@update')->defaults('_config', [
                'redirect' => 'admin.audiences.subscribers.index'
            ])->name('admin.audiences.subscribers.update');

            //slider index
            Route::get('/slider','Orca\Core\Http\Controllers\SliderController@index')->defaults('_config',[
                'view' => 'admin::settings.sliders.index'
            ])->name('admin.sliders.index');

            //slider create show
            Route::get('slider/create','Orca\Core\Http\Controllers\SliderController@create')->defaults('_config',[
                'view' => 'admin::settings.sliders.create'
            ])->name('admin.sliders.create');

            //slider create show
            Route::post('slider/create','Orca\Core\Http\Controllers\SliderController@store')->defaults('_config',[
                'redirect' => 'admin.sliders.index'
            ])->name('admin.sliders.store');

            //slider edit show
            Route::get('slider/edit/{id}','Orca\Core\Http\Controllers\SliderController@edit')->defaults('_config',[
                'view' => 'admin::settings.sliders.edit'
            ])->name('admin.sliders.edit');

            //slider edit update
            Route::post('slider/edit/{id}','Orca\Core\Http\Controllers\SliderController@update')->defaults('_config',[
                'redirect' => 'admin.sliders.index'
            ])->name('admin.sliders.update');

            //destroy a slider item
            Route::post('slider/delete/{id}', 'Orca\Core\Http\Controllers\SliderController@destroy')->name('admin.sliders.delete');

            //tax routes
            Route::get('/tax-categories', 'Orca\Tax\Http\Controllers\TaxController@index')->defaults('_config', [
                'view' => 'admin::tax.tax-categories.index'
            ])->name('admin.tax-categories.index');


            // tax category routes
            Route::get('/tax-categories/create', 'Orca\Tax\Http\Controllers\TaxCategoryController@show')->defaults('_config', [
                'view' => 'admin::tax.tax-categories.create'
            ])->name('admin.tax-categories.show');

            Route::post('/tax-categories/create', 'Orca\Tax\Http\Controllers\TaxCategoryController@create')->defaults('_config', [
                'redirect' => 'admin.tax-categories.index'
            ])->name('admin.tax-categories.create');

            Route::get('/tax-categories/edit/{id}', 'Orca\Tax\Http\Controllers\TaxCategoryController@edit')->defaults('_config', [
                'view' => 'admin::tax.tax-categories.edit'
            ])->name('admin.tax-categories.edit');

            Route::put('/tax-categories/edit/{id}', 'Orca\Tax\Http\Controllers\TaxCategoryController@update')->defaults('_config', [
                'redirect' => 'admin.tax-categories.index'
            ])->name('admin.tax-categories.update');

            Route::post('/tax-categories/delete/{id}', 'Orca\Tax\Http\Controllers\TaxCategoryController@destroy')->name('admin.tax-categories.delete');
            //tax category ends


            //tax rate
            Route::get('tax-rates', 'Orca\Tax\Http\Controllers\TaxRateController@index')->defaults('_config', [
                'view' => 'admin::tax.tax-rates.index'
            ])->name('admin.tax-rates.index');

            Route::get('tax-rates/create', 'Orca\Tax\Http\Controllers\TaxRateController@show')->defaults('_config', [
                'view' => 'admin::tax.tax-rates.create'
            ])->name('admin.tax-rates.show');

            Route::post('tax-rates/create', 'Orca\Tax\Http\Controllers\TaxRateController@create')->defaults('_config', [
                'redirect' => 'admin.tax-rates.index'
            ])->name('admin.tax-rates.create');

            Route::get('tax-rates/edit/{id}', 'Orca\Tax\Http\Controllers\TaxRateController@edit')->defaults('_config', [
                'view' => 'admin::tax.tax-rates.edit'
            ])->name('admin.tax-rates.store');

            Route::put('tax-rates/update/{id}', 'Orca\Tax\Http\Controllers\TaxRateController@update')->defaults('_config', [
                'redirect' => 'admin.tax-rates.index'
            ])->name('admin.tax-rates.update');

            Route::post('/tax-rates/delete/{id}', 'Orca\Tax\Http\Controllers\TaxRateController@destroy')->name('admin.tax-rates.delete');

            Route::post('/tax-rates/import', 'Orca\Tax\Http\Controllers\TaxRateController@import')->defaults('_config', [
                'redirect' => 'admin.tax-rates.index'
            ])->name('admin.tax-rates.import');
            //tax rate ends

            //DataGrid Export
            Route::post('admin/export', 'Orca\Admin\Http\Controllers\ExportController@export')->name('admin.datagrid.export');

            Route::prefix('promotion')->group(function () {
                Route::get('/catalog-rules', 'Orca\Discount\Http\Controllers\CatalogRuleController@index')->defaults('_config', [
                    'view' => 'admin::promotions.catalog-rule.index'
                ])->name('admin.catalog-rule.index');

                Route::get('/catalog-rules/create', 'Orca\Discount\Http\Controllers\CatalogRuleController@create')->defaults('_config', [
                    'view' => 'admin::promotions.catalog-rule.create'
                ])->name('admin.catalog-rule.create');

                Route::post('/catalog-rules/create', 'Orca\Discount\Http\Controllers\CatalogRuleController@store')->defaults('_config', [
                    'redirect' => 'admin.catalog-rule.index'
                ])->name('admin.catalog-rule.store');

                Route::get('/catalog-rules/edit/{id}', 'Orca\Discount\Http\Controllers\CatalogRuleController@edit')->defaults('_config', [
                    'view' => 'admin::promotions.catalog-rule.edit'
                ])->name('admin.catalog-rule.edit');

                Route::post('/catalog-rules/edit/{id}', 'Orca\Discount\Http\Controllers\CatalogRuleController@update')->defaults('_config', [
                    'redirect' => 'admin.catalog-rule.index'
                ])->name('admin.catalog-rule.update');

                Route::get('/catalog-rules/apply', 'Orca\Discount\Http\Controllers\CatalogRuleController@applyRules')->defaults('_config', [
                    'view' => 'admin::promotions.catalog-rule.index'
                ])->name('admin.catalog-rule.apply');

                Route::post('/catalog-rules/delete/{id}', 'Orca\Discount\Http\Controllers\CatalogRuleController@destroy')->name('admin.catalog-rule.delete');

                Route::post('fetch/options', 'Orca\Discount\Http\Controllers\CatalogRuleController@fetchAttributeOptions')->name('admin.catalog-rule.options');

                Route::get('cart-rules', 'Orca\Discount\Http\Controllers\CartRuleController@index')->defaults('_config', [
                    'view' => 'admin::promotions.cart-rule.index'
                ])->name('admin.cart-rule.index');

                Route::get('cart-rules/create', 'Orca\Discount\Http\Controllers\CartRuleController@create')->defaults('_config', [
                    'view' => 'admin::promotions.cart-rule.create'
                ])->name('admin.cart-rule.create');

                Route::post('cart-rules/store', 'Orca\Discount\Http\Controllers\CartRuleController@store')->defaults('_config', [
                    'redirect' => 'admin.cart-rule.index'
                ])->name('admin.cart-rule.store');

                Route::get('cart-rules/edit/{id}', 'Orca\Discount\Http\Controllers\CartRuleController@edit')->defaults('_config', [
                    'view' => 'admin::promotions.cart-rule.edit'
                ])->name('admin.cart-rule.edit');

                Route::post('cart-rules/update/{id}', 'Orca\Discount\Http\Controllers\CartRuleController@update')->defaults('_config', [
                    'redirect' => 'admin.cart-rule.index'
                ])->name('admin.cart-rule.update');

                Route::post('cart-rules/delete/{id}', 'Orca\Discount\Http\Controllers\CartRuleController@destroy')->name('admin.cart-rule.delete');
            });

            Route::prefix('cms')->group(function () {
                Route::get('/', 'Orca\CMS\Http\Controllers\Admin\PageController@index')->defaults('_config', [
                    'view' => 'admin::cms.index'
                ])->name('admin.cms.index');

                Route::get('preview/{url_key}', 'Orca\CMS\Http\Controllers\Admin\PageController@preview')->name('admin.cms.preview');

                Route::get('create', 'Orca\CMS\Http\Controllers\Admin\PageController@create')->defaults('_config', [
                    'view' => 'admin::cms.create'
                ])->name('admin.cms.create');

                Route::post('create', 'Orca\CMS\Http\Controllers\Admin\PageController@store')->defaults('_config', [
                    'redirect' => 'admin.cms.index'
                ])->name('admin.cms.store');

                Route::get('update/{id}', 'Orca\CMS\Http\Controllers\Admin\PageController@edit')->defaults('_config', [
                    'view' => 'admin::cms.edit'
                ])->name('admin.cms.edit');

                Route::post('update/{id}', 'Orca\CMS\Http\Controllers\Admin\PageController@update')->defaults('_config', [
                    'redirect' => 'admin.cms.index'
                ])->name('admin.cms.update');

                Route::post('/delete/{id}', 'Orca\CMS\Http\Controllers\Admin\PageController@delete')->defaults('_config', [
                    'redirect' => 'admin.cms.index'
                ])->name('admin.cms.delete');

                Route::post('/massdelete', 'Orca\CMS\Http\Controllers\Admin\PageController@massDelete')->defaults('_config', [
                    'redirect' => 'admin.cms.index'
                ])->name('admin.cms.mass-delete');

                // Route::post('/delete/{id}', 'Orca\CMS\Http\Controllers\Admin\PageController@delete')->defaults('_config', [
                //     'redirect' => 'admin.cms.index'
                // ])->name('admin.cms.delete');
            });
        });
    });
});