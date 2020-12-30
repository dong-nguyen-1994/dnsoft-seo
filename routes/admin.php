<?php

use Module\Seo\Http\Controllers\Admin\PreRedirectController;
use Module\Seo\Http\Controllers\Admin\ErrorRedirectController;

Route::prefix('seo')->group(function () {
    Route::prefix('pre-redirect')->group(function () {
        Route::get('', [PreRedirectController::class, 'index'])
            ->name('seo.admin.pre-redirect.index')
            ->middleware('admin.can:seo.admin.pre-redirect.index');

        Route::get('create', [PreRedirectController::class, 'create'])
            ->name('seo.admin.pre-redirect.create')
            ->middleware('admin.can:seo.admin.pre-redirect.create');

        Route::post('/', [PreRedirectController::class, 'store'])
            ->name('seo.admin.pre-redirect.store')
            ->middleware('admin.can:seo.admin.pre-redirect.create');

        Route::get('{id}/edit', [PreRedirectController::class, 'edit'])
            ->name('seo.admin.pre-redirect.edit')
            ->middleware('admin.can:seo.admin.pre-redirect.edit');

        Route::put('{id}', [PreRedirectController::class, 'update'])
            ->name('seo.admin.pre-redirect.update')
            ->middleware('admin.can:seo.admin.pre-redirect.edit');

        Route::delete('{id}', [PreRedirectController::class, 'destroy'])
            ->name('seo.admin.pre-redirect.destroy')
            ->middleware('admin.can:seo.admin.pre-redirect.destroy');
    });

    Route::prefix('error-redirect')->group(function () {
        Route::get('', [ErrorRedirectController::class, 'index'])
            ->name('seo.admin.error-redirect.index')
            ->middleware('admin.can:seo.admin.error-redirect.index');

        Route::get('create', [ErrorRedirectController::class, 'create'])
            ->name('seo.admin.error-redirect.create')
            ->middleware('admin.can:seo.admin.error-redirect.create');

        Route::post('/', [ErrorRedirectController::class, 'store'])
            ->name('seo.admin.error-redirect.store')
            ->middleware('admin.can:seo.admin.error-redirect.create');

        Route::get('{id}/edit', [ErrorRedirectController::class, 'edit'])
            ->name('seo.admin.error-redirect.edit')
            ->middleware('admin.can:seo.admin.error-redirect.edit');

        Route::put('{id}', [ErrorRedirectController::class, 'update'])
            ->name('seo.admin.error-redirect.update')
            ->middleware('admin.can:seo.admin.error-redirect.edit');

        Route::delete('{id}', [ErrorRedirectController::class, 'destroy'])
            ->name('seo.admin.error-redirect.destroy')
            ->middleware('admin.can:seo.admin.error-redirect.destroy');
    });
});
