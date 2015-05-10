<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['namespace' => 'Web'], function(){
	Route::get('/', 						['uses' => 'HomeController@index', 									'as' => 'web.home']);

	Route::get('/signin', 					['uses' => 'LoginController@index', 								'as' => 'web.signin.get']);
	Route::post('/signin', 					['uses' => 'LoginController@signin', 								'as' => 'web.signin.post']);
	Route::get('/signout', 					['uses' => 'LoginController@signout', 								'as' => 'web.signout']);

	Route::get('/register', 				['uses' => 'RegisterController@index', 								'as' => 'web.register.get']);
	Route::post('/register', 				['uses' => 'RegisterController@post', 								'as' => 'web.register.post']);
	Route::get('/registered', 				['uses' => 'RegisterController@registered', 						'as' => 'web.register.done']);

	Route::get('/forgot-password', 			['uses' => 'ForgotPasswordController@index', 						'as' => 'web.forgot-password.get']);
	Route::post('/forgot-password', 		['uses' => 'ForgotPasswordController@post', 						'as' => 'web.forgot-password.post']);
	Route::get('/forgot-password-sent', 	['uses' => 'ForgotPasswordController@done', 						'as' => 'web.forgot-password.done']);

	Route::get('/reset-password', 			['uses' => 'ForgotPasswordController@reset', 						'as' => 'web.reset_password.get']);
	Route::post('/reset-password', 			['uses' => 'ForgotPasswordController@reset_post', 					'as' => 'web.reset_password.post']);
	Route::get('/reset-password-done', 		['uses' => 'ForgotPasswordController@reset_done', 					'as' => 'web.reset_password.done']);

	Route::get('/dl/{file_id}/{file_key}',	['uses' => 'DownloadController@download',							'as' => 'web.file.download']);

	Route::group(['prefix' => 'me', 'middleware' => ['AuthMember']], function(){
		
		Route::get('/organization/form', 	['uses' => 'OrganizationController@create',							'as' => 'web.me.organization.create']);
		Route::post('/organization/form',	['uses' => 'OrganizationController@store',							'as' => 'web.me.organization.store']);

		Route::get('/password/change', 		['uses' => 'MeController@change_password',							'as' => 'web.me.change_password']);
		Route::post('/password/change', 	['uses' => 'MeController@post_change_password',						'as' => 'web.me.change_password.post']);

		Route::group(['prefix' => 'organization'], function(){

			// ANYONE IN ORGANIZATION
			Route::group(['middleware' => ['OrgUser']], function(){
				
				// ORGANIZATION DASHBOARD
				Route::get('/{org_id}', 				['uses' => 'OrganizationController@show',				'as' => 'web.me.organization.show']);

				// MANAGE CATEGORY
				Route::group(['prefix' => '{org_id}/category'], function(){
					Route::get('/', 					['uses' => 'OrganizationController@category_index',		'as' => 'web.me.organization.category.index']);
					Route::get('/form/{cat_id?}',		['uses' => 'OrganizationController@category_form',		'as' => 'web.me.organization.category.form']);
					Route::post('/form/{cat_id?}',	 	['uses' => 'OrganizationController@category_store',		'as' => 'web.me.organization.category.store']);
					Route::get('/delete/{cat_id}',	 	['uses' => 'OrganizationController@category_delete',	'as' => 'web.me.organization.category.delete']);
					Route::post('/delete/{cat_id}',	 	['uses' => 'OrganizationController@category_delete_post','as' => 'web.me.organization.category.delete_post']);
				});

				// MANAGE FILE
				Route::group(['prefix' => '{org_id}/file'], function(){
					Route::get('/', 					['uses' => 'OrganizationController@file_index',			'as' => 'web.me.organization.file.index']);
					Route::get('/create',				['uses' => 'OrganizationController@file_create',		'as' => 'web.me.organization.file.create']);
					Route::get('/edit/{id}',			['uses' => 'OrganizationController@file_edit',			'as' => 'web.me.organization.file.edit']);
					Route::post('/store/{file_id?}',	['uses' => 'OrganizationController@file_store',			'as' => 'web.me.organization.file.store']);
					Route::get('/delete/{file_id}',		['uses' => 'OrganizationController@file_delete',		'as' => 'web.me.organization.file.delete']);
					Route::post('/delete/{file_id}',	['uses' => 'OrganizationController@file_delete_post',	'as' => 'web.me.organization.file.delete.post']);
					Route::get('/clone/{file_id}',		['uses' => 'OrganizationController@file_clone',			'as' => 'web.me.organization.file.clone']);
					Route::post('/clone/{file_id}',		['uses' => 'OrganizationController@file_clone_post',	'as' => 'web.me.organization.file.clone.post']);
				});
			});

			// ORGANIZATION OWNER
			Route::group(['middleware' => ['MyOrg']], function(){

				Route::get('/edit/{org_id}', 			['uses' => 'OrganizationController@edit',				'as' => 'web.me.organization.edit']);
				Route::post('/update/{org_id?}',		['uses' => 'OrganizationController@update',				'as' => 'web.me.organization.update']);

				Route::group(['prefix' => '{org_id}/user'], function(){
					Route::get('/', 					['uses' => 'OrganizationController@user_index',			'as' => 'web.me.organization.user.index']);
					Route::get('/form', 				['uses' => 'OrganizationController@user_form',			'as' => 'web.me.organization.user.form']);
					Route::post('/form', 				['uses' => 'OrganizationController@user_store',			'as' => 'web.me.organization.user.store']);
					Route::get('/remove', 				['uses' => 'OrganizationController@user_remove',		'as' => 'web.me.organization.user.remove']);
				});
			});

		});
		
		Route::controller('/', 'MeController', [
													'getIndex'			=> 'web.me',
												]);
	});
});
