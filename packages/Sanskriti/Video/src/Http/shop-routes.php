<?php

Route::group([
        'prefix'     => 'video',
        'middleware' => ['web', 'theme', 'locale', 'currency']
    ], function () {

        Route::get('/', 'Sanskriti\Video\Http\Controllers\Shop\VideoController@index')->defaults('_config', [
            'view' => 'video::shop.index',
        ])->name('shop.video.index');

});