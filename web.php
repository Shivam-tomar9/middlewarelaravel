<?php

use App\Http\Controllers\AuthController;
use App\Http\Middleware\Authenticate;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
// use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;


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
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
Route::get('/registeration', [AuthController::class, 'view'])->name('registeration');
Route::post('/save', [AuthController::class, 'save'])->name('save');
Route::get('/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware(['web'])->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'submitLogin'])->name('submit_login');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dash', [AuthController::class, 'dash'])->name('dash');
        Route::get('user/create', [UserController::class, 'create'])->name('create');
        Route::post('user/store', [UserController::class, 'store'])->name('store');
        Route::get('user/index', [UserController::class, 'index'])->name('index');
        Route::get('user/edit/{id}',[UserController::class,'edit'])->name('edit');
        Route::get('user/delete/{id}',[UserController::class,'destroy'])->name('delete');
        Route::post('user/update/{id}', [UserController::class, 'update'])->name('update');
        // Route::resource('users',UserController::class);
        Route::get('/create/category',[CategoryController::class,'createcategory'])->name('create.category');
        Route::post('/store/category',[CategoryController::class,'storecategory'])->name('store.category');
        Route::get('/index/category',[CategoryController::class,'indexcategory'])->name('index.category');
        Route::get('/view/category',[CategoryController::class,'viewList'])->name('view.category');
        Route::get('/delete/category/{id}',[CategoryController::class,'deletecategory'])->name('delete.category');
        Route::get('/edit/category/{id}',[CategoryController::class,'viewList'])->name('edit.category');


    });
});
