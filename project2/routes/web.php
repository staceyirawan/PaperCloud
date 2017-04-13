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
     return view('homepage');
 });
Route::get('papers/scholar/{lastName}/{X}', 'PaperController@showWordCloudFromName')->name('paperbyname.get');


Route::get('papers/keyword/{keyword}/{X}', 'PaperController@showWordCloudFromKeyword')->name('paperbykeyword.get');


Route::get('list/scholar/{lastName}/{word}', 'PaperController@showPaperListFromName')->name('listbyname.get');


Route::get('list/keyword/{keyword}/{word}', 'PaperController@showPaperListFromKeyword')->name('listbykeyword.get');


Route::get('abstract/{title}/{word}', 'PaperController@showAbstract')->name('abstract.get');


Route::get('conference/{conferenceName}', 'PaperController@getPaperListFromConference')->name('conference.get');
