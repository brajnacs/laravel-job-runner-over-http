<?php
Route::group(['namespace' => '\BrajMohan\LaravelJobRunnerOverHttp\Controllers'], function () {
    Route::post('/job-runner', 'JobRequestController@fireJob');
});
