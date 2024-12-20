<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;



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
Route::get('/items/{item_id}/detail.json', [ItemController::class, 'getItemDetail']);




Route::get('/search.json', [ItemController::class, 'searchJson'])->name('search.json');
Route::get('/recommend-items.json', [ItemController::class, 'getRecommendItems'])->name('recommend-items.json');




Route::get('/check-auth', function () {
    return response()->json(['authenticated' => Auth::check()]);
});

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/mypage', [UsersController::class, 'mypage'])->name('user.mypage');
    Route::get('/mypage/profile/edit', [UsersController::class, 'editProfile'])->name('mypage.profile.edit');
    Route::post('/mypage/profile/update', [UsersController::class, 'updateProfile'])->name('mypage.profile.update');
    Route::post('/items/{item}/toggle-like', [ItemController::class, 'toggleLike'])->name('item.toggleLike');
    Route::get('/items/{item}/like-status', [ItemController::class, 'getLikeStatus']);
    Route::get('/mypage/recommend-items.json', [UsersController::class, 'getMypageItems']);
    Route::get('/items/{id}/comments', [ItemController::class, 'comments'])->name('items.comments.show');
    Route::post('/items/{id}/comments', [ItemController::class, 'storeComment'])->name('items.comments.store');
    Route::get('/sell', [ItemController::class, 'create'])->name('items.create');
    Route::post('/sell', [ItemController::class, 'store'])->name('items.store');






});




// テスト用ルート
Route::get('/test', function () {
    return view('address');
});