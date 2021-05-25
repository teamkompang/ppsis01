<?php

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true, 'register' => false]);



// email registration
Route::post('/send-email', 'MailRegController@sendEmail');
// {token} is a required parameter that will be exposed to us in the controller method
Route::get('accept/{token}', 'MailRegController@accept')->name('accept');

Route::resource('users','UserController');

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('report','ReportController');

    Route::resource('profilemaintain','ProfileMaintainController');

    Route::resource('punbfinancing','Punb_FinancingController');
    Route::resource('punbnewfinancing','Punb_NewFinancingController');
    Route::resource('punbrestructure','Punb_RestructureController');
    Route::resource('punbreinstate','Punb_ReinstateController');
    Route::resource('punbvlo','Punb_VloController');

    Route::resource('panelfinancing','Panel_FinancingController');
    Route::resource('panelnewfinancing','Panel_NewFinancingController');
    Route::resource('panelrestructure','Panel_RestructureController');
    Route::resource('panelreinstate','Panel_ReinstateController');
    Route::resource('panelvlo','Panel_VloController');

    Route::resource('casestatus','Maintain_CaseStatusController');
    Route::resource('panelstatus','Maintain_PanelStatusController');

    Route::resource('usermaintain','Secure_UserMaintainController');
    Route::resource('paramsetting','Secure_ParamSettingController');
    Route::resource('securesetting','Secure_SecureSettingController');


    Route::post('/paramsetting/store_param', 'Secure_ParamSettingController@store_param');
    Route::patch('/paramsetting/update_security', 'Secure_ParamSettingController@update_security')->name('securityupdate.update_security');

    // PUNB add-ons controller Active
    // Route::patch('/punbfinancing/STLstatusCase/{header_id}', 'Punb_FinancingController@STLstatusCase')->name('STLstatusCase');
    Route::post('/punbfinancing/STLstatusActiveCase/{cid}', 'Punb_FinancingController@STLstatusActiveCase')->name('STLstatusActiveCase');
    Route::post('/punbnewfinancing/NFstatusActiveCase/{cid}', 'Punb_NewFinancingController@NFstatusActiveCase')->name('NFstatusActiveCase');
    Route::post('/punbrestructure/RSTstatusActiveCase/{cid}', 'Punb_RestructureController@RSTstatusActiveCase')->name('RSTstatusActiveCase');
    Route::post('/punbreinstate/RINstatusActiveCase/{cid}', 'Punb_ReinstateController@RINstatusActiveCase')->name('RINstatusActiveCase');
    Route::post('/punbvlo/VLOstatusActiveCase/{cid}', 'Punb_VloController@VLOstatusActiveCase')->name('VLOstatusActiveCase');

    // PUNB add-ons controller Hide
    // Route::patch('/punbfinancing/STLstatusCase/{header_id}', 'Punb_FinancingController@STLstatusCase')->name('STLstatusCase');
    Route::post('/punbfinancing/STLstatusHideCase/{cid}', 'Punb_FinancingController@STLstatusHideCase')->name('STLstatusHideCase');
    Route::post('/punbnewfinancing/NFstatusHideCase/{cid}', 'Punb_NewFinancingController@NFstatusHideCase')->name('NFstatusHideCase');
    Route::post('/punbrestructure/RSTstatusHideCase/{cid}', 'Punb_RestructureController@RSTstatusHideCase')->name('RSTstatusHideCase');
    Route::post('/punbreinstate/RINstatusHideCase/{cid}', 'Punb_ReinstateController@RINstatusHideCase')->name('RINstatusHideCase');
    Route::post('/punbvlo/VLOstatusHideCase/{header_id}', 'Punb_VloController@VLOstatusHideCase')->name('VLOstatusHideCase');

    // Panel add-ons controller Active
    Route::post('/panelfinancing/PSTLstatusActiveCase/{cid}', 'Panel_FinancingController@PSTLstatusActiveCase')->name('PSTLstatusActiveCase');
    Route::post('/panelnewfinancing/NFstatusActiveCase/{cid}', 'Panel_NewFinancingController@NFstatusActiveCase')->name('NFstatusActiveCase');
    Route::post('/panelrestructure/PRSTstatusActiveCase/{header_id}', 'Panel_RestructureController@PRSTstatusActiveCase')->name('PRSTstatusActiveCase');
    Route::post('/panelreinstate/PRINstatusActiveCase/{header_id}', 'Panel_ReinstateController@PRINstatusActiveCase')->name('PRINstatusActiveCase');
    Route::post('/panelvlo/PVLOstatusActiveCase/{header_id}', 'Panel_VloController@PVLOstatusActiveCase')->name('PVLOstatusActiveCase');

    // Panel add-ons controller Hide
    Route::post('/panelfinancing/PSTLstatusHideCase/{cid}', 'Panel_FinancingController@PSTLstatusHideCase')->name('PSTLstatusHideCase');
    Route::post('/panelnewfinancing/NFstatusHideCase/{cid}', 'Panel_NewFinancingController@NFstatusHideCase')->name('NFstatusHideCase');
    Route::post('/panelrestructure/PRSTstatusHideCase/{header_id}', 'Panel_RestructureController@PRSTstatusHideCase')->name('PRSTstatusHideCase');
    Route::post('/panelreinstate/PRINstatusHideCase/{header_id}', 'Panel_ReinstateController@PRINstatusHideCase')->name('PRINstatusHideCase');
    Route::post('/panelvlo/PVLOstatusHideCase/{header_id}', 'Panel_VloController@PVLOstatusHideCase')->name('PVLOstatusHideCase');
    
    // report
    Route::resource('report','ReportController');


    Route::get('/casestatus/ViewCases/{id}', 'Maintain_CaseStatusController@ViewCases')->name('ViewCases');
    Route::get('/casestatus/ViewCasesNF/{id}', 'Maintain_CaseStatusController@ViewCasesNF')->name('ViewCasesNF');
    Route::patch('/casestatus/ReopenCase/{id}', 'Maintain_CaseStatusController@ReopenCase')->name('ReopenCase');
    Route::get('/casestatus/newfinancing/{id}', 'Maintain_CaseStatusController@NewFinancing')->name('newfinancing');

    Route::resource('file','FileController');
    // Route::get('file/{sis_id}/download', 'punbfinancing@download')->name('file.download');


    // PUNB Download File
    Route::get('/files/{filename}', 'Punb_FinancingController@downloadFile')->name('downloadFile');
    Route::get('/files/{filename}', 'Punb_RestructureController@downloadFile')->name('downloadFile');

    // Panel Download File
    Route::get('/files/{filename}', 'Panel_FinancingController@downloadFile')->name('downloadFile');
    Route::get('/files/{filename}', 'Panel_RestructureController@downloadFile')->name('downloadFile');

    //Batch Email
    Route::get('/send-email', 'PPSISEmailCaseController@sendEmail')->name('send-email');
    Route::resource('emailcase', 'PPSISEmailCaseController');

    // View in table PUNB
    Route::get('/ViewComment/{cid}', 'Punb_FinancingController@ViewComment')->name('viewcomment');
    Route::get('/ViewCommentNF/{cid}', 'Punb_NewFinancingController@ViewCommentNF')->name('viewcommentnf');
    Route::get('/ViewCommentRestruc/{cid}', 'Punb_RestructureController@ViewCommentRestruc')->name('viewcommentrestruc');
    Route::get('/ViewCommentReinst/{cid}', 'Punb_ReinstateController@ViewCommentReinst')->name('viewcommentreinst');
    Route::get('/ViewCommentVlo/{cid}', 'Punb_VloController@ViewCommentVlo')->name('viewcommentvlo');


    // View in table PUNB
    Route::get('/PanelViewComment/{cid}', 'Panel_FinancingController@PanelViewComment')->name('viewcomment');
    Route::get('/PanelViewCommentNF/{cid}', 'Panel_NewFinancingController@PanelViewCommentNF')->name('viewcommentnf');
    Route::get('/PanelViewCommentRestruc/{cid}', 'Panel_RestructureController@PanelViewCommentRestruc')->name('viewcommentrestruc');
    Route::get('/PanelViewCommentReinst/{cid}', 'Panel_ReinstateController@PanelViewCommentReinst')->name('viewcommentreinst');
    Route::get('/PanelViewCommentVlo/{cid}', 'Panel_VloController@PanelViewCommentVlo')->name('viewcommentvlo');




});
