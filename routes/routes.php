<?php

Route::controller('\Mate\Roles\Controllers\PermissionsController')
    ->middleware(['web', 'has-permissions:manage permissions'])
    ->group(function () {
        Route::get(config('roles.routes.permissions.url'), 'index')
            ->name(config('roles.routes.permissions.index'));

        Route::post(config('roles.routes.permissions.url'), 'update')
            ->name(config('roles.routes.permissions.update'));
    });

Route::controller('\Mate\Roles\Controllers\UserController')
    ->middleware(['web', 'has-permissions:manage permissions'])
    ->group(function () {
        Route::get(config('roles.routes.users.url'), 'index')
            ->name(config('roles.routes.users.index'));

        Route::put(config('roles.routes.users.url'), 'update')
            ->name(config('roles.routes.users.update'));
    });
