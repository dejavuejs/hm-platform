<?php

Route::group(['middleware' => ['web', 'auth:admin']], function () {
    Route::prefix('admin')->group(function () {
        Route::get('company/domain', 'Ecommvu\DNS\Http\Controllers\DNSController@index')->defaults('_config', [
            'view' => 'dns::index'
        ])->middleware('can:view-dns')->name('company.domain.index');

        Route::post('company/domain', 'Ecommvu\DNS\Http\Controllers\DNSController@store')->defaults('_config', [
            'redirect' => 'company.domain.index'
        ])->name('company.domain.store');
    });
});