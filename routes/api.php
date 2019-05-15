<?php

use Illuminate\Support\Facades\Route;

Route::post('fingerprint', 'Api\NemesisController@saveFingerprint');
