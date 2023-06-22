<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::controller(CategoryController::class)->prefix('category')->name('category.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('get-data', 'getData')->name('getdata');
    Route::post('create', 'createData')->name('create');
    Route::post('{id}/update', 'updateData')->name('update');
    Route::delete('{id}/delete', 'deleteData')->name('delete');
});

Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('get-data', 'getData')->name('getdata');
    Route::post('create', 'createData')->name('create');
    Route::delete('{id}/delete', 'deleteData')->name('delete');
});
