<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Storage;

Route::get('/', [HomeController::class, "index"]);

Route::prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'Index']);
    Route::get('/restaurant', [AdminController::class, 'Restaurant']);
    Route::post('/restaurant/getData', [AdminController::class, 'getDataTableDataRestaurant']);
    Route::get("/restaurant/add_edit/{id}", [AdminController::class, 'AddEditRestaurant']);
    Route::post("/restaurant/save", [AdminController::class, 'SaveRestaurant']);
    Route::get("/restaurant/delete/{id}", [AdminController::class, 'DeleteRestaurant']);

    Route::get("/meal", [AdminController::class, 'Meal']);
    Route::post('/meal/getData', [AdminController::class, 'getDataTableDataMeal']);
    Route::get("/meal/add_edit/{id}", [AdminController::class, 'AddEditMeal']);
    Route::post("/meal/save", [AdminController::class, 'SaveMeal']);
    Route::get("/meal/delete/{id}", [AdminController::class, 'DeleteMeal']);

    Route::get("/dish", [AdminController::class, 'Dish']);
    Route::post('/dish/getData', [AdminController::class, 'getDataTableDataDish']);
    Route::get("/dish/add_edit/{id}", [AdminController::class, 'AddEditDish']);
    Route::post("/dish/save", [AdminController::class, 'SaveDish']);
    Route::get("/dish/delete/{id}", [AdminController::class, 'DeleteDish']);

    Route::post("/saveData",[AdminController::class, 'SaveData']);
    Route::get("/data",[AdminController::class, 'DataDish']);

    Route::get("/downloadData",function (){

        $filePath = 'data.json';

        $fileContents = Storage::disk('local')->get($filePath);

        return response($fileContents)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', 'attachment; filename="data.json"');
    });


});
