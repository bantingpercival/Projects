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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
	if (Auth::check() && Auth::user()->role == 0) {
		return redirect('/student');
	} else if (Auth::check() && Auth::user()->role == 1) {
		return redirect('/admin');
	} else {
		return view('auth.login');
	}
});
Auth::routes();
Route::resource('/student', 'StudentController');
Route::resource('/admin', 'AdminController');

Route::get('/exam','StudentController@viewExam')->name('exam');
Route::get('/activities','StudentController@viewActivities')->name('activities');
Route::get('/home', 'AdminController@index')->name('home');
Route::get('/subject', 'AdminController@viewSubject')->name('subject');
Route::get('/section', 'AdminController@viewSection')->name('section');
// Admin
/* Exam View's */
Route::get('/exams', 'AdminController@viewMakeExam')->name('makeExam');
Route::get('/exam/{id}',"AdminController@createExam");
Route::get('/exam/{id}/question/{dataId}',"AdminController@createQuestion");
Route::get('/exam/questionner/{dataId}',"AdminController@viewQuestionner");
Route::get('/choices/{id}',"AdminController@viewChoice");
Route::get('/sections/{id}',"AdminController@viewStudent");
Route::get('/sections',"AdminController@viewSections")->name('view.section');
Route::get('/student/answer/{section}/{student}',"AdminController@answerCheck");
Route::get('/exam/question/{id}',"StudentController@examView");

/* Store */
Route::post('/store/subject',"AdminController@storeSubject")->name('store.subject');
Route::post('/store/section',"AdminController@storeSection")->name('store.section');
Route::post('/store/exam',"AdminController@storeExam")->name('store.exam');
Route::post('/store/category',"AdminController@storeExamCategory")->name('store.exam_categ');
Route::post('/store/question',"AdminController@storeExamQuestion")->name('store.exam_question');

//Update
Route::post('/exam/update',"AdminController@changeChoice")->name('changeChoice');
Route::get('/exam/update/{id}',"AdminController@activeAnswer");
//Student
/* View's */
Route::get('/questions/{id}','StudentController@viewQuestionner');
Route::get('/results','StudentController@viewResult')->name('exam.result');
/* Store */
Route::get('/user/{userId}/{dataId}',"StudentController@storeStudent");
Route::post('/student/answer',"StudentController@storeAnswer")->name('store.answer');
 
Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');
	Route::get('icons', function () {
		return view('pages.icons');
	})->name('class');
	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});
