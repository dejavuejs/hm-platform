<?php

Route::group([
        'prefix'     => 'subject',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'Sanskriti\Subject\Http\Controllers\Shop\SubjectController@index')->defaults('_config', [
            'view' => 'subject::shop.index',
        ])->name('shop.subject.index');

});