<?php

Route::group(['middleware' => ['web']], function () {
    Route::prefix('admin')->group(function () {

        Route::group(['middleware' => ['admin']], function () {
        //Marketing campaigns routes
            Route::get('therapy', 'Ecommvu\Transcriber\Controllers\TherapyWorkflowController@index')->defaults('_config', [
                'view' => 'transcriber::workflows.index',
            ])->name('therapy_consultations.index');
        });
        // Route::get('campaigns/create', 'Ecommvu\Marketing\Http\Controllers\CampaignController@create')->defaults('_config', [
        //     'view' => 'marketing::marketing.email-marketing.campaigns.create',
        // ])->name('admin.campaigns.create');

        // Route::post('campaigns/create', 'Ecommvu\Marketing\Http\Controllers\CampaignController@store')->defaults('_config', [
        //     'redirect' => 'admin.campaigns.index',
        // ])->name('admin.campaigns.store');
    });
});
