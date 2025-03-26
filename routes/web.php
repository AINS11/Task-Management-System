<?php

use App\Http\Controllers\AuthenticateUser;
use App\Http\Controllers\TasksController;
use App\Models\Task;
use Illuminate\Support\Facades\Route;

Route::middleware([\App\Http\Middleware\JwtCookieMiddleware::class])->group(function () {

    Route::get('/', function () {
        $tasks = Task::paginate(5);
        return view('dashbaord', ['tasks' => $tasks ,'status'=>'all']); // Pass tasks to the view
    });

    Route::get('/tasks/{id}/edit', [TasksController::class, 'editTask'])->name('tasks.edit');

    Route::put('/tasks/{id}', [TasksController::class, 'updateTask'])->name('tasks.update');

    Route::get('/tasksfilter', [TasksController::class, 'filterTasks'])->name('tasks.filter'); 

    Route::post('/tasks',[TasksController::class, 'addTask'])->name('tasks.add');

    Route::delete('/tasks/{id}',[TasksController::class, 'deleteTask'])->name('tasks.delete');

    Route::patch('/tasks/{id}',[TasksController::class, 'changeStatus'])->name('tasks.delete');

    Route::post('/logout', [AuthenticateUser::class, 'logoutSubmit'])->name('logout');
});

Route::get('/login', function () {
    return view('Authenticate.login');
});

Route::get('/register', function () {
    return view('Authenticate.register');
});

Route::post('/login', [AuthenticateUser::class, 'loginSubmit'])->name('login');

Route::post('/register', [AuthenticateUser::class, 'registerubmit'])->name('register');
