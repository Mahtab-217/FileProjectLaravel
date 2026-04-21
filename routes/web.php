<?php

use App\Http\Controllers\SongController;
use App\Models\Song;
use App\View\Components\SongMedia;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');

});
Route::resource('/songs',SongController::class);
// Route::get('song', SongMedia::class);
