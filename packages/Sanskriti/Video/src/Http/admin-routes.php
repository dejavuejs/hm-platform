<?php

Route::group([
        'prefix'        => 'admin/video',
        'middleware'    => ['web', 'admin']
    ], function () {

        Route::get('/', 'Sanskriti\Video\Http\Controllers\Admin\VideoController@index')->defaults('_config', [
            'view' => 'video::admin.index',
        ])->name('admin.video.index');

        Route::get('create', 'Sanskriti\Video\Http\Controllers\Admin\VideoController@index')->defaults('_config', [
            'view' => 'video::admin.index',
        ])->name('admin.video.index');

        Route::get('store', 'Sanskriti\Video\Http\Controllers\Admin\VideoController@index')->defaults('_config', [
            'view' => 'video::admin.index',
        ])->name('admin.video.index');

        Route::get('edit', 'Sanskriti\Video\Http\Controllers\Admin\VideoController@edit')->defaults('_config', [
            'view' => 'video::admin.edit',
        ])->name('admin.video.edit');

        Route::post('update', 'Sanskriti\Video\Http\Controllers\Admin\VideoController@update')->defaults('_config', [
            'redirect' => 'admin.video.edit',
        ])->name('admin.video.index');

        Route::post('delete', 'Sanskriti\Video\Http\Controllers\Admin\VideoController@destroy')->defaults('_config', [
            'redirect' => 'admin.video.index',
        ])->name('admin.video.destroy');

});