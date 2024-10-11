<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/app');
});
Route::get('/app/{any?}', [ \App\Http\Controllers\FrontendController::class, 'index']);
