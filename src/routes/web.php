<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UsersController;


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

Route::get('/', [ItemController::class, ('index')])->name('item.index');
Route::get('/items/{item}', [ItemController::class, 'show'])->name('item.detail');



Route::get('/search.json', [ItemController::class, 'searchJson'])->name('search.json');

Route::get('/check-auth', function () {
    return response()->json(['authenticated' => Auth::check()]);
});

Route::middleware('auth')->group(function () {
    Route::get('/mypage/profile', [UsersController::class, 'editProfile'])->name('mypage.profile.edit');
    Route::post('/mypage/profile', [UsersController::class, 'updateProfile'])->name('mypage.profile.update');
    Route::post('/items/{item}/toggle-like', [ItemController::class, 'toggleLike'])->name('item.toggleLike');


});




// テスト用ルート
Route::get('/test', function () {
    return view('address');
});