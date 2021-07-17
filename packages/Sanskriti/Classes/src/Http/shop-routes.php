<?php

Route::group([
        'prefix'     => 'classes',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'Sanskriti\Classes\Http\Controllers\Shop\ClassesController@index')->defaults('_config', [
            'view' => 'classes::shop.index',
        ])->name('shop.classes.index');

});