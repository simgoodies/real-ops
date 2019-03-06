<?php

Route::get('/', ['uses' => 'PageController@landing']);
Route::get('contact', ['uses' => 'PageController@contact', 'as' => 'core.pages.contact']);
Route::get('apply', ['uses' => 'PageController@application', 'as' => 'core.pages.application']);
