<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix("order")->controller(OrderController::class)->group(function (){
      Route::get('/', 'index');
      Route::get('show/{order}', 'show');
      Route::post('store', 'store');
      Route::get('history/{user}', 'history');
      Route::match(['put' , "patch"],'cancelled/{order}', 'cancelled');
});

