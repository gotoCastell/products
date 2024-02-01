<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Products
Route::group(['prefix' => 'products', 'as' => 'products'], function () {
    Route::get('/', [App\Http\Controllers\Models\ProductController::class, 'index']);
    Route::get('/create-edit', [App\Http\Controllers\Models\ProductController::class, 'create'])->name('.create-edit');
    Route::post('/store', [App\Http\Controllers\Models\ProductController::class, 'store'])->name('.store');
    Route::get('/delete', [App\Http\Controllers\Models\ProductController::class, 'delete'])->name('.delete');
    Route::get('/details', [App\Http\Controllers\Models\ProductController::class, 'details'])->name('.details');
    Route::get('/resource/delete', [App\Http\Controllers\Models\ProductController::class, 'deleteResource'])->name('.resource.delete');
});



Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='60%'><h4>Corresponding Action</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='10%'><h4>Middleware</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td style='border-bottom: 1px solid #b9b9b9'>" . str_replace(
            'App\\Http\\Controllers\\',
            '',
            $value->getActionName()
        ) . "</td>";
        echo "<td style='border-bottom: 1px solid #b9b9b9'>" . $value->uri() . "</td>";
        echo "<td style='border-bottom: 1px solid #b9b9b9'>" . $value->methods()[0] . "</td>";
        echo "<td style='border-bottom: 1px solid #b9b9b9'>" . $value->getName() . "</td>";
        echo "<td style='border-bottom: 1px solid #b9b9b9'>" . implode(", ", $value->middleware()) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});
