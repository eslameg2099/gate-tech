<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "dashboard" middleware group and "App\Http\Controllers\Dashboard" namespace.
| and "dashboard." route's alias name. Enjoy building your dashboard!
|
*/
Route::get('locale/{locale}', 'LocaleController@update')->name('locale')->where('locale', '(ar|en)');

Route::get('/', 'DashboardController@index')->name('home');

// Select All Routes.
Route::delete('delete', 'DeleteController@destroy')->name('delete.selected');
Route::delete('forceDelete', 'DeleteController@forceDelete')->name('forceDelete.selected');
Route::delete('restore', 'DeleteController@restore')->name('restore.selected');

// Customers Routes.
Route::get('trashed/customers', 'CustomerController@trashed')->name('customers.trashed');
Route::get('trashed/customers/{trashed_customer}', 'CustomerController@showTrashed')->name('customers.trashed.show');
Route::post('customers/{trashed_customer}/restore', 'CustomerController@restore')->name('customers.restore');
Route::delete('customers/{trashed_customer}/forceDelete', 'CustomerController@forceDelete')->name('customers.forceDelete');
Route::resource('customers', 'CustomerController');

// Supervisors Routes.
Route::get('trashed/supervisors', 'SupervisorController@trashed')->name('supervisors.trashed');
Route::get('trashed/supervisors/{trashed_supervisor}', 'SupervisorController@showTrashed')->name('supervisors.trashed.show');
Route::post('supervisors/{trashed_supervisor}/restore', 'SupervisorController@restore')->name('supervisors.restore');
Route::delete('supervisors/{trashed_supervisor}/forceDelete', 'SupervisorController@forceDelete')->name('supervisors.forceDelete');
Route::resource('supervisors', 'SupervisorController');

// Admins Routes.
Route::get('trashed/admins', 'AdminController@trashed')->name('admins.trashed');
Route::get('trashed/admins/{trashed_admin}', 'AdminController@showTrashed')->name('admins.trashed.show');
Route::post('admins/{trashed_admin}/restore', 'AdminController@restore')->name('admins.restore');
Route::delete('admins/{trashed_admin}/forceDelete', 'AdminController@forceDelete')->name('admins.forceDelete');
Route::resource('admins', 'AdminController');

// Settings Routes.
Route::get('settings', 'SettingController@index')->name('settings.index');
Route::patch('settings', 'SettingController@update')->name('settings.update');
Route::get('backup/download', 'SettingController@downloadBackup')->name('backup.download');

// Feedback Routes.
Route::get('trashed/feedback', 'FeedbackController@trashed')->name('feedback.trashed');
Route::get('trashed/feedback/{trashed_feedback}', 'FeedbackController@showTrashed')->name('feedback.trashed.show');
Route::post('feedback/{trashed_feedback}/restore', 'FeedbackController@restore')->name('feedback.restore');
Route::delete('feedback/{trashed_feedback}/forceDelete', 'FeedbackController@forceDelete')->name('feedback.forceDelete');
Route::patch('feedback/read', 'FeedbackController@read')->name('feedback.read');
Route::patch('feedback/unread', 'FeedbackController@unread')->name('feedback.unread');
Route::resource('feedback', 'FeedbackController')->only('index', 'show', 'destroy');

// Buildings Routes.
Route::get('trashed/buildings', 'BuildingController@trashed')->name('buildings.trashed');
Route::get('trashed/buildings/{trashed_building}', 'BuildingController@showTrashed')->name('buildings.trashed.show');
Route::post('buildings/{trashed_building}/restore', 'BuildingController@restore')->name('buildings.restore');
Route::delete('buildings/{trashed_building}/forceDelete', 'BuildingController@forceDelete')->name('buildings.forceDelete');
Route::resource('buildings', 'BuildingController');

// Apartments Routes.
Route::get('trashed/apartments', 'ApartmentController@trashed')->name('apartments.trashed');
Route::get('trashed/apartments/{trashed_apartment}', 'ApartmentController@showTrashed')->name('apartments.trashed.show');
Route::post('apartments/{trashed_apartment}/restore', 'ApartmentController@restore')->name('apartments.restore');
Route::delete('apartments/{trashed_apartment}/forceDelete', 'ApartmentController@forceDelete')->name('apartments.forceDelete');
Route::resource('apartments', 'ApartmentController')->except('index', 'create');

// Services Routes.
Route::get('trashed/services', 'ServiceController@trashed')->name('services.trashed');
Route::get('trashed/services/{trashed_service}', 'ServiceController@showTrashed')->name('services.trashed.show');
Route::post('services/{trashed_service}/restore', 'ServiceController@restore')->name('services.restore');
Route::delete('services/{trashed_service}/forceDelete', 'ServiceController@forceDelete')->name('services.forceDelete');
Route::resource('services', 'ServiceController');

// Rents Routes.
Route::resource('apartments.rents', 'RentController');
Route::post('rents/{rent}/payment', 'RentController@payment')->name('rents.payment');
Route::post('installments/{installment}', 'InstallmentController@show')->name('installments.show');
Route::post('transactions', 'TransactionController@store')->name('transactions.store');
Route::get('transactions', 'TransactionController@index')->name('transactions.index');
Route::get('transactions/{transaction}', 'TransactionController@show')->name('transactions.show');

// Owners Routes.
Route::get('trashed/owners', 'OwnerController@trashed')->name('owners.trashed');
Route::get('trashed/owners/{trashed_owner}', 'OwnerController@showTrashed')->name('owners.trashed.show');
Route::post('owners/{trashed_owner}/restore', 'OwnerController@restore')->name('owners.restore');
Route::delete('owners/{trashed_owner}/forceDelete', 'OwnerController@forceDelete')->name('owners.forceDelete');
Route::resource('owners', 'OwnerController');

Route::get('reports/monthly', 'ReportController@monthly')->name('reports.monthly');
Route::get('reports/yearly', 'ReportController@yearly')->name('reports.yearly');

/*  The routes of generated crud will set here: Don't remove this line  */
