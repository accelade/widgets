<?php

use Accelade\Widgets\Http\Controllers\DocsController;
use Illuminate\Support\Facades\Route;

Route::get('/demo/{framework?}', [DocsController::class, 'demo'])->name('widgets.demo');
Route::get('/docs/{section?}', [DocsController::class, 'docs'])->name('widgets.docs');
