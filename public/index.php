<?php
session_start();



require_once ('../core/BaseController.php');
require_once '../core/Router.php';
require_once '../core/Route.php';
require_once '../app/controllers/HomeController.php';
require_once '../app/controllers/AuthController.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/ClientController.php';
require_once '../app/config/db.php';



$router = new Router();
Route::setRouter($router);



// Define routes 
// auth routes 
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'handleRegister']);
Route::get('/login', [AuthController::class, 'showleLogin']);
Route::post('/login', [AuthController::class, 'handleLogin']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/', [AuthController::class, 'home']);//Must add Prt for pranciple page

// admin routers

Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/users', [AdminController::class, 'handleUsers']);
Route::get('/admin/categories', [AdminController::class, 'categories']);
Route::get('/admin/testimonials', [AdminController::class, 'testimonials']);
Route::get('/admin/projects', [AdminController::class, 'projects']);
Route::post('/remove-user', [AdminController::class, 'removeUser']); //Delete user
Route::post('/statu-user', [AdminController::class, 'statuUser']); //Chnage status user
Route::get('/admin/categories', [AdminController::class, 'getAllCategories']); //getAllCategories
Route::post('/remove/cat-subcat', [AdminController::class, 'removeCatAndSubcat']); //delete cat or sub
Route::post('/add-modify-category', [AdminController::class, 'addModifyCategory']); //add and mofifier category
Route::post('/add-modify-subcategory', [AdminController::class, 'addModifySubcategory']); //add and mofifier subcategory
Route::get('/admin/projects', [AdminController::class, 'getProjets']); //get Projects by felters
Route::post('/admin/projects', [AdminController::class, 'removeProjet']); //delete Projects 
Route::get('/admin/testimonials', [AdminController::class, 'getAllTestimonials']);//get all testimonials
Route::post('/remove-testimonial', [AdminController::class, 'removeTestimonial']);//get all testimonials


//client routers

Route::get('/client/dashboard', [ClientController::class, 'index']);
Route::get('/client/testimonials', [ClientController::class, 'testimonials']);
Route::get('/client/offers', [ClientController::class, 'offers']);
Route::get('/client/projects', [ClientController::class, 'projects']);


// end admin routes 

// client Routes 
// Route::get('/client/dashboard', [ClientController::class, 'index']);



// Dispatch the request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);



