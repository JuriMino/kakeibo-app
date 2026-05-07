<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    // 未ログインならログイン画面へ、ログイン済みなら支出一覧へ
    return Auth::check() ? redirect()->route('expenses.index') : redirect()->route('login');
});

// ログイン済みユーザーのみアクセスできるルート
Route::middleware(['auth', 'verified'])->group(function(){

    // Breezeのダッシュボード
    Route::get('/dashboard', function(){
        return view('dashboard');
    })->name('dashboard');

    // 家計簿（CRUD）一括設定
    Route::resource('expenses', ExpenseController::class)->except('show');

    // Breezeのプロフィールそのまま
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
