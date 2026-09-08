<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{PortfolioController,AuthController,AdminController};
Route::get('/',[PortfolioController::class,'home']);
Route::get('/projects/{project}',[PortfolioController::class,'project']);
Route::post('/contact',[PortfolioController::class,'contact'])->middleware('throttle:5,1');
Route::view('/login','auth.login')->name('login')->middleware('guest');
Route::post('/login',[AuthController::class,'login'])->middleware('throttle:10,1');
Route::post('/logout',[AuthController::class,'logout'])->middleware('auth');
Route::prefix('admin')->middleware(['auth','admin'])->group(function(){
Route::get('/',[AdminController::class,'dashboard']);
Route::get('/settings',[AdminController::class,'settings']);Route::post('/settings',[AdminController::class,'saveSettings']);
Route::get('/inquiries',[AdminController::class,'inquiries']);Route::patch('/inquiries/{inquiry}',[AdminController::class,'status']);
Route::get('/{type}',[AdminController::class,'index'])->whereIn('type',['services','projects']);
Route::get('/{type}/create',[AdminController::class,'edit'])->whereIn('type',['services','projects']);
Route::get('/{type}/{id}/edit',[AdminController::class,'edit'])->whereIn('type',['services','projects'])->whereNumber('id');
Route::post('/{type}',[AdminController::class,'save'])->whereIn('type',['services','projects']);
Route::put('/{type}/{id}',[AdminController::class,'save'])->whereIn('type',['services','projects'])->whereNumber('id');
Route::delete('/{type}/{id}',[AdminController::class,'delete'])->whereIn('type',['services','projects'])->whereNumber('id');
});
