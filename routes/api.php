<?php

use App\Http\Controllers\Api\Abandon\AbandonController;
use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Admin\UserManipController;
use App\Http\Controllers\Api\BigGroup\BigGroupController;
use App\Http\Controllers\Api\BigGroup\BigGroupManipController;
use App\Http\Controllers\Api\Evenement\EvenementController;
use App\Http\Controllers\Api\Evenement\EvenementManagementController;
use App\Http\Controllers\Api\EventMembre\EvenementMembreController;
use App\Http\Controllers\Api\Links\LinkController;
use App\Http\Controllers\Api\Links\LinkManipController;
use App\Http\Controllers\Api\Membre\MemberManipController;
use App\Http\Controllers\Api\Membre\MembreController;
use App\Http\Controllers\Api\PetitGroupe\PetitGroupeController;
use App\Http\Controllers\Api\PetitGroupeMembre\PetitGroupeMembreController;
use App\Http\Controllers\Api\Prospect\ProspectController;
use App\Http\Controllers\Api\Prospect\ProspectManipController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\Staff\StaffController;
use App\Http\Controllers\Api\StaffMembre\StaffMembreController;
use App\Http\Controllers\Api\Statistique\StatMembreController;
use App\Http\Controllers\Api\TypeLien\TypeLienController;
use App\Http\Controllers\Api\User\DefinePasswordController;
use App\Http\Controllers\Api\User\ForgotPasswordController;
use App\Http\Controllers\Api\User\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\VerificationController;

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

// login
Route::post('users/login', [UserController::class, 'store_login']);

Route::prefix('users')->group(function () {
    // we use sanctum middleware in order to protect all URI inside
    Route::middleware('auth:sanctum')->group(function() {

        Route::get('{id}/profile', [UserController::class, 'show_profile']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/logout', [UserController::class, 'logout']);

        // Route to handle email confirmation request
        Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify']);
        // Route to resend email confirmation
        Route::post('/email/verification-notification', [VerificationController::class, 'resend']);    
    });

    // Handle forget password request & send email with the password reset link
    Route::post('/forgot-password', [ForgotPasswordController::class, "send_link"]);
    
    // Handle update password
    Route::post('/reset-password', [ResetPasswordController::class, 'store']);
    
    // Handle define password
    Route::post('/define-password', [DefinePasswordController::class, 'store']);

    // resend define password
    Route::post('/define-password/resend', [DefinePasswordController::class, 'resend_define']);
});

Route::prefix('admins')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        // Route affichage des membres
        Route::get('/membre', [MembreController::class, 'index']);
        Route::delete('/membre/{membre}', [MemberManipController::class, 'destroy_membre']);
        Route::post('/add_membre', [MemberManipController::class, 'store']);
        Route::put('/edit_membre/{membre}', [MemberManipController::class, 'update_membre']);
        Route::get('/membre/{id}/profile', [MemberManipController::class, 'show_membre']);

        // Route prospect
        Route::get('/prospect', [ProspectController::class, 'index']);
        Route::post('/add_prospect', [ProspectManipController::class, 'store']);
        Route::get('/prospect/{prospect}/show', [ProspectManipController::class, 'show_prospect']);
        Route::put('/edit_prospect/{prospect}', [ProspectManipController::class, 'update_prospect']);
        Route::delete('/prospect/{prospect}', [ProspectManipController::class, 'destroy_prospect']);

        // Links
        Route::get('/links', [LinkController::class, 'index']);
        Route::post('/create_link', [LinkManipController::class, 'create_link']);
        Route::get('/edit_link/{link}/show', [LinkManipController::class, 'show_link']);
        Route::put('/edit_link/{link}', [LinkManipController::class, 'update_link']);
        Route::delete('/links/{lien}', [LinkManipController::class, 'delete_link']);
        
        //Grand groupe
        Route::get('/grand_groupe', [BigGroupController::class, 'index']);
        Route::post('/add_grand_groupe', [BigGroupManipController::class, 'create_big_groupe']);
        Route::put('/edit_g_group/{g_group}', [BigGroupManipController::class, 'update_grand_group']);
        Route::delete('/grand_groupe/{g_group}', [BigGroupManipController::class, 'delete_grand_g']);
        Route::get('/grand_groupe/{id}/profile', [BigGroupManipController::class, 'show_big_group']);
    
        // Statistique
        Route::get('/statistique', [StatMembreController::class, 'index']);

        Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
    
        Route::post('/users', [UserManipController::class, 'store_user']);
    
        Route::put('/users/{user}', [UserManipController::class, 'update_user']);

        Route::delete('/users/{user}', [UserManipController::class, 'destroy_user']);

        // Routes petit groupes
        Route::get('/petit-groupes/all', [PetitGroupeController::class, 'index']);
        Route::post('/petit-groupes', [PetitGroupeController::class, 'store']);
        Route::get('/petit-groupes/{id}', [PetitGroupeController::class, 'show']);
        Route::put('/petit-groupes/{petit_groupe}/update', [PetitGroupeController::class, 'update']);
        Route::delete('/petit-groupes/{petit_groupe}/delete', [PetitGroupeController::class, 'destroy']);
        Route::post('/petit-groupes/{petit_groupe}/membres', [PetitGroupeMembreController::class, 'store_membre_petit_groupe']);
        Route::delete('/petit-groupes/petit_groupe_membres/{petit_groupe_membre}', [PetitGroupeMembreController::class, 'destroy_membre_petit_groupe']);

        // Routes staffs
        Route::get('/staffs', [StaffController::class, 'index']);
        Route::post('/staffs', [StaffController::class, 'store']);
        Route::get('/staffs/{id}', [StaffController::class, 'show']);
        Route::put('/staffs/{staff}/update', [StaffController::class, 'update']);
        Route::delete('/staffs/{staff}/delete', [StaffController::class, 'destroy']);
        Route::post('/staffs/{staff_list}/staff_membre', [StaffMembreController::class, 'store_staff_membre']);
        Route::delete('/staffs/staff_membre/{staff_membre}', [StaffMembreController::class, 'destroy_membre_staff']);
        
        // Routes evenement
        Route::get('/events', [EvenementController::class, 'index']);
        Route::post('/events', [EvenementController::class, 'store']);
        Route::get('/events/{id}', [EvenementController::class, 'show']);
        Route::put('/events/{event}/update', [EvenementController::class, 'update']);
        Route::delete('/events/{event}/delete', [EvenementController::class, 'destroy']);
        Route::post('/events/{event}/grand_groupe', [EvenementManagementController::class, 'add_grand_groupe']);
        Route::delete('/events/{event}/grand_groupe', [EvenementManagementController::class, 'remove_grand_groupe']);
        Route::post('/events/{event}/abandon', [AbandonController::class, "store_abandon_event"]);
        Route::post('/events/{event}/staff', [EvenementManagementController::class, "store_staff_event"]);
        Route::delete('/events/{event}/staff', [EvenementManagementController::class, "remove_staff_event"]);

        //Routes gestion de participant
        Route::post('/events/participants', [EvenementMembreController::class, 'store_participant']);
        Route::put('/events/participants/{participant}', [EvenementMembreController::class, 'update_participant']);
        Route::delete('/events/participants/{participant}', [EvenementMembreController::class, 'destroy_participant']);

        // Routes gestion de participant
        Route::get('/roles/all', [RoleController::class, 'index']);
        Route::post('/roles', [RoleController::class, 'store']);
        Route::put('/roles/{id}/edit', [RoleController::class, 'update']);
        Route::delete('/roles/{role}', [RoleController::class, 'destroy']);
        Route::get('/roles/{id}', [RoleController::class, 'show']);
        Route::delete('/roles/{id}/permissions', [RoleController::class, 'revoke_all_permissions']);

        // Routes gestion de type_lien
        Route::post('/type_liens', [TypeLienController::class, 'store']);
        Route::get('/type_liens/{id}/edit', [TypeLienController::class, 'show']);
        Route::put('/type_liens/{type_lien}/show', [TypeLienController::class, 'update']);
        Route::delete('/type_liens/{type_lien}', [TypeLienController::class, 'destroy']);
    });


});

