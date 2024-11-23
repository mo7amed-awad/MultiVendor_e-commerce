<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware'=>['auth','verified'],
    'as'=>'dashboard.',
    'prefix'=>'dashboard'
], function(){

    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/categories/trash',[CategoriesController::class,'trash'])->name('categories_trash');
    Route::put('/categories/{category}/restore',[CategoriesController::class,'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete',[CategoriesController::class,'forceDelete'])->name('categories.force-delete');
    Route::resource('/categories',CategoriesController::class)->names([
        'index'=>'categories.index'
    ]);
}
);
