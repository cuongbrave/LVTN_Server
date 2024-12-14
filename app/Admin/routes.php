<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\UserController;
use App\Admin\Controllers\CourseTypeController;
use App\Admin\Controllers\CourseController;
use App\Admin\Controllers\ModuleController;
use App\Admin\Controllers\TestController;
use App\Admin\Controllers\PainterController;
use App\Admin\Controllers\PaintingController;
use App\Admin\Controllers\QuestionController;
use App\Admin\Controllers\ChoiceController;
use App\Admin\Controllers\UserTestController;





Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('/users', UserController::class);

    $router->resource('/course-types', CourseTypeController::class);
    $router->resource('/courses', CourseController::class);
    $router->resource('/modules', ModuleController::class);
    $router->resource('/tests', TestController::class);
    Route::get('/tests/{id}/qrcode', [TestController::class, 'generateQrCode'])->name('tests.qrcode');
    $router->get('/tests/{id}/qrcode/download', [TestController::class, 'downloadQrCode'])->name('tests.qrcode.download');
    // Route::get('tests/{id}/qrcode', [TestController::class, 'generateQrCode'])->name('admin.tests.qrcode.show');
    // Route::get('tests/{id}/qrcode/download', [TestController::class, 'downloadQrCode'])->name('admin.tests.qrcode.download');



    $router->resource('/painters', PainterController::class);
    $router->resource('/paintings', PaintingController::class);
    $router->resource('/questions', QuestionController::class);
    $router->resource('/choices', ChoiceController::class);
    $router->resource('/user-test', UserTestController::class);







});
