<?php

Route::group([
        'prefix'        => 'admin/subject',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('/', 'Sanskriti\Subject\Http\Controllers\Admin\SubjectController@index')->defaults('_config', [
            'view' => 'subject::admin.index',
        ])->name('admin.subject.index');

        Route::get('create', 'Sanskriti\Subject\Http\Controllers\Admin\SubjectController@index')->defaults('_config', [
            'view' => 'subject::admin.index',
        ])->name('admin.subject.index');

        Route::get('store', 'Sanskriti\Subject\Http\Controllers\Admin\SubjectController@index')->defaults('_config', [
            'view' => 'subject::admin.index',
        ])->name('admin.subject.index');

        Route::get('edit', 'Sanskriti\Subject\Http\Controllers\Admin\SubjectController@edit')->defaults('_config', [
            'view' => 'subject::admin.edit',
        ])->name('admin.subject.edit');

        Route::post('update', 'Sanskriti\Subject\Http\Controllers\Admin\SubjectController@update')->defaults('_config', [
            'redirect' => 'admin.subject.edit',
        ])->name('admin.subject.index');

        Route::post('delete', 'Sanskriti\Subject\Http\Controllers\Admin\SubjectController@destroy')->defaults('_config', [
            'redirect' => 'admin.subject.index',
        ])->name('admin.subject.destroy');
});