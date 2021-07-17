<?php

Route::group([
        'prefix'        => 'admin/classes',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('/', 'Sanskriti\Classes\Http\Controllers\Admin\ClassesController@index')->defaults('_config', [
            'view' => 'classes::admin.index',
        ])->name('admin.classes.index');

        Route::get('create', 'Sanskriti\Classes\Http\Controllers\Admin\ClassesController@index')->defaults('_config', [
            'view' => 'classes::admin.index',
        ])->name('admin.classes.index');

        Route::get('store', 'Sanskriti\Classes\Http\Controllers\Admin\ClassesController@index')->defaults('_config', [
            'view' => 'classes::admin.index',
        ])->name('admin.classes.index');

        Route::get('edit', 'Sanskriti\Classes\Http\Controllers\Admin\ClassesController@edit')->defaults('_config', [
            'view' => 'classes::admin.edit',
        ])->name('admin.classes.edit');

        Route::post('update', 'Sanskriti\Classes\Http\Controllers\Admin\ClassesController@update')->defaults('_config', [
            'redirect' => 'admin.classes.edit',
        ])->name('admin.classes.index');

        Route::post('delete', 'Sanskriti\Classes\Http\Controllers\Admin\ClassesController@destroy')->defaults('_config', [
            'redirect' => 'admin.classes.index',
        ])->name('admin.classes.destroy');
});