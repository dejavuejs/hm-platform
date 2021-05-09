<?php

Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {
    //Store front home
    Route::get('/', 'Orca\Site\Http\Controllers\HomeController@index')->defaults('_config', [
        'view' => 'site::home.index'
    ])->name('Site.home.index');

    //subscription
    //subscribe
    Route::get('/subscribe', 'Orca\Site\Http\Controllers\SubscriptionController@subscribe')->name('Site.subscribe');

    //unsubscribe
    Route::get('/unsubscribe/{token}', 'Orca\Site\Http\Controllers\SubscriptionController@unsubscribe')->name('Site.unsubscribe');

    //Store front header nav-menu fetch
    Route::get('/categories/{slug}', 'Orca\Site\Http\Controllers\CategoryController@index')->defaults('_config', [
        'view' => 'site::products.index'
    ])->name('Site.categories.index');

    //Store front search
    Route::get('/search', 'Orca\Site\Http\Controllers\SearchController@index')->defaults('_config', [
        'view' => 'site::search.search'
    ])->name('Site.search.index');

    //Country State Selector
    Route::get('get/countries', 'Orca\Core\Http\Controllers\CountryStateController@getCountries')->defaults('_config', [
        'view' => 'site::test'
    ])->name('get.countries');

    //Get States When Country is Passed
    Route::get('get/states/{country}', 'Orca\Core\Http\Controllers\CountryStateController@getStates')->defaults('_config', [
        'view' => 'site::test'
    ])->name('get.states');

    //customer routes starts here
    Route::prefix('customer')->group(function () {
        // forgot Password Routes
        // Forgot Password Form Show
        Route::get('/forgot-password', 'Orca\Audience\Http\Controllers\ForgotPasswordController@create')->defaults('_config', [
            'view' => 'site::customers.signup.forgot-password'
        ])->name('customer.forgot-password.create');

        // Forgot Password Form Store
        Route::post('/forgot-password', 'Orca\Audience\Http\Controllers\ForgotPasswordController@store')->name('customer.forgot-password.store');

        // Reset Password Form Show
        Route::get('/reset-password/{token}', 'Orca\Audience\Http\Controllers\ResetPasswordController@create')->defaults('_config', [
            'view' => 'site::customers.signup.reset-password'
        ])->name('customer.reset-password.create');

        // Reset Password Form Store
        Route::post('/reset-password', 'Orca\Audience\Http\Controllers\ResetPasswordController@store')->defaults('_config', [
            'redirect' => 'customer.profile.index'
        ])->name('customer.reset-password.store');

        // Login Routes
        // Login form show
        Route::get('login', 'Orca\Audience\Http\Controllers\SessionController@show')->defaults('_config', [
            'view' => 'site::customers.session.index',
        ])->name('customer.session.index');

        // Login form store
        Route::post('login', 'Orca\Audience\Http\Controllers\SessionController@create')->defaults('_config', [
            'redirect' => 'customer.profile.index'
        ])->name('customer.session.create');

        // Registration Routes
        //registration form show
        Route::get('register', 'Orca\Audience\Http\Controllers\RegistrationController@show')->defaults('_config', [
            'view' => 'site::customers.signup.index'
        ])->name('customer.register.index');

        //registration form store
        Route::post('register', 'Orca\Audience\Http\Controllers\RegistrationController@create')->defaults('_config', [
            'redirect' => 'customer.session.index',
        ])->name('customer.register.create');

        //verify account
        Route::get('/verify-account/{token}', 'Orca\Audience\Http\Controllers\RegistrationController@verifyAccount')->name('customer.verify');

        //resend verification email
        Route::get('/resend/verification/{email}', 'Orca\Audience\Http\Controllers\RegistrationController@resendVerificationEmail')->name('customer.resend.verification-email');

        // Auth Routes
        Route::group(['middleware' => ['customer']], function () {

            //Audience logout
            Route::get('logout', 'Orca\Audience\Http\Controllers\SessionController@destroy')->defaults('_config', [
                'redirect' => 'customer.session.index'
            ])->name('customer.session.destroy');

            //customer account
            Route::prefix('account')->group(function () {
                //Audience Dashboard Route
                Route::get('index', 'Orca\Audience\Http\Controllers\AccountController@index')->defaults('_config', [
                    'view' => 'site::customers.account.index'
                ])->name('customer.account.index');

                //Audience Profile Show
                Route::get('profile', 'Orca\Audience\Http\Controllers\AudienceController@index')->defaults('_config', [
                    'view' => 'site::customers.account.profile.index'
                ])->name('customer.profile.index');

                //Audience Profile Edit Form Show
                Route::get('profile/edit', 'Orca\Audience\Http\Controllers\AudienceController@edit')->defaults('_config', [
                    'view' => 'site::customers.account.profile.edit'
                ])->name('customer.profile.edit');

                //Audience Profile Edit Form Store
                Route::post('profile/edit', 'Orca\Audience\Http\Controllers\AudienceController@update')->defaults('_config', [
                    'redirect' => 'customer.profile.index'
                ])->name('customer.profile.update');
                /*  Profile Routes Ends Here  */

                /*    Routes for Addresses   */
                //Audience Address Show
                Route::get('addresses', 'Orca\Audience\Http\Controllers\AddressController@index')->defaults('_config', [
                    'view' => 'site::customers.account.address.index'
                ])->name('customer.address.index');

                //Audience Address Create Form Show
                Route::get('addresses/create', 'Orca\Audience\Http\Controllers\AddressController@create')->defaults('_config', [
                    'view' => 'site::customers.account.address.create'
                ])->name('customer.address.create');

                //Audience Address Create Form Store
                Route::post('addresses/create', 'Orca\Audience\Http\Controllers\AddressController@store')->defaults('_config', [
                    'view' => 'site::customers.account.address.address',
                    'redirect' => 'customer.address.index'
                ])->name('customer.address.store');

                //Audience Address Edit Form Show
                Route::get('addresses/edit/{id}', 'Orca\Audience\Http\Controllers\AddressController@edit')->defaults('_config', [
                    'view' => 'site::customers.account.address.edit'
                ])->name('customer.address.edit');

                //Audience Address Edit Form Store
                Route::put('addresses/edit/{id}', 'Orca\Audience\Http\Controllers\AddressController@update')->defaults('_config', [
                    'redirect' => 'customer.address.index'
                ])->name('customer.address.update');

                //Audience Address Make Default
                Route::get('addresses/default/{id}', 'Orca\Audience\Http\Controllers\AddressController@makeDefault')->name('make.default.address');

                //Audience Address Delete
                Route::get('addresses/delete/{id}', 'Orca\Audience\Http\Controllers\AddressController@destroy')->name('address.delete');

                /* Reviews route */
                //Audience reviews
                Route::get('reviews', 'Orca\Audience\Http\Controllers\AudienceController@reviews')->defaults('_config', [
                    'view' => 'site::customers.account.reviews.index'
                ])->name('customer.reviews.index');

                //Audience review delete
                Route::get('reviews/delete/{id}', 'Orca\Site\Http\Controllers\ReviewController@destroy')->defaults('_config', [
                    'redirect' => 'customer.reviews.index'
                ])->name('customer.review.delete');

                //Audience all review delete
                Route::get('reviews/all-delete', 'Orca\Site\Http\Controllers\ReviewController@deleteAll')->defaults('_config', [
                    'redirect' => 'customer.reviews.index'
                ])->name('customer.review.deleteall');
            });
        });
    });
    //customer routes end here

    Route::get('pages/{slug}', 'Orca\CMS\Http\Controllers\Site\PagePresenterController@presenter')->name('Site.cms.page');

    Route::fallback('Orca\Site\Http\Controllers\HomeController@notFound');
});
