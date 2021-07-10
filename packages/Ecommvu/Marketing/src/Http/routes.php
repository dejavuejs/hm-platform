<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('promotions')->group(function () {
        //Marketing campaigns routes
        Route::get('campaigns', 'Ecommvu\Marketing\Http\Controllers\CampaignController@index')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.campaigns.index',
        ])->name('admin.campaigns.index');

        Route::get('campaigns/create', 'Ecommvu\Marketing\Http\Controllers\CampaignController@create')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.campaigns.create',
        ])->name('admin.campaigns.create');

        Route::post('campaigns/create', 'Ecommvu\Marketing\Http\Controllers\CampaignController@store')->defaults('_config', [
            'redirect' => 'admin.campaigns.index',
        ])->name('admin.campaigns.store');

        Route::get('campaigns/edit/{id}', 'Ecommvu\Marketing\Http\Controllers\CampaignController@edit')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.campaigns.edit',
        ])->name('admin.campaigns.edit');

        Route::post('campaigns/edit/{id}', 'Ecommvu\Marketing\Http\Controllers\CampaignController@update')->defaults('_config', [
            'redirect' => 'admin.campaigns.index',
        ])->name('admin.campaigns.update');

        Route::post('campaigns/delete/{id}', 'Ecommvu\Marketing\Http\Controllers\CampaignController@destroy')->name('admin.campaigns.delete');


        //Marketing emails templates routes
        Route::get('email-templates', 'Ecommvu\Marketing\Http\Controllers\TemplateController@index')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.templates.index',
        ])->name('admin.email-templates.index');

        Route::get('email-templates/create', 'Ecommvu\Marketing\Http\Controllers\TemplateController@create')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.templates.create',
        ])->name('admin.email-templates.create');

        Route::post('email-templates/create', 'Ecommvu\Marketing\Http\Controllers\TemplateController@store')->defaults('_config', [
            'redirect' => 'admin.email-templates.index',
        ])->name('admin.email-templates.store');

        Route::get('email-templates/edit/{id}', 'Ecommvu\Marketing\Http\Controllers\TemplateController@edit')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.templates.edit',
        ])->name('admin.email-templates.edit');

        Route::post('email-templates/edit/{id}', 'Ecommvu\Marketing\Http\Controllers\TemplateController@update')->defaults('_config', [
            'redirect' => 'admin.email-templates.index',
        ])->name('admin.email-templates.update');

        Route::post('email-templates/delete/{id}', 'Ecommvu\Marketing\Http\Controllers\TemplateController@destroy')->name('admin.email-templates.delete');


        //Marketing events routes
        Route::get('events', 'Ecommvu\Marketing\Http\Controllers\EventController@index')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.events.index',
        ])->name('admin.events.index');

        Route::get('events/create', 'Ecommvu\Marketing\Http\Controllers\EventController@create')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.events.create',
        ])->name('admin.events.create');

        Route::post('events/create', 'Ecommvu\Marketing\Http\Controllers\EventController@store')->defaults('_config', [
            'redirect' => 'admin.events.index',
        ])->name('admin.events.store');

        Route::get('events/edit/{id}', 'Ecommvu\Marketing\Http\Controllers\EventController@edit')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.events.edit',
        ])->name('admin.events.edit');

        Route::post('events/edit/{id}', 'Ecommvu\Marketing\Http\Controllers\EventController@update')->defaults('_config', [
            'redirect' => 'admin.events.index',
        ])->name('admin.events.update');

        Route::post('events/delete/{id}', 'Ecommvu\Marketing\Http\Controllers\EventController@destroy')->name('admin.events.delete');


        // Admin Store Front Settings Route
        Route::get('/subscribers', 'Orca\Core\Http\Controllers\SubscriptionController@index')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.subscribers.index',
        ])->name('admin.customers.subscribers.index');

        //destroy a newsletter subscription item
        Route::post('subscribers/delete/{id}', 'Orca\Core\Http\Controllers\SubscriptionController@destroy')->name('admin.customers.subscribers.delete');

        Route::get('subscribers/edit/{id}', 'Orca\Core\Http\Controllers\SubscriptionController@edit')->defaults('_config', [
            'view' => 'marketing::marketing.email-marketing.subscribers.edit',
        ])->name('admin.customers.subscribers.edit');

        Route::put('subscribers/update/{id}', 'Orca\Core\Http\Controllers\SubscriptionController@update')->defaults('_config', [
            'redirect' => 'admin.customers.subscribers.index',
        ])->name('admin.customers.subscribers.update');
    });
});
