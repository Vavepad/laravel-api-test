<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// create project
Route::post('project',       [ProjectController::class, 'store'])->name('project.store');
// connect users to project
Route::post('project/addusers',       [ProjectController::class, 'addUsers'])->name('project.addusers');
Route::get('project/show/{searchName}/{searchValue}',       [ProjectController::class, 'show'])->name('project.show');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
