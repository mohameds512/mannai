<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\usercrud\IndexComponent;
use App\Http\Livewire\usercrud\AddUserComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('crud',IndexComponent::class);

Route::get('storage/{path}', function ($path) {
    $path = storage_path('app/public/' . $path);
    abort_unless(file_exists($path) && is_file($path), 404);
    return response()->file($path);
})->where('path', '.*')->middleware('signed');

