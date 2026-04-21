<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Manager;

// Route::get('/', function () {
//     return view('welcome');
// });
 Route::get('/',Manager::class);