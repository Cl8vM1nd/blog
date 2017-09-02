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

Route::get('/', ['uses' => 'Index\NewsController@index', 'as' => 'index']);

Route::group(['prefix' => 'news', 'as' => 'news.'], function() {
    Route::get('/{id}', ['uses' => 'Index\NewsController@show', 'as' => 'show']);
    Route::get('/more/{id}', ['uses' => 'Index\NewsController@getMoreNews', 'as' => 'more'])->middleware('ajax');

    Route::group(['prefix' => 'search', 'as' => 'search.byTag'], function () {
        Route::get('/tag/{id}', ['uses' => 'Index\NewsController@getNewsByTag']);
        Route::get('/tag/more/{tagId}/{id}', [
            'uses' => 'Index\NewsController@getNewsByTagMore',
            'as' => '.ajax'
        ])->middleware('ajax');
    });
});

/**
 * Register
 */
Route::get('/register', 'Index\RegisterController@index');
Route::post('/register', 'Index\RegisterController@postIndex');

/**
 * Admin Panel
 */
Route::group(['prefix' => 'admin', 'as' => 'admin::', 'namespace' => 'Admin'], function() {
    /* Log in */
    Route::get('/login', ['uses' => 'AdminAccountController@login', 'as' => 'login']);
    Route::post('/login', 'AdminAccountController@postLogin');

    /* Authorized */
    Route::group(['middleware' => ['auth:admin']], function() {
        Route::get('/', ['uses' => 'AdminController@index', 'as' => 'index']);
        Route::get('/logout', ['uses' => 'AdminController@logOut', 'as' => 'logout']);

        /*
         * NEWS
         */
        Route::group(['prefix' => 'news', 'as' => 'news.'], function() {
            Route::get('/', ['uses' => 'NewsController@getNews', 'as' => 'index']);
            Route::get('/add', ['uses' => 'NewsController@addNews', 'as' => 'add']);

            Route::post('/save', ['uses' => 'NewsController@saveNews', 'as' => 'save']);
            Route::post('/update', ['uses' => 'NewsController@updateNews', 'as' => 'update']);
            Route::post('/upload', ['uses' => 'NewsController@uploadImage', 'as' => 'image.upload']);

            Route::get('/view/{id}', ['uses' => 'NewsController@viewNews', 'as' => 'view']);
            Route::get('/edit/{id}', ['uses' => 'NewsController@editNews', 'as' => 'edit']);

            Route::post('/delete/{id}', ['uses' => 'NewsController@deleteNews', 'as' => 'delete']);

            Route::group(['prefix' => 'tag', 'as' => 'tag.'], function() {
                Route::post('/delete/{id}', ['uses' => 'NewsController@detachTagFromArticle', 'as' => 'delete']);
            });
        });
    });
});