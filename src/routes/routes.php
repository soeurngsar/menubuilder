<?php

use Illuminate\Support\Facades\Route;
use SoeurngSar\MenuBuilder\app\Http\Controllers\MenuController;

Route::prefix(config('backpack.base.route_prefix', 'admin'))->middleware(
    array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    )
)->group(function () {
    Route::get('menu-builder', [MenuController::class, 'index'])->name('menu-builder');
    Route::post('addcustommenu', [MenuController::class, 'addcustommenu'])->name('haddcustommenu');
    Route::post('deleteitemmenu', [MenuController::class, 'deleteitemmenu'])->name('hdeleteitemmenu');
    Route::post('deletemenug', [MenuController::class, 'deletemenug'])->name('hdeletemenug');
    Route::post('createnewmenu', [MenuController::class, 'createnewmenu'])->name('hcreatenewmenu');
    Route::post('generatemenucontrol', [MenuController::class, 'generatemenucontrol'])->name('hgeneratemenucontrol');
    Route::post('updateitem', [MenuController::class, 'updateitem'])->name('hupdateitem');
});
