<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin', 'AdminController@index')->name('admin.dashboard');
Route::get('/admin/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::post('/admin/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

/*
 * Admin Category Routes
 * */
Route::get('/admin/category-manager', 'Admin\CategoryController@manager')->name('category.manager');
Route::get('/admin/create/category', 'Admin\CategoryController@create')->name('create.category');
Route::post('/admin/save/category', 'Admin\CategoryController@store')->name('store.category');
Route::get('/admin/edit/{id}/category', 'Admin\CategoryController@edit')->name('edit.category');
Route::post('/admin/update/{id}/category', 'Admin\CategoryController@update')->name('update.category');
Route::get('/admin/delete/{id}/category', 'Admin\CategoryController@delete')->name('delete.category');


/*
 * Admin SubCategory Routes
 * */
Route::get('/admin/sub-category-manager', 'Admin\SubCategoryController@manager')->name('subcategory.manager');
Route::get('/admin/create/sub-category', 'Admin\SubCategoryController@create')->name('create.subcategory');
Route::post('/admin/store/sub-category', 'Admin\SubCategoryController@store')->name('store.subcategory');

Route::post('/admin/update/{id}/category', 'Admin\SubCategoryController@update')->name('update.subcategory');
Route::get('/admin/delete/{id}/category', 'Admin\SubCategoryController@delete')->name('delete.subcategory');

/*
 * Admin Quiz Routes
 * */
Route::get('/admin/quiz-manager','Admin\QuizController@manager')->name('quiz.manager');
Route::get('/admin/create/quiz','Admin\QuizController@create')->name('create.quiz');
Route::get('/admin/{id}/get/subcategories','Admin\QuizController@getSubCategories')->name('get.subcats');
Route::post('/admin/create/quiz','Admin\QuizController@store')->name('store.quiz');
Route::get('/admin/{id}/delete/quiz','Admin\QuizController@delete')->name('delete.quiz');
Route::get('/admin/{id}/edit/quiz','Admin\QuizController@edit')->name('edit.quiz');
Route::post('/admin/{id}/update/quiz','Admin\QuizController@update')->name('update.quiz');

/*
 * user Home Routes
 * */
Route::get('/user/dashboard','User\UserQuizController@dashboard')->name('user.dashboard');
Route::post('/user/quiz-details','User\UserQuizController@index')->name('user.quiz');
Route::post('/user/quiz-results', 'User\UserQuizController@result')->name('user.result');