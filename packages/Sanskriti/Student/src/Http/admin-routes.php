<?php

Route::group([
        'prefix'        => 'admin/student',
        'middleware'    => ['web', 'admin']
    ], function () {
        Route::get('/', 'Sanskriti\Student\Http\Controllers\Admin\StudentController@index')->defaults('_config', [
            'view' => 'student::admin.index',
        ])->name('admin.student.index');

        Route::get('create', 'Sanskriti\Student\Http\Controllers\Admin\StudentController@create')->defaults('_config', [
            'view' => 'student::admin.index',
        ])->name('admin.student.create');

        Route::get('store', 'Sanskriti\Student\Http\Controllers\Admin\StudentController@store')->defaults('_config', [
            'view' => 'student::admin.index',
        ])->name('admin.student.store');

        Route::get('edit', 'Sanskriti\Student\Http\Controllers\Admin\StudentController@edit')->defaults('_config', [
            'view' => 'student::admin.edit',
        ])->name('admin.student.edit');

        Route::post('update', 'Sanskriti\Student\Http\Controllers\Admin\StudentController@update')->defaults('_config', [
            'redirect' => 'admin.student.edit',
        ])->name('admin.student.update');

        Route::post('delete', 'Sanskriti\Student\Http\Controllers\Admin\StudentController@destroy')->defaults('_config', [
            'redirect' => 'admin.student.index',
        ])->name('admin.student.destroy');
});