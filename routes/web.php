<?php

use App\Http\Controllers\Admin\TasksController;
use App\Models\Task;
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
    $tasks = Task::orderByDesc('id')->get();
    return view('index', compact('tasks'));
})->name('index');

Route::resource('admin/tasks', TasksController::class);
