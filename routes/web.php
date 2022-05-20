<?php

use App\Http\Controllers\Abandon\AbandonController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserManipController;
use App\Http\Controllers\BigGroup\BigGroupController;
use App\Http\Controllers\BigGroup\BigGroupManipController;
use App\Http\Controllers\Evenement\EvenementController;
use App\Http\Controllers\Evenement\EvenementManagementController;
use App\Http\Controllers\EventMembre\EvenementMembreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Links\LinkController;
use App\Http\Controllers\Links\LinkManipController;
use App\Http\Controllers\Membre\MemberManipController;
use App\Http\Controllers\Membre\MembreController;
use App\Http\Controllers\PetitGroupe\PetitGroupeController;
use App\Http\Controllers\PetitGroupeMembre\PetitGroupeMembreController;
use App\Http\Controllers\ProfileUser\ProfilController;
use App\Http\Controllers\Prospect\ProspectController;
use App\Http\Controllers\Prospect\ProspectManipController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Staff\StaffController;
use App\Http\Controllers\StaffMembre\StaffMembreController;
use App\Http\Controllers\Statistique\StatBigGroupController;
use App\Http\Controllers\Statistique\StatMembreController;
use App\Http\Controllers\Statistique\TauxPassageController;
use App\Http\Controllers\TypeLien\TypeLienController;
use App\Http\Controllers\User\DefinePasswordController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\ResetPasswordController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\VerificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes(['verify' => true]);

Route::prefix('admins')->group(function () {
    // Route affichage des membres
    Route::get('/membre', [MembreController::class, 'index'])->name('admin.membre');
    Route::delete('/membre/{membre}', [MemberManipController::class, 'destroy_membre'])->name('delete_membre');
    Route::get('/add_membre', [MemberManipController::class, 'index'])->name('admin.store_membre');
    Route::post('/add_membre', [MemberManipController::class, 'store']);
    Route::get('/edit_membre/{membre}/edit', [MemberManipController::class, 'edit_membre'])->name("admin.edit_membre");
    Route::put('/edit_membre/{membre}', [MemberManipController::class, 'update_membre'])->name("admin.update_membre");
    Route::get('/membre/{id}/profile', [MemberManipController::class, 'show_membre'])->name('show_profile');

    // Route prospect
    Route::get('/prospect', [ProspectController::class, 'index'])->name('admin.prospect');
    Route::get('/add_prospect', [ProspectManipController::class, 'index'])->name('admin.store_prospect');
    Route::post('/add_prospect', [ProspectManipController::class, 'store']);
    Route::get('/edit_prospect/{prospect}/edit', [ProspectManipController::class, 'edit_prospect'])->name("admin.edit_prospect");
    Route::put('/edit_prospect/{prospect}', [ProspectManipController::class, 'update_prospect'])->name("admin.update_prospect");
    Route::delete('/prospect/{prospect}', [ProspectManipController::class, 'destroy_prospect'])->name('delete_prospect');

    // Links
    Route::get('/links', [LinkController::class, 'index'])->name('admin.links');
    Route::get('/membre/{membre}/profile/create_links', [LinkManipController::class, 'index'])->name('admin.create_links');
    Route::post('/create_link', [LinkManipController::class, 'create_link'])->name('admin.add_link');
    Route::get('/edit_link/{link}/edit', [LinkManipController::class, 'edit_link'])->name("admin.edit_link");
    Route::put('/edit_link/{link}', [LinkManipController::class, 'update_link'])->name("admin.update_link");
    Route::delete('/links/{lien}', [LinkManipController::class, 'delete_link'])->name('delete_link');

    //Grand groupe
    Route::get('/grand_groupe', [BigGroupController::class, 'index'])->name('admin.big_groupe');
    Route::get('/add_grand_groupe', [BigGroupManipController::class, 'index'])->name('admin.add_big_groupe');
    Route::post('/add_grand_groupe', [BigGroupManipController::class, 'create_big_groupe']);
    Route::get('/edit_g_group/{g_group}/edit', [BigGroupManipController::class, 'getBigGroup'])->name("admin.edit_g_group");
    Route::put('/edit_g_group/{g_group}', [BigGroupManipController::class, 'update_grand_group'])->name("admin.update_g_group");
    Route::delete('/grand_groupe/{g_group}', [BigGroupManipController::class, 'delete_grand_g'])->name('admin.delete_gg');
    Route::get('/grand_groupe/{id}/profile', [BigGroupManipController::class, 'show_big_group'])->name('admin.show_grand_groupe');

    // Statistique
    Route::get('/statistique', [StatMembreController::class, 'index'])->name('admin.stat_membre_tribu');
    Route::get('/taux_passage', [TauxPassageController::class, 'index'])->name('admin.tauxPassage');


});

Route::prefix('admins')->name("admin.")->group(function () {

    Route::get('/dashboard', [AdminController::class, 'show_dashboard'])->name("dashboard");

    Route::get('/users', [UserManipController::class, 'create_user'])->name("create_user");
    Route::post('/users', [UserManipController::class, 'store_user'])->name("store_user");

    Route::get('/users/{user}/edit', [UserManipController::class, 'edit_user'])->name("edit_user");
    Route::put('/users/{user}', [UserManipController::class, 'update_user'])->name("update_user");

    Route::delete('/users/{user}', [UserManipController::class, 'destroy_user'])->name("destroy_user");

    Route::get('/users/{id}/show', [UserManipController::class, 'show_user'])->name('show_user');

    Route::get('/users_profile', [ProfilController::class, 'index'])->name('profile');

});

Route::prefix('users')->name("user.")->group(function () {
    Route::get('/login', [UserController::class, 'show_login'])->name("login");
    Route::post('/login', [UserController::class, 'store_login'])->name("login");
    Route::get('/{id}/profile', [UserController::class, 'show_profile'])->name('show_profile');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name("edit");
    Route::put('/{user}', [UserController::class, 'update'])->name("update");
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});

Route::prefix('users')->group(function () {
    // Route to re-send verification email
    Route::get('/email/verify', [VerificationController::class, 'show'])
        ->name('verification.notice'); // <-- don't change the route name

    // Route to handle email confirmation request
    Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
        ->name('verification.verify'); // <-- don't change the route name

    // Route to resend email confirmation
    Route::post('/email/verification-notification', [VerificationController::class, 'resend'])
        ->name('verification.resend');

    // Show form for sending forget password request
    Route::get('/forgot-password', [ForgotPasswordController::class, "show"])->name('password.request');

    // Handle forget password request & send email with the password reset link
    Route::post('/forgot-password', [ForgotPasswordController::class, "send_link"])->name('password.email');

    // Show reset password form
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'show'])->name('password.reset');

    // Handle update password
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');

    // Show define password form
    Route::get('/define-password/{token}', [DefinePasswordController::class, 'show'])->name('define_password.reset');

    // Handle define password
    Route::post('/define-password', [DefinePasswordController::class, 'store'])->name('define_password.update');

    // Show resend define password form
    Route::get('/define-password-resend', [DefinePasswordController::class, 'show_resend_define'])->name('define_password.show_resend');

    // resend define password
    Route::post('/define-password/resend', [DefinePasswordController::class, 'resend_define'])->name('define_password.resend');
});

// Routes petit groupes
Route::name("admin.")->prefix("admins")->group(function () {
    Route::get('/petit-groupes/all', [PetitGroupeController::class, 'index'])->name("all_petit_groupes");
    Route::get('/petit-groupes/create', [PetitGroupeController::class, 'create'])->name("show_create_petit_groupe");
    Route::post('/petit-groupes', [PetitGroupeController::class, 'store'])->name("store_petit_groupe");
    Route::get('/petit-groupes/{id}', [PetitGroupeController::class, 'show'])->name("show_petit_groupe");
    Route::get('/petit-groupes/{id}/edit', [PetitGroupeController::class, 'edit'])->name("show_edit_petit_groupe");
    Route::put('/petit-groupes/{petit_groupe}/update', [PetitGroupeController::class, 'update'])->name("update_petit_groupe");
    Route::delete('/petit-groupes/{petit_groupe}/delete', [PetitGroupeController::class, 'destroy'])->name("destroy_petit_groupe");
    Route::post('/petit-groupes/{petit_groupe}/membres', [PetitGroupeMembreController::class, 'store_membre_petit_groupe'])->name("store_membre_petit_groupe");
    Route::delete('/petit-groupes/petit_groupe_membres/{petit_groupe_membre}', [PetitGroupeMembreController::class, 'destroy_membre_petit_groupe'])->name("destroy_membre_petit_groupe");
});

// Routes staffs
Route::name("admin.")->prefix("admins")->group(function () {
    Route::get('/staffs', [StaffController::class, 'index'])->name("all_staffs");
    Route::get('/staffs/create', [StaffController::class, 'create'])->name("show_create_staff");
    Route::post('/staffs', [StaffController::class, 'store'])->name("store_staff");
    Route::get('/staffs/{id}', [StaffController::class, 'show'])->name("show_staff");
    Route::get('/staffs/{id}/edit', [StaffController::class, 'edit'])->name("show_edit_staff");
    Route::put('/staffs/{staff}/update', [StaffController::class, 'update'])->name("update_staff");
    Route::delete('/staffs/{staff}/delete', [StaffController::class, 'destroy'])->name("destroy_staff");
    Route::post('/staffs/{staff_list}/staff_membre', [StaffMembreController::class, 'store_staff_membre'])->name("add_staff_membre");
    Route::delete('/staffs/staff_membre/{staff_membre}', [StaffMembreController::class, 'destroy_membre_staff'])->name("destroy_membre_staff");
});

// Routes evenement
Route::name("admin.")->prefix("admins")->group(function () {
    Route::get('/events', [EvenementController::class, 'index'])->name("all_events");
    Route::get('/events/create', [EvenementController::class, 'create'])->name("show_create_event");
    Route::post('/events', [EvenementController::class, 'store'])->name("store_event");
    Route::get('/events/{id}', [EvenementController::class, 'show'])->name("show_event");
    Route::get('/events/{id}/edit', [EvenementController::class, 'edit'])->name("show_edit_event");
    Route::put('/events/{event}/update', [EvenementController::class, 'update'])->name("update_event");
    Route::delete('/events/{event}/delete', [EvenementController::class, 'destroy'])->name("destroy_event");
    Route::post('/events/{event}/grand_groupe', [EvenementManagementController::class, 'add_grand_groupe'])->name("add_grand_groupe");
    Route::delete('/events/{event}/grand_groupe', [EvenementManagementController::class, 'remove_grand_groupe'])->name("remove_grand_groupe");
    Route::post('/events/{event}/abandon', [AbandonController::class, "store_abandon_event"])->name('abandon');
    Route::post('/events/{event}/staff', [EvenementManagementController::class, "store_staff_event"])->name('store_staff_event');
    Route::delete('/events/{event}/staff', [EvenementManagementController::class, "remove_staff_event"])->name('remove_staff_event');
});

// Routes gestion de participant
Route::name("admin.")->prefix("admins")->group(function () {
    Route::post('/events/participants', [EvenementMembreController::class, 'store_participant'])->name("add_participant");
    Route::put('/events/participants/{participant}', [EvenementMembreController::class, 'update_participant'])->name("update_participant");
    Route::delete('/events/participants/{participant}', [EvenementMembreController::class, 'destroy_participant'])->name("destroy_participant");
});

// Routes gestion de participant
Route::name("admin.")->prefix("admins")->group(function () {
    Route::get('/roles/all', [RoleController::class, 'index'])->name("all_roles");
    Route::get('/roles', [RoleController::class, 'create'])->name("show_create_role");
    Route::post('/roles', [RoleController::class, 'store'])->name("store_role");
    Route::get('/roles/{id}/edit', [RoleController::class, 'edit'])->name("show_edit_role");
    Route::put('/roles/{id}/edit', [RoleController::class, 'update'])->name("update_role");
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name("destroy_role");
    Route::get('/roles/{id}', [RoleController::class, 'show'])->name("show_role");
    Route::delete('/roles/{id}/permissions', [RoleController::class, 'revoke_all_permissions'])->name("revoke_all_permissions");
});

// Routes gestion de type_lien
Route::name("admin.")->prefix("admins")->group(function () {
    Route::get('/type_liens/add', [TypeLienController::class, 'create'])->name("create_type_lien");
    Route::post('/type_liens', [TypeLienController::class, 'store'])->name("store_type_lien");
    Route::get('/type_liens/{id}/edit', [TypeLienController::class, 'edit'])->name("edit_type_lien");
    Route::put('/type_liens/{type_lien}/edit', [TypeLienController::class, 'update'])->name("update_type_lien");
    Route::delete('/type_liens/{type_lien}', [TypeLienController::class, 'destroy'])->name("destroy_type_lien");
});