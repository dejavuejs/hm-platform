<?php

Route::group([
        'prefix'     => 'student',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'Sanskriti\Student\Http\Controllers\Shop\StudentController@index')->defaults('_config', [
            'view' => 'student::shop.index',
        ])->name('shop.student.index');

});