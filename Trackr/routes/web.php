<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Network_MemberController;
use App\Http\Controllers\Notification_CenterController;
use App\Http\Controllers\Organization_MemberController;
use App\Http\Controllers\Organization_NetworkController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GraphController;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

/*Route::get('/home', function () {
    return view('home', ['user' => Auth::user()]);
})->middleware(['auth'])->name('home');*/

Route::group(['middleware'=>['auth']], function(){
    Route::get('/home', 'App\Http\Controllers\DashboardController@index')->name('home');
});

Route::put('users/{user}/update-status', [UserController::class, 'updateStatus'])->name('user-update-status');
Route::resource('users', UserController::class);

Route::resource('attachments', AttachmentController::class);

Route::put('contacts/{user_id}/{contact_id}/accept-contact-request', [ContactController::class, 'acceptContactRequest'])->name('accept-contact-request');
Route::put('contacts/{requester_id}/add-contact', [ContactController::class, 'addContact'])->name('add-contact');
Route::resource('contacts', ContactController::class);

Route::put('network_members/{network_member}/remove-member', [Network_MemberController::class, 'removeMember'])->name('network-member-remove-member');
Route::put('Network_Members/{network_id}/{member_id}/add-network-member', [Network_MemberController::class, 'addMember'])->name('add-network-member');
Route::resource('network_members', Network_MemberController::class);

Route::put('organization_members/{organization_id}/add-member', [Organization_MemberController::class, 'addMember'])->name('organization-member-add-member');
Route::put('organization_members/{organization_member}/remove-member', [Organization_MemberController::class, 'removeMember'])->name('organization-member-remove-member');
Route::put('organization_members/{organization_member}/{status}/respond-to-invite', [Organization_MemberController::class, 'respondToInvite'])->name('organization-member-respond-to-invite');
Route::resource('organization_members', Organization_MemberController::class);

Route::get('organization_networks.search/{id}', [Organization_NetworkController::class, 'search'])->name('search-network-members');
Route::resource('organization_networks', Organization_NetworkController::class);

Route::get('reports.create-form/{user_id}', [ReportController::class, 'makeReport'])->name('make-report');
Route::get('reports.network_member.network_member_report/{member_id}', [ReportController::class, 'viewMemberReports'])->name('view-member-reports');
Route::get('reports.user.contact_reports/{id}', [ReportController::class, 'showContactReports'])->name('reports.user');
Route::resource('reports', ReportController::class);

Route::post('organizations/{organization_id}/send-message', [OrganizationController::class, 'sendMessage'])->name('organization-send-message');
Route::resource('organizations', OrganizationController::class);

Route::get('graphs/{user_id}/user-graphs', [GraphController::class, 'showUserGraphs'])->name('show-user-graphs');
Route::get('graphs/{organization_id}/organization-graphs', [GraphController::class, 'showOrganizationGraphs'])->name('show-organization-graphs');
Route::get('graphs/{network_id}/organization-network-graphs', [GraphController::class, 'showOrganizationNetworkGraphs'])->name('show-network-graphs');

Route::get('/users/{user_id}/notification-center/', [Notification_CenterController::class, 'index'])->name('user-notification-center');
Route::get('/users/{user_id}/notification-center/view-message/{id}', [Notification_CenterController::class, 'viewMessage'])->name('view-message');
Route::get('notification_center/{user_id}/delete-message/{id}', [Notification_CenterController::class, 'deleteMessage'])->name('delete-message');

require __DIR__.'/auth.php';
