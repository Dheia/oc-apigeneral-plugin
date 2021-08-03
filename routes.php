<?php

Route::prefix('api/v1')
    // ->namespace('SprintSoft\ApiGeneral')
    ->middleware('api')
    ->name('apigeneral.')
    ->group(
        function () {
            Route::get('pages', 'SprintSoft\ApiGeneral\Controllers\Api\Pages@index')->name('pages');
            Route::get('pages/{url}', 'SprintSoft\ApiGeneral\Controllers\Api\Pages@getPage')->name('page.get');
            Route::get('search', 'SprintSoft\ApiGeneral\Controllers\Api\Search@index')->name('search');
});


