<?php

use App\Http\Controllers\api\admin\UserController;
use App\Http\Controllers\api\CityController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\BuslinesController;
use App\Http\Controllers\api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\api\TopicController;
use App\Http\Controllers\auth\UserAuthController;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTAuthController;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware([JwtMiddleware::class]);

// Event routes
Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::get('/cities', [EventController::class, 'getCities']);
    Route::get('/categories', [EventController::class, 'getCategories']);
    Route::get('/{id}', [EventController::class, 'show']);
    Route::middleware([JwtMiddleware::class])->post('/create', [EventController::class, 'store']);
});

// Topic routes
Route::prefix('topics')->group(function () {
    Route::get('', [TopicController::class, 'index']);
    Route::get('/categories', [TopicController::class, 'getCategories']);
    Route::get('/tabela', [TopicController::class, 'getTable']);
});

// Buslines routes
Route::prefix('buslines')->group(function () {
    Route::get('', [BuslinesController::class, 'index']);

    Route::middleware([JwtMiddleware::class])->group(function (): void {
        Route::get('list', [BuslinesController::class, 'getUserBuslines']);
        Route::post('save', [BuslinesController::class, 'store']);
        Route::get('list/{busline_id}', [BuslinesController::class, 'getUserBuslines']);
    });
});

// Products routes
Route::apiResource('products', ProductController::class);

// Product Categories routes
Route::apiResource('product-categories', ProductCategoryController::class);

// City routes
Route::get('general/cities', [CityController::class, 'index']);
Route::get('general/cities/{longitude}/{latitude}', [CityController::class, 'getCityByLongitudeAndLatitude']);

// Topic routes
Route::get('topic', [TopicController::class, 'index']);

// User authentication routes
Route::prefix('auth')->group(function () {
    Route::post('register', [JWTAuthController::class, 'register']);
    Route::post('login', [JWTAuthController::class, 'login']);
    Route::get('token', [JWTAuthController::class, 'validateToken']);
    Route::middleware([JwtMiddleware::class])->group(function () {
        Route::get('logout', [UserAuthController::class, 'logout']);
        Route::get('user', [UserAuthController::class, 'getUser']);
        Route::post('user', [UserAuthController::class, 'updateUser']);
        Route::get('user/business', [UserAuthController::class, 'getBusiness']);
        Route::post('user/business', [BuslinesController::class, 'updateBusiness']);
    });
});

// Administration routes
Route::prefix('administration')->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('buslines', BuslinesController::class);
    Route::apiResource('events', EventController::class);

    Route::prefix('topics')->group(function () {
        Route::apiResource('', TopicController::class);
        Route::get('{id}', [TopicController::class, 'show']);
        Route::apiResource('categories', TopicController::class);
    });

    Route::prefix('products')->group(function () {
        Route::get('', [ProductController::class, 'index']);
        Route::post('', [ProductController::class, 'store']);
        Route::get('single/{id}', [ProductController::class, 'show']);
        Route::put('{id}', [ProductController::class, 'update']);
        Route::delete('{id}', [ProductController::class, 'destroy']);

        Route::prefix('categories')->group(function () {
            Route::get('', [ProductCategoryController::class, 'index']);
            Route::post('', [ProductCategoryController::class, 'store']);
            Route::get('{id}', [ProductCategoryController::class, 'show']);
            Route::put('{id}', [ProductCategoryController::class, 'update']);
            Route::delete('{id}', [ProductCategoryController::class, 'destroy']);
        });
    });

    Route::apiResource('cities', CityController::class);
});

