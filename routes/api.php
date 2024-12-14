<?php


use App\Http\Controllers\Api\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\UserController;

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

// Route::post('/auth/register', [UserController::class, 'createUser']);
// Route::post('/auth/login', [UserController::class, 'loginUser']);

Route::group(['namespace' => 'Api'], function () {


    Route::post('/login', 'UserController@login');
    // Route::post('/login', [UserController::class, 'login']);


    //authentication middleware
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::any('/courseList', 'CourseController@courseList');
        Route::any('/courseDetail', 'CourseController@courseDetail');
        Route::any('/testList', 'TestController@testList');
        Route::any('/testDetail', 'TestController@testDetail');
        Route::any('/questionList', 'QuestionController@questionList');
        Route::any('/answerList', 'ChoiceController@answerList');
        Route::any('/submitTest', 'TestResultController@store');
        Route::any('/testExist', 'TestExistController@testExist');
        Route::any('/testSearch', 'TestController@testSearch');
        Route::any('/testSearchDefault', 'TestController@testSearchDefault');

    });
});

// Route::post('/login', [UserController::class, 'login']);


