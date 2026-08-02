<?php

use App\Modules\Organizations\Http\Controllers\OrganizationController;
use App\Modules\Organizations\Http\Controllers\OrganizationMemberController;
use App\Modules\Organizations\Http\Controllers\OrganizationInvitationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['api', 'auth:api'])->prefix('api/organizations')->group(function (): void {
    Route::get('/', [OrganizationController::class, 'index']);
    Route::post('/', [OrganizationController::class, 'store']);
    Route::get('/{organization}', [OrganizationController::class, 'show']);
    Route::patch('/{organization}', [OrganizationController::class, 'update']);
    Route::delete('/{organization}', [OrganizationController::class, 'destroy']);

    Route::get('/{organization}/members', [OrganizationMemberController::class, 'index']);
    Route::post('/{organization}/members', [OrganizationMemberController::class, 'store']);
    Route::patch('/{organization}/members/{member}', [OrganizationMemberController::class, 'update']);
    Route::delete('/{organization}/members/{member}', [OrganizationMemberController::class, 'destroy']);
});

Route::middleware('api')->post(
    'api/invitations/accept',
    [OrganizationInvitationController::class, 'accept']
);
