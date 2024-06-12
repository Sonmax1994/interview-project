<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthenticateMiddleware;
use Illuminate\Auth\Middleware\Authenticate;
use App\Http\Controllers\Admin\LoginRegisterController;
use App\Http\Controllers\Admin\FruitCategoryController;
use App\Http\Controllers\Admin\FruitItemController;
use App\Http\Controllers\Admin\InvoiceController;

Route::prefix('admin')->group(function () {
    Route::controller(LoginRegisterController::class)->group(function() {
        Route::get('/login', 'login')->name('login');
        Route::post('/authenticate', 'authenticate')->name('authenticate');
        Route::post('/logout', 'logout')->name('logout');
        
        Route::middleware([Authenticate::class])->group(function () {
            Route::get('/dashboard', 'dashboard')->name('dashboard');

            Route::prefix('fruit-category')->group(function () {
                Route::controller(FruitCategoryController::class)->group(function() {
                    Route::get('/', 'index')->name('fruit_category');
                    Route::get('/create', 'create')->name('fruit_category.create');
                    Route::post('/store', 'store')->name('fruit_category.store');
                    Route::get('/show/{id}', 'show')->name('fruit_category.show');
                    Route::put('/edit/{id}', 'edit')->name('fruit_category.edit');
                    Route::delete('/delete/{id}', 'delete')->name('fruit_category.delete');
                });
            });

            Route::prefix('fruit-item')->group(function () {
                Route::controller(FruitItemController::class)->group(function() {
                    Route::get('/', 'index')->name('fruit_item');
                    Route::get('/create', 'create')->name('fruit_item.create');
                    Route::post('/store', 'store')->name('fruit_item.store');
                    Route::get('/show/{id}', 'show')->name('fruit_item.show');
                    Route::put('/edit/{id}', 'edit')->name('fruit_item.edit');
                    Route::delete('/delete/{id}', 'delete')->name('fruit_item.delete');
                    
                    Route::post('get-items', 'getItemsByCategoryId')
                        ->name('fruit_item.getItemsByCategoryId')
                        ->withoutMiddleware([Authenticate::class]);
                    Route::post('get-item-detail', 'getDetailFruitItem')
                        ->name('fruit_item.detail_item')
                        ->withoutMiddleware([Authenticate::class]);
                });
            });

            Route::prefix('invoice')->group(function () {
                Route::controller(InvoiceController::class)->group(function() {
                    Route::get('/', 'index')->name('invoice');
                    Route::get('/create', 'create')->name('invoice.create');
                    Route::post('/store', 'store')->name('invoice.store');
                    Route::get('/show/{id}', 'show')->name('invoice.show');
                    Route::put('/edit/{id}', 'edit')->name('invoice.edit');
                    Route::delete('/delete/{id}', 'delete')->name('invoice.delete');
                    Route::post('/export-file', 'exportFile')->name('invoice.exportFile');
                    Route::get('/file-pdf-invoice/{id}', 'filePdfInvoice')->name('invoice.filePdfInvoice');
                });
            });

        });
        
    });
});

