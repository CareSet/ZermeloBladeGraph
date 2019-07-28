<?php

Route::get( '/{report_key}/{parameters?}', 'GraphController@show' )->where(['parameters' => '.*']);
