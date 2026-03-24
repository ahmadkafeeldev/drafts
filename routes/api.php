<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FoodCategoryController;
use App\Http\Controllers\Api\MainController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1/auth'], function(){    
    Route::controller(AuthController::class)->group(function(){
        Route::post('signup', 'signup');
        Route::post('login', 'login');
        Route::get('user-data', 'user_data');
        Route::get('forgot-password/{email}', 'forgot_password');
        Route::post('reset-password', 'reset_password');
        Route::post('change-password', 'change_password');
        Route::post('update-profile', 'update_profile');
        Route::get('delete-account', 'delete_account');
        Route::get('logout', 'logout');
        // Route::post('login-with-facebook', 'login_with_facebook');
        // Route::post('login-with-google', 'login_with_google');
        // Route::post('login-with-apple', 'login_with_apple');
        // Route::post('verify-phone', 'verify_phone');
    });             
});

Route::group(['prefix' => 'v1/app'], function(){    
    Route::get('categories', [CategoryController::class, 'index']);      
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::get('food-categories', [FoodCategoryController::class, 'index']);      
    Route::get('food-category/{id}/courses', [FoodCategoryController::class, 'foodCourses']);      
    Route::get('food-category/{id}/popular-courses', [FoodCategoryController::class, 'popularCourses']);      
    Route::get('course/{id}', [FoodCategoryController::class, 'viewCourse']);      
    Route::get('view-tip/{id}', [CategoryController::class, 'viewTip']); 
    
    Route::get('recipes', [FoodCategoryController::class, 'recipes']);      
    Route::get('recipe_details/{id}', [FoodCategoryController::class, 'recipe_details']); 

});
