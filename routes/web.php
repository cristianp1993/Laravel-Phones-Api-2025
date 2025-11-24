<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Phone;
use Inertia\Inertia;
use App\Http\Controllers\CategoryWebController;
use App\Http\Controllers\PhoneWebController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $totalPhones = Phone::count();
        $totalCategories = Category::count();

        $topCategories = Category::query()
            ->withCount('phones')
            ->orderByDesc('phones_count')
            ->take(4)
            ->get(['id', 'name']);

        return Inertia::render('Dashboard', [
            'stats' => [
                'totalPhones' => $totalPhones,
                'totalCategories' => $totalCategories,
            ],
            'topCategories' => $topCategories,
        ]);
    })->name('dashboard');

    Route::get('/categories', [CategoryWebController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryWebController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryWebController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryWebController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryWebController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryWebController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryWebController::class, 'destroy'])->name('categories.destroy');

    Route::get('/phones', [PhoneWebController::class, 'index'])->name('phones.index');
    Route::get('/phones/create', [PhoneWebController::class, 'create'])->name('phones.create');
    Route::post('/phones', [PhoneWebController::class, 'store'])->name('phones.store');
    Route::get('/phones/{phone}', [PhoneWebController::class, 'show'])->name('phones.show');
    Route::get('/phones/{phone}/edit', [PhoneWebController::class, 'edit'])->name('phones.edit');
    Route::put('/phones/{phone}', [PhoneWebController::class, 'update'])->name('phones.update');
    Route::delete('/phones/{phone}', [PhoneWebController::class, 'destroy'])->name('phones.destroy');
});
