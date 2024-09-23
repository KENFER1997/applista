<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\ListaTareaController;

// Rutas para registrar usuarios
Route::get('/usuarios/registrousuario', [UserController::class, 'create'])->name('usuarios.registrousuario');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');

// Rutas para autenticación (login y logout)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post'); // Asegúrate de que este nombre coincide en LoginController
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Ruta raíz para la página principal
Route::get('/', function () {
  return redirect()->route('login'); // Redirige a la página de inicio de sesión
});

// Rutas de gestión de usuarios (acceso solo para usuarios autenticados)
Route::middleware(['auth'])->group(function () {
  // Rutas para listas
  Route::get('/listas', [ListaTareaController::class, 'index'])->name('listas.index');
  Route::get('/listas/create', [ListaTareaController::class, 'create'])->name('listas.create');
  Route::post('/listas', [ListaTareaController::class, 'store'])->name('listas.store');
  Route::get('/listas/{id}', [ListaTareaController::class, 'show'])->name('listas.show');
  Route::resource('listas', ListaTareaController::class);
  Route::delete('/listas/{id}', [ListaTareaController::class, 'destroy'])->name('listas.destroy');

  // Rutas para tareas
  Route::get('/tareas', [TareaController::class, 'index'])->name('tareas.index');
  Route::get('/tareas/create', [TareaController::class, 'create'])->name('tareas.create');
  Route::post('/tareas', [TareaController::class, 'store'])->name('tareas.store');
  Route::patch('/tareas/{id}', [TareaController::class, 'update'])->name('tareas.update');
  Route::delete('/tareas/{id}', [TareaController::class, 'destroy'])->name('tareas.destroy');
});
