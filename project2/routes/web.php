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

Route::get('/', 'PaperController@showHome')->name('homepage.get'); 

Route::get('papers/scholar/{lastName}/{X}', 'PaperController@showWordCloudFromName')->name('paperbyname.get');


Route::get('papers/keyword/{keyword}/{X}', 'PaperController@showWordCloudFromKeyword')->name('paperbykeyword.get');


Route::get('list/{word}', 'PaperController@showPaperList')->name('paperlist.get');


Route::get('abstract/{title}/{word}', 'PaperController@showAbstract')->name('abstract.get');


Route::get('conference/{conferenceName}', 'PaperController@getPaperListFromConference')->name('conference.get');


//Route::get('papers/authorfull/{fullname}', 'PaperController@showWordCloudFromFullName')->name('paperbyfullname.get');


Route::get('papers/subset/{TFString}', 'PaperController@showWordCloudFromSubset')->name('paperbysubset.get');
