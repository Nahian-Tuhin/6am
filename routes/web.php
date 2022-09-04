<?php


use App\Http\Controllers\UserControlller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

/*
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('dashboard', function () {
    return view('welcome');
})->name('dashboard');

Route::get('register', [AuthController::class, 'register_view'])->name('register');
Route::get('login', [AuthController::class, 'login_view'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login_post');



Route::middleware('auth')->group(function () {
    Route::get('user', [UserControlller::class, 'index'])->name('user.index');
    Route::post('update_role/{user}', [UserControlller::class, 'updateRole'])->name('user.role');
    Route::resource('product', ProductController::class);
});
