<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Phone;
use Inertia\Inertia;
use App\Http\Controllers\CategoryWebController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
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
});
