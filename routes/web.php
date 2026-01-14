<?php 
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CarControllers;
use App\Http\Controllers\BrandControllers;
use App\Http\Controllers\OwnerControllers;



Route::get('/', function () {
    return Auth::check() ? redirect('/home') : redirect('/login');
});

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
    
    Route::get('/cars/data', [CarControllers::class, 'getDatatable'])->name('cars.data');
    Route::post('/cars/update', [CarControllers::class, 'update'])->name('cars.update');
    Route::post('/cars/destroy', [CarControllers::class, 'destroy'])->name('cars.destroy');
    Route::resource('/cars', CarControllers::class);
    
    Route::get('/brands/data', [BrandControllers::class, 'getDatatable'])->name('brands.data');
    Route::post('/brands/update', [BrandControllers::class, 'update'])->name('brands.update');
    Route::post('/brands/destroy', [BrandControllers::class, 'destroy'])->name('brands.destroy');
    Route::resource('/brands', BrandControllers::class);
    
    Route::get('/owners/data', [OwnerControllers::class, 'getDatatable'])->name('owners.data');
    Route::post('/owners/update', [OwnerControllers::class, 'update'])->name('owners.update');
    Route::post('/owners/destroy', [OwnerControllers::class, 'destroy'])->name('owners.destroy');
    Route::resource('/owners', OwnerControllers::class);




});

