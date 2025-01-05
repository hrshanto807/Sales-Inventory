<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TokenVerificationMiddleware;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use GuzzleHttp\Middleware;


// Route::get('/', function () {
//     return view('welcome');
// });


// Web API Routes
Route::post("/user-registration", [App\Http\Controllers\UserController::class, "UserRegistration"]);
Route::post("/user-login", [App\Http\Controllers\UserController::class, "UserLogin"]);
Route::post("/send-otp", [App\Http\Controllers\UserController::class, "SendOTPCode"]);
Route::post("/verify-otp", [App\Http\Controllers\UserController::class, "VerifyOTP"]);

Route::post("/reset-password", [App\Http\Controllers\UserController::class, "ResetPassword"])->middleware(TokenVerificationMiddleware::class);
Route::get('/user-profile',[UserController::class,'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class,'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);


// User Logout

Route::get("/user-logout", [App\Http\Controllers\UserController::class, "UserLogout"]);

// api routes
Route::get('/userLogin',[UserController::class,'LoginPage']);
Route::get('/userRegistration',[UserController::class,'RegistrationPage']);
Route::get('/sendOtp',[UserController::class,'SendOtpPage']);
Route::get('/verifyOtp',[UserController::class,'VerifyOTPPage']);
Route::get('/resetPassword',[UserController::class,'ResetPasswordPage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/dashboard',[DashboardController::class,'DashboardPage'])->middleware(TokenVerificationMiddleware::class);
Route::get('/userProfile',[UserController::class,'ProfilePage'])->middleware(TokenVerificationMiddleware::class);

// category routes
Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware(TokenVerificationMiddleware::class);


// Category API
// group middleware
Route::group(['middleware' => [TokenVerificationMiddleware::class]], function () {
    Route::get('/category-list',[CategoryController::class,'CategoryList']);
    Route::post('/category-create',[CategoryController::class,'CategoryCreate']);
    Route::post('/category-update',[CategoryController::class,'CategoryUpdate']);
    Route::post('/category-delete',[CategoryController::class,'CategoryDelete']);
    Route::post("/category-by-id",[CategoryController::class,'CategoryByID']);
});


// customer routes
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware(TokenVerificationMiddleware::class);


// Category API
// group middleware
Route::group(['middleware' => [TokenVerificationMiddleware::class]], function () {
    Route::get('/customer-list',[CustomerController::class,'CustomerList']);
    Route::post('/customer-create',[CustomerController::class,'CustomerCreate']);
    Route::post('/customer-update',[CustomerController::class,'CustomerUpdate']);
    Route::post('/customer-delete',[CustomerController::class,'CustomerDelete']);   
    Route::post('/customer-by-id',[CustomerController::class,'CustomerByID']);   
});

// Product routes
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware(TokenVerificationMiddleware::class);

// Product API
// group middleware
Route::group(['middleware' => [TokenVerificationMiddleware::class]], function () {
    Route::get("/product-list",[ProductController::class,'ProductList']);
    Route::post('/product-create',[ProductController::class,'ProductCreate']);
    Route::post('/product-update',[ProductController::class,'ProductUpdate']);
    Route::post('/product-delete',[ProductController::class,'ProductDelete']);   
    Route::post('/product-by-id',[ProductController::class,'ProductByID']);   
});




