 <?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 

Route::post("/phone-verification",[AuthController::class,'phone_verification']);

Route::post("/login",[AuthController::class,'login']);
Route::post("/login-test",[AuthController::class,'login_test']);
Route::post("/register",[AuthController::class,'register']);


Route::post('/store-banner',[AdminController::class,'store_banner']);
Route::post('/edit-banner/{id}',[AdminController::class,'edit_banner']);
Route::post('/delete-banner/{id}',[AdminController::class,'delete_banner']);
Route::post('/device-banner',[AppController::class,'device_banner']);
Route::get('/android-banner',[AppController::class,'android_banner']);
Route::get('/ios-banner',[AppController::class,'ios_banner']);



Route::post('/edit-profile/{id}',[AppController::class,'edit_profile']);



Route::post('/store-info-bank',[AdminController::class,'store_info_bank']);
Route::post('/delete-info-bank/{id}',[AdminController::class,'delete_info_bank']);
Route::get('/show-info-bank/{id}',[AppController::class,'show_info_bank']);
Route::get('/info-bank',[AppController::class,'info_bank']);
Route::post('/edit-info-bank/{id}',[AdminController::class,'edit_info_bank']);




Route::post('/store-help-book',[AdminController::class,'store_help_book']);
Route::post('/delete-help-book/{id}',[AdminController::class,'delete_help_book']);
Route::post('/edit-help-book/{id}',[AdminController::class,'edit_help_book']);
Route::get('/show-help-book/{id}',[AppController::class,'show_help_book']);
Route::get('/help-book',[AppController::class,'help_book']);


Route::post('/store-country',[AdminController::class,'store_country']);
Route::post('/delete-country/{id}',[AdminController::class,'delete_country']);
Route::post('/edit-country/{id}',[AdminController::class,'edit_country']);
Route::get('/show-country/{id}',[AppController::class,'show_country']);
Route::get('/country',[AppController::class,'country']);


Route::post('/store-location',[AdminController::class,'store_location']);
Route::post('/delete-location/{id}',[AdminController::class,'delete_location']);
Route::post('/edit-location/{id}',[AdminController::class,'edit_location']);
Route::get('/show-location/{id}',[AppController::class,'show_location']);
Route::get('/location',[AppController::class,'location']);


Route::post('/store-ambulance-service',[AdminController::class,'store_ambulance_service']);
Route::post('/delete-ambulance-service/{id}',[AdminController::class,'delete_ambulance_service']);
Route::post('/edit-ambulance-service/{id}',[AdminController::class,'edit_ambulance_service']);
Route::get('/show-ambulance-service/{id}',[AppController::class,'show_ambulance_service']);
Route::get('/ambulance-service',[AppController::class,'ambulance_service']);

// Route::post('/create-ambulance-service-subaccount/{id}',[AdminController::class,'create_ambulance_subaccounts']);
// Route::post('/edit-ambulance-service-accounts/{id}', [AdminController::class,'edit_ambulance_serivce_accounts']);
// Route::post('/delete-ambulance-service-accounts/{id}', [AdminController::class,'delete_ambulance_service_accounts']);
// Route::get('/get-ambulance-subaccount/{id}', [AdminController::class, 'get_ambulance_subaccount']);
// Route::get('get-ambulance-accounts/{id}', [AdminController::class,'get_ambulance_accounts']);
// Route::post('/get-subacc-ambulanceservice/{id}', [AdminController::class,'get_subacc_ambulanceservice']);



Route::post('/store-agencies',[AdminController::class,'store_agencies']);
Route::post('/delete-agencies/{id}',[AdminController::class,'delete_agencies']);
Route::post('/edit-agencies/{id}',[AdminController::class,'edit_agencies']);
Route::get('/show-agencies/{id}',[AppController::class,'show_agencies']);
Route::get('/agencies',[AppController::class,'agencies']);


Route::post('/store-feedback/{id}',[AppController::class,'store_feedback']);
Route::post('/delete-feedback/{id}',[AdminController::class,'delete_feedback']);
Route::post('/edit-feedback/{id}',[AdminController::class,'edit_feedback']);
Route::get('/show-feedback/{id}',[AdminController::class,'show_feedback']);
Route::get('/feedback',[AdminController::class,'feedback']);
Route::get('/show-agency-feedback/{id}', [AdminController::class,'show_agency_feedback']);


Route::post('/store-dependant/{id}',[AppController::class,'store_dependant']);
Route::get('/show-dependant/{id}',[AppController::class,'show_dependant']);
Route::get('/dependant',[AppController::class,'dependant']);
Route::post('/dependant-delete/{id}',[AppController::class,'dependant_delete']);

Route::post('/store-medication/{id}',[AppController::class,'store_medication']);
Route::get('/show-medication/{id}',[AppController::class,'show_medication']);
Route::get('/medication',[AppController::class,'medication']);
Route::post('/medication-delete/{id}',[AppController::class,'medication_delete']);



Route::post('/store-ambulance/{id}',[AppController::class,'store_ambulance']);
Route::post('/delete-ambulance/{id}',[AdminController::class,'delete_ambulance']);
Route::post('/edit-ambulance/{id}',[AdminController::class,'edit_ambulance']);
Route::get('/show-ambulance/{id}',[AdminController::class,'show_ambulance']);
Route::get('/ambulance', [AdminController::class,'ambulance']);
Route::get('/subaccount-ambulance-requests/{id}', [AdminController::class,'subaccount_ambulance_requests']);


Route::post('/store-travelsafe/{id}',[AppController::class,'store_travelsafe']);
Route::post('/delete-travelsafe/{id}',[AdminController::class,'delete_travelsafe']);
Route::post('/edit-travelsafe/{id}',[AdminController::class,'edit_travelsafe']);
Route::get('/show-travelsafe/{id}',[AdminController::class,'show_travelsafe']);
Route::get('/show-user-travelsafe/{user_id}',[AdminController::class,'show_user_travelsafe']);
Route::get('/travelsafe',[AdminController::class,'travelsafe']);
Route::get('/show-travel-agency/{id}', [AdminController::class, 'show_travel_agency']);


Route::post('/store-sos/{id}',[AppController::class,'store_sos']);
Route::post('/delete-sos/{id}',[AdminController::class,'delete_sos']);
Route::post('/edit-sos/{id}',[AdminController::class,'edit_sos']);
Route::get('/show-sos/{id}',[AdminController::class,'show_sos']);
Route::get('/show-user-sos/{user_id}',[AdminController::class,'show_user_sos']);
Route::get('/sos',[AdminController::class,'sos']);
Route::get('/get-all-agency-sos/{id}', [AdminController::class,'showAgencySos']);


Route::post('/store-report/{id}',[AppController::class,'store_report']);
Route::post('/delete-report/{id}',[AdminController::class,'delete_report']);
Route::post('/edit-report/{id}',[AdminController::class,'edit_report']);
Route::get('/show-report/{id}',[AdminController::class,'show_report']);
Route::get('/show-user-report/{user_id}',[AdminController::class,'show_user_report']);
Route::get('/report',[AdminController::class,'report']);
Route::get('/show-agency-report/{id}', [AdminController::class,'show_report_agency']);


Route::post('/store-consult/{id}',[AppController::class,'store_consult']);
Route::post('/delete-consult/{id}',[AdminController::class,'delete_consult']);
Route::post('/edit-consult/{id}',[AdminController::class,'edit_consult']);
Route::get('/show-consult/{id}',[AdminController::class,'show_consult']);
Route::get('/show-user-consult/{user_id}',[AdminController::class,'show_user_consult']);
Route::get('/consult',[AdminController::class,'consult']);
Route::post('/change-consult-status/{id}', [AdminController::class,'consult_status']);
Route::get('/get-all-agency-consult/{id}', [AdminController::class, 'showAgencyConsult']);


Route::post('/store-suggestion/{id}',[AppController::class,'store_suggestion']);
Route::post('/delete-suggestion/{id}',[AdminController::class,'delete_suggestion']);
Route::post('/edit-suggestion/{id}',[AdminController::class,'edit_suggestion']);
Route::get('/show-suggestion/{id}',[AdminController::class,'show_suggestion']);
Route::get('/show-user-suggestion/{user_id}',[AdminController::class,'show_user_suggestion']);
Route::get('/suggestion',[AdminController::class,'suggestion']);
Route::get('/show-agency-suggestion/{id}', [AdminController::class,'show_agency_suggestion']);


Route::post('/store-alert',[AdminController::class,'store_alert']);
Route::post('/delete-alert/{id}',[AdminController::class,'delete_alert']);
Route::get('/alerts',[AdminController::class,'alerts']);
Route::get('/alert/{id}',[AdminController::class,'alert_id']);
Route::post('/device-alerts',[AdminController::class,'device_alerts']);
Route::post('/edit-alert/{id}', [AdminController::class,'edit_alert']);

Route::post('/store-message',[AdminController::class,'store_message']);
Route::post('/delete-message/{id}',[AdminController::class,'delete_message']);
Route::get('/messages',[AdminController::class,'messages']);
Route::get('/message/{id}',[AdminController::class,'message_id']);
Route::post('/device-message',[AdminController::class,'device_message']);
Route::post('/edit-message/{id}', [AdminController::class, 'edit_messages']);

Route::get('/activity/{id}',[AppController::class,'activity']);

Route::post('/create-role',[AdminController::class,'create_role']);
Route::post('/create-admin',[AdminController::class,'create_admin']);
Route::post('/admin-edit/{id}',[AdminController::class,'admin_edit']);
Route::post('/role-privilage-delete/{id}',[AdminController::class,'role_privilage_delete']);
Route::post('/role-privilage-edit/{id}',[AdminController::class,'role_privilage_edit']);
Route::get('/admin/{id}',[AdminController::class,'admin_id']);
Route::get('/admin',[AdminController::class,'admin']);
Route::post('/admin-delete/{id}',[AdminController::class,'admin_delete']);
Route::post('/admin-profile-edit/{id}',[AdminController::class,'admin_profile_edit']);

Route::get('/role-privilage',[AdminController::class,'role_privilage']);
Route::get('/role-privilage/{id}',[AdminController::class,'role_privilage_id']);
Route::get('/role',[AdminController::class,'role']);


Route::post('/edit-about',[AdminController::class,'edit_about']);
Route::post('/show-about',[AdminController::class,'show_about']);

Route::post('/store-general-countries',[AdminController::class,'store_general_countries']);
Route::post('/edit-general-countries/{id}',[AdminController::class,'edit_general_countries']);
Route::post('/delete-general-countries/{id}',[AdminController::class,'delete_general_countries']);
Route::get('/general-country',[AdminController::class,'general_country']);
Route::get('/countriesbyid/{id}',[AdminController::class,'countriesbyid']);
Route::get('/country-featured',[AdminController::class,'country_featured']);


Route::post('/change-password/{id}',[AuthController::class,'change_password']);
Route::get("/show-adminEmail",[AdminController::class,'show_admin_email']);
Route::post("/edit-adminEmail/{id}",[AdminController::class,'admin_email_edit']);

Route::post('/phone-verify-password',[AuthController::class,'phone_verify_passowrd']);
Route::post('/reset-password/{id}',[AuthController::class,'reset_password']);


Route::post('/create-relation-type',[AdminController::class,'create_relation_type']);
Route::post('/edit-relation-type/{id}',[AdminController::class,'edit_relation_type']);
Route::post('/delete-relation-type/{id}',[AdminController::class,'delete_relation_type']);
Route::get('/show-relation-type/{id}',[AdminController::class,'show_relation_type']);
Route::get('/relation-type',[AdminController::class,'relation_type']);


Route::get('/show-all-users',[AuthController::class,'show_all_users']);
Route::get('/show-user-id/{id}',[AuthController::class,'show_user_id']);
Route::post('/delete-user/{id}',[AuthController::class,'delete_user']);
Route::post('ban-unban/{id}',[AuthController::class,'ban_unban']);
Route::get('user-location/{id}',[AuthController::class,'user_location']);



Route::post('/send-notify/{id}',[AdminController::class,'send_notify']);
Route::post('/send-bulk-notify',[AdminController::class,'send_bulk_notify']);
Route::post('/send-notify-location', [AdminController::class, 'send_notify_location']);


Route::get('/user-details/{id}',[AdminController::class,'user_details']);
Route::post('/store-climate/{id}',[AppController::class,'store_climate']);
Route::get('/show-climate',[AppController::class,'show_climate']);
Route::post('/show-action-climate/{id}',[AppController::class,'show_action_climate']);
Route::get('/show-id-climate/{id}',[AppController::class,'show_id_climate']);
Route::post('/delete-climate/{id}',[AppController::class,'delete_climate']);


Route::post('/response/{id}',[AdminController::class,'response']);


Route::get('/dashboard',[AdminController::class,'dashboard']);
Route::post('date-wise-dashboard', [AdminController::class,'date_wise_dashboard']);
Route::post('/notify-status/{id}',[AppController::class,'notify_status']);

Route::get('/show-admin-notification/{id}',[AdminController::class,'show_admin_notification']);
Route::get('/admin-notification-count/{id}',[AdminController::class,'show_admin_count']);
Route::post('/read-admin-notification/{id}',[AdminController::class,'read_admin_notification']);
Route::post('/read-all/{id}',[AdminController::class,'read_all']);

Route::post('/delete-activity/{id}',[AppController::class,'delete_activity']);
Route::post('/popup-store',[AdminController::class,'popup_store']);
Route::post('/popup-edit/{id}',[AdminController::class,'popup_edit']);
Route::post('/popup-delete/{id}',[AdminController::class,'popup_delete']);

Route::get('/popup',[AppController::class,'popup']);
Route::get('/popup/{id}',[AppController::class,'popup_id']);
Route::post('/popup-active',[AppController::class,'popup_active']);

Route::post('/checkout/{id}',[AppController::class,'checkout']);
Route::post('/coordinate/{id}/{user_id}',[AppController::class,'coordinate']);


Route::post('/dashboard-country',[AdminController::class,'dashboard_country']);

Route::post('/create-faq',[AdminController::class,'create_faq']);
Route::post('/edit-faq/{id}',[AdminController::class,'edit_faq']);
Route::post('/delete-faq/{id}',[AdminController::class,'delete_faq']);


Route::get('/faq',[AppController::class,'show_faq']);
Route::post('/faq-language',[AppController::class,'show_faq_language']);
Route::post('/delete-account/{id}',[AppController::class,'delete_account']);

Route::get('/timeup-coordinate/{id}/{user_id}',[AppController::class,'timeup_coordinate']);

Route::post('/admin-login',[AdminController::class,'admin_login']);
Route::post('/admin-forgot',[AdminController::class,'admin_forgot']);
Route::post('/admin-reset-password/{id}',[AdminController::class,'admin_reset_password']);
Route::post('/edit-user-details/{id}',[AdminController::class,'edit_user_details']);
Route::post('/create-code',[AppController::class,'create_code']);
Route::post('/request-code/{id}',[AppController::class,'request_code']);

Route::post('country-bank',[AppController::class,'country_bank']);
Route::post('relation-language',[AppController::class,'relation_language']);


Route::get('kaci-code',[AppController::class,'kaci_code']);
Route::get('kaci-code/{id}',[AppController::class,'kaci_code_id']);
Route::post('edit-code/{id}',[AppController::class,'edit_code']);
Route::post('delete-code/{id}',[AppController::class,'delete_code']);
Route::post('check-status-sos/{id}',[AppController::class,'check_status_sos']);


Route::post('check-latest-module/{id}',[AppController::class,'check_latest_module']);
Route::post('module-link/{id}',[AppController::class,'module_link']);
Route::post('history-location/{id}',[AdminController::class,'history_location']);
Route::post('kaci-code-user-delete/{id}/{user_id}',[AdminController::class,'kaci_code_user_delete']);
Route::post('resident-location',[AppController::class,'resident_location']);

Route::post('auto-reply-get',[AdminController::class,'auto_reply_get']);
Route::post('auto-reply-edit',[AdminController::class,'auto_reply_edit']);
Route::post('auto-reply-status',[AdminController::class,'auto_reply_status']);
Route::post('bulk-response',[AdminController::class,'bulk_response']);
Route::post('edit-response/{id}',[AdminController::class,'edit_response']);



Route::get('show-date-code/{id}',[AppController::class,'show_date_code']);
Route::post('help-book-country',[AppController::class,'help_book_country']);

Route::get('count-activity/{id}',[AppController::class,'count_activity']);
Route::post('click-activity/{id}',[AppController::class,'click_activity']);
Route::post('edit-profile-otp/{id}',[AppController::class,'edit_profile_otp']);
Route::post('change-time-request-module',[AppController::class,'change_time_request_module']);
Route::get('get-request-module',[AppController::class,'get_request_module']);

Route::post('ambulance-agency-location',[AdminController::class,'ambulance_agency_location']);


Route::get('check-block/{id}',[AuthController::class,'check_block']);


Route::post('notify-count/{id}',[AppController::class,'notify_count']);
Route::get('users-data/{id}',[AppController::class,'users_data']);
Route::post('message-status/{id}',[AdminController::class,'message_status']);
Route::post('alert-status/{id}',[AdminController::class,'alert_status']);


Route::post('live-chat/{id}',[AdminController::class,'live_chat'])->name('live_chat');
Route::get('get-all-chat',[AdminController::class,'get_all_chat'])->name('get_all_chat');
Route::get('get-chat-agency/{id}',[AdminController::class,'get_chat_agency'])->name('get_chat_agency');
Route::post('/delete-chat-message/{id}/{messageId}', [AdminController::class,'delete_chat_message']);
Route::post('/edit-chat-message/{id}/{messageId}', [AdminController::class,'edit_chat_message']);
Route::post('/get-module-chat/{id}', [AdminController::class, 'get_module_chat']);



Route::post('create-beep',[AppController::class,'create_beep']);
Route::post('like-beep/{id}/{beep_id}',[AppController::class,'like_beep']);
Route::post('beep-comment/{id}/{beep_id}',[AppController::class,'beep_comment']);
Route::post('get-all-beeps',[AppController::class,'get_all_beeps']);
Route::post('user-beep-delete/{id}/{beep_id}', [AppController::class, 'delete_user_beep']);
Route::post('user-beep-edit/{id}', [AppController::class, 'edit_beep']);
Route::post('beep-comment-delete/{id}/{beep_id}', [AppController::class,'beep_comment_delete']);

Route::get('show-beep-to-user/{id}',[AppController::class,'show_beep_to_user']);
Route::post('show-beep-filter/{id}',[AppController::class,'show_beep_filter']);
Route::post('beep-save/{id}/{beep_id}',[AppController::class,'beep_save']);
Route::get('user-saved-beeps/{id}', [AppController::class,'get_user_saved_beeps']);
Route::post('search-beeps/{id}', [AppController::class,'get_search_beeps']);
Route::get('recent-searches/{id}', [AppController::class,'get_recent_search']);


Route::post('store-comment-reply/{id}/{beep_id}',[AppController::class,'store_comment_reply']);
Route::post('edit-comment-reply/{id}', [AppController::class,'edit_comment_reply']);
Route::post('delete-comment-reply/{id}/{beep_id}', [AppController::class,'delete_comment_reply']);

Route::post('like-comment/{id}/{comment_id}', [AppController::class,'like_comment']);
Route::post('save-comment/{id}/{comment_id}',[AppController::class,'save_comment']);
Route::post('store_report_item/{id}/{item_id}', [AppController::class,'store_report_item']);
Route::get('get-report-types', [AppController::class,'get_report_types']);


Route::post('/share-beep/{id}/{beep_id}', [AppController::class,'store_share_beep']);
Route::post('/edit-share-beep/{id}', [AppController::class,'edit_share_beep']);
Route::post('/delete-share-beep/{id}', [AppController::class,'delete_share_beep']);


Route::post('/share-climate/{id}/{climate_id}', [AppController::class,'share_climate_beep']);
Route::post('/delete-climate-beep/{id}', [AppController::class,'delete_climate_beep']);


Route::post('create-sponsored-beep', [AdminController::class,'store_sponsored_beeps']);
Route::post('edit-sponsored-beep/{id}', [AdminController::class,'edit_sponsored_beeps']);
Route::post('delete-sponsored-beep/{id}', [AdminController::class,'delete_sponsored_beep']);
Route::post('delete-beep/{id}', [AdminController::class, 'delete_beep']);
Route::post('edit-beep/{id}',[AdminController::class,'edit_beep']);
Route::get('get-single-beep/{id}',[AdminController::class,'get_single_beep']);
Route::post('get-report', [AdminController::class,'get_report']);
Route::post('report-status/{id}', [AdminController::class,'Report_status']);


Route::get('agency-dashboard/{id}', [AdminController::class,'agency_dashboard']);
Route::post('agency-date-wise-dashboard/{id}', [AdminController::class,'agency_datewise_dashboard']);
Route::post('realtime-dashboard', [AdminController::class,'realtime_dashboard']);


Route::get('/all-notification/{id}', [AppController::class,'all_notification']);
Route::get('/read-notification/{id}', [AppController::class,'read_notification']);
Route::get('agency-all-notification/{id}', [AdminController::class,'agency_all_notification']);
Route::get('/read-all-notifications/{id}', [AdminController::class, 'read_all_agency_notifications']);

Route::post('/store-subaccount', [AdminController::class,'store_subaccount']);
Route::post('/edit-subaccount/{id}', [AdminController::class,'edit_subaccount']);
Route::post('/delete-subaccount/{id}', [AdminController::class,'delete_subaccount']);
Route::get('/get-subaccount/{id}', [AdminController::class,'get_subaccount']);
Route::post('/get-all-subaccount', [AdminController::class,'get_all_subaccount']);

Route::post('/subaccount-forgot-password', [AdminController::class,'subacc_forgotpassword']);
Route::post('/subaccount-reset-password/{id}', [AdminController::class,'subacc_resetpassword']);
Route::post('/login-subaccount', [AdminController::class,'login_subaccount']);
Route::get('/get-beep-comment/{beep_id}', [AdminController::class,'get_beep_comments']);
Route::get('/get-beep-reports/{beep_id}', [AdminController::class,'get_beep_reports']);








