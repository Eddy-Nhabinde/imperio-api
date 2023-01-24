<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

route::post('saveuser', UserController::class . '@store');

route::group(['middleware' => ['apijwt']], function () {

    route::get('users', UserController::class . '@index');

    Route::post('logout', AuthController::class . '@logout');

    route::put('updateProduct/{id}', ProdutoController::class . '@update');
});
route::post('saveProduct', ProdutoController::class . '@SaveProduct');

route::post('updateProductPicture/{id}', ProdutoController::class . '@updatePicture');

Route::post('passwordRequest', AuthController::class . '@requestPassword');

Route::post('login', AuthController::class . '@login');
Route::post('refresh', AuthController::class . '@refresh');
Route::post('me', AuthController::class . '@me');
