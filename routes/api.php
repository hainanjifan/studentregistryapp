<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AuthController;

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

/* Using Laravel Passport 

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

*/

/* Not required due to existence of apiResource 

Route::get('students', [StudentController::class, 'index'])->name('students.index');
Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
Route::post('students', [StudentController::class, 'store'])->name('students.store');
Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

*/


//Register Route
Route::post('/register', [AuthController::class, 'register']);
//Login Route
Route::post('/login', [AuthController::class, 'login']);

//Middleware for Authentication purposes
Route::group(['middleware' => 'auth:api'], function() {
    
    //API Resource for Students (Index, Show, Update, Destroy)
    Route::apiResource('students', StudentController::class);

    // Add the route for uploading students
    Route::post('/upload-students', [StudentController::class, 'upload'])->name('students.upload');

    //Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.api');
});

/*
Route::group(['middleware' => ['web']], function () {
});
*/

//Search Route for Students
//Route::get('students/searchStudent', [StudentController::class, 'searchStudent'])->name('students.searchStudent');
