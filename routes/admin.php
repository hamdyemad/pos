<?php

use Illuminate\Support\Facades\Route;


Route::group([
'prefix' => LaravelLocalization::setLocale(),
'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'
]], function() {
    Route::post('/all_cities', 'Admin\CountryController@allCities')->name('cities.all');
    Route::group(['middleware' => ['web', 'auth', 'admin','notBanned']], function() {
        Route::group(['namespace' => 'Auth'], function() {
            // Logout User
            Route::post('/logout', 'LoginController@logout')->name('logout');
        });
        Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
            // Render perticular view file by foldername and filename and all passed in only one controller at a time
            // Route::get('/{folder}/{file}', 'LexaAdmin@index');
            Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


            // Languages
            Route::group(['prefix' => 'languages', 'as' => 'languages.'], function() {
                Route::get('/', 'LanguageController@index')->name('index');
                Route::post('/', 'LanguageController@store')->name('store');
                Route::get('/create', 'LanguageController@create')->name('create');
                Route::get('/{language}/translations', 'LanguageController@translations')->name('translations.index');
                Route::patch('/{language}/translations', 'LanguageController@translations_update')->name('translations.update');
                Route::delete('/{language}', 'LanguageController@destroy')->name('destroy');
            });



            // Branches
            Route::group(['prefix' => 'branches', 'as' => 'branches.'], function() {
                Route::get('/', 'BranchController@index')->name('index');
                Route::post('/', 'BranchController@store')->name('store');
                Route::get('/create', 'BranchController@create')->name('create');
                Route::get('/edit/{branch}', 'BranchController@edit')->name('edit');
                Route::patch('/{branch}', 'BranchController@update')->name('update');
                Route::delete('/{branch}', 'BranchController@destroy')->name('destroy');
            });

            // Customers
            Route::group(['prefix' => 'customers', 'as' => 'customers.'], function() {
                Route::get('/', 'CustomerController@index')->name('index');
                Route::post('/', 'CustomerController@store')->name('store');
                Route::get('/create', 'CustomerController@create')->name('create');
                Route::get('/edit/{customer}', 'CustomerController@edit')->name('edit');
                Route::patch('/{customer}', 'CustomerController@update')->name('update');
                Route::delete('/{customer}', 'CustomerController@destroy')->name('destroy');
            });

            // Categories
            Route::group(['prefix' => 'categories', 'as' => 'categories.'], function() {
                Route::get('/', 'CategoryController@index')->name('index');
                Route::post('/', 'CategoryController@store')->name('store');
                Route::get('/create', 'CategoryController@create')->name('create');
                Route::get('/edit/{category}', 'CategoryController@edit')->name('edit');
                // Ajax
                Route::post('/all_categories', 'CategoryController@allCategories')->name('all');
                Route::get('/{category}', 'CategoryController@show')->name('show');
                Route::patch('/{category}', 'CategoryController@update')->name('update');
                Route::delete('/{category}', 'CategoryController@destroy')->name('destroy');
            });
            // Products
            Route::group(['prefix' => 'products', 'as' => 'products.'], function() {
                // Product Statuses
                Route::group(['prefix' => 'statuses', 'as' => 'statuses.'], function() {
                    Route::get('/', 'ProductTransactionStatusController@index')->name('index');
                    Route::post('/', 'ProductTransactionStatusController@store')->name('store');
                    Route::get('/create', 'ProductTransactionStatusController@create')->name('create');
                    Route::get('/edit/{status}', 'ProductTransactionStatusController@edit')->name('edit');
                    Route::get('/{status}', 'ProductTransactionStatusController@show')->name('show');
                    Route::patch('/{status}', 'ProductTransactionStatusController@update')->name('update');
                    Route::delete('/{status}', 'ProductTransactionStatusController@destroy')->name('destroy');
                });

                // Product Transaction
                Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function() {
                    Route::get('/', 'ProductTransactioController@index')->name('index');
                    Route::post('/', 'ProductTransactioController@store')->name('store');
                    Route::get('/create', 'ProductTransactioController@create')->name('create');
                    Route::get('/edit/{transaction}', 'ProductTransactioController@edit')->name('edit');
                    Route::post('/update_main_status', 'ProductTransactioController@update_main_status')->name('update_main_status');
                    Route::post('/update_status', 'ProductTransactioController@update_status')->name('update_status');
                    Route::get('/{transaction}', 'ProductTransactioController@show')->name('show');
                    Route::patch('/{transaction}', 'ProductTransactioController@update')->name('update');
                    Route::delete('/{transaction}', 'ProductTransactioController@destroy')->name('destroy');
                });

                Route::get('/', 'ProductController@index')->name('index');
                Route::post('/', 'ProductController@store')->name('store');
                Route::get('/all_by_ids', 'ProductController@all_by_ids')->name('all_by_ids');
                Route::get('/variant_price', 'ProductController@variant_price')->name('variant_price');
                Route::post('/all_products', 'ProductController@allByBranchId')->name('all');

                Route::get('/create', 'ProductController@create')->name('create');
                Route::get('/edit/{product}', 'ProductController@edit')->name('edit');
                Route::get('/{product}', 'ProductController@show')->name('show');
                Route::patch('/{product}', 'ProductController@update')->name('update');
                Route::delete('/{product}', 'ProductController@destroy')->name('destroy');

            });
            // Orders
            Route::group(['prefix' => 'orders', 'as' => 'orders.'], function() {
                Route::get('/', 'OrderController@index')->name('index');

                Route::get('/with_bin_codes', 'OrderController@with_bin_codes')->name('with_bin_codes');

                Route::post('/', 'OrderController@store')->name('store');
                Route::post('/status', 'OrderController@updateStatus')->name('status_update');
                Route::post('/statuses', 'OrderController@updateStatusOfOrders')->name('status_all_update');
                Route::get('/create', 'OrderController@create')->name('create');
                Route::get('/edit/{order}', 'OrderController@edit')->name('edit');
                Route::post('/pdfs', 'OrderController@all_pdf')->name('all_pdf');

                Route::post('/order_details', 'OrderController@order_details_destroy')->name('order_details.destroy');

                Route::get('/{order}', 'OrderController@show')->name('show');
                Route::get('/{order}/pdf', 'OrderController@pdf')->name('pdf');

                Route::post('/{order}/approve', 'OrderController@approve')->name('approve');
                Route::post('/{order}/unbin', 'OrderController@unbin')->name('unbin');
                Route::post('/{order}/remove_files', 'OrderController@remove_files')->name('remove_files');

                Route::patch('/{order}', 'OrderController@update')->name('update');
                Route::delete('/{order}', 'OrderController@destroy')->name('destroy');


            });

            // Coupons
            Route::group(['prefix' => 'coupons', 'as' => 'coupons.'], function() {
                Route::get('/', 'CouponController@index')->name('index');
                Route::get('/create', 'CouponController@create')->name('create');
                Route::post('/', 'CouponController@store')->name('store');
                Route::post('/coupon_getter', 'CouponController@show')->name('show');
                Route::delete('/{coupon}', 'CouponController@destroy')->name('destroy');
            });

            // Statuses
            Route::group(['prefix' => 'statuses', 'as' => 'statuses.'], function() {
                Route::get('/', 'StatusController@index')->name('index');
                Route::post('/', 'StatusController@store')->name('store');
                Route::get('/create', 'StatusController@create')->name('create');
                Route::get('/edit/{status}', 'StatusController@edit')->name('edit');
                Route::get('/{status}', 'StatusController@show')->name('show');
                Route::patch('/{status}', 'StatusController@update')->name('update');
                Route::delete('/{status}', 'StatusController@destroy')->name('destroy');
            });

            // Expenses
                Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function() {
                    Route::get('/', 'ExpenseController@index')->name('index');
                    Route::post('/', 'ExpenseController@store')->name('store');
                    Route::post('/export', 'ExpenseController@export')->name('export');
                    Route::get('/create', 'ExpenseController@create')->name('create');
                    Route::get('/edit/{expense}', 'ExpenseController@edit')->name('edit');
                    Route::get('/{expense}', 'ExpenseController@show')->name('show');
                    Route::patch('/{expense}', 'ExpenseController@update')->name('update');
                    Route::delete('/{expense}', 'ExpenseController@destroy')->name('destroy');
                });

            // Business
            Route::group(['prefix' => 'business', 'as' => 'business.'], function() {
                Route::get('/', 'BusinessController@index')->name('index');
                Route::get('/all', 'BusinessController@all')->name('all');
                Route::post('/', 'BusinessController@store')->name('store');
                Route::get('/create', 'BusinessController@create')->name('create');
                Route::get('/edit/{business}', 'BusinessController@edit')->name('edit');
                Route::patch('/{business}', 'BusinessController@update')->name('update');
                Route::delete('/{business}', 'BusinessController@destroy')->name('destroy');
            });


            // Business Settings
            Route::group(['prefix' => 'settings', 'as' => 'settings.'], function() {
                Route::get('/edit', 'SettingsController@edit')->name('edit');
                Route::patch('/update', 'SettingsController@update')->name('update');
            });

            // Countries
            Route::group(['prefix' => 'countries', 'as' => 'countries.'], function() {
                Route::get('/', 'CountryController@index')->name('index');
                Route::post('/', 'CountryController@store')->name('store');
                Route::get('/create', 'CountryController@create')->name('create');
                Route::get('/edit/{country}', 'CountryController@edit')->name('edit');
                Route::patch('/{country}', 'CountryController@update')->name('update');
                Route::delete('/{country}', 'CountryController@destroy')->name('destroy');

                Route::post('/all_cities', 'CountryController@allCities')->name('cities.all');

                // Cities
                Route::get('/{country}/cities', 'CityController@index')->name('cities.index');
                Route::get('/{country}/cities/create', 'CityController@create')->name('cities.create');
                Route::post('/{country}/cities', 'CityController@store')->name('cities.store');
                Route::get('/{country}/cities/edit/{city}', 'CityController@edit')->name('cities.edit');
                Route::patch('/{country}/{city}', 'CityController@update')->name('cities.update');
                Route::delete('/{country}/{city}', 'CityController@destroy')->name('cities.destroy');
            });

            // Users
            Route::group(['prefix' => 'users', 'as' => 'users.'], function() {
                Route::get('/', 'UserController@index')->name('index');
                Route::post('/', 'UserController@store')->name('store');
                Route::get('/create', 'UserController@create')->name('create');
                Route::get('/profile/{user}', 'UserController@profile')->name('profile');
                Route::post('/banned/{user}', 'UserController@banned')->name('banned');
                Route::get('/edit/{user}', 'UserController@edit')->name('edit');
                Route::patch('/{user}', 'UserController@update')->name('update');
                Route::delete('/{user}', 'UserController@destroy')->name('destroy');
            });

            // Roles
            Route::group(['prefix' => 'roles', 'as' => 'roles.'], function() {
                Route::get('/', 'RoleController@index')->name('index');
                Route::post('/', 'RoleController@store')->name('store');
                Route::get('/create', 'RoleController@create')->name('create');
                Route::get('/edit/{role}', 'RoleController@edit')->name('edit');
                Route::patch('/{role}', 'RoleController@update')->name('update');
                Route::delete('/{role}', 'RoleController@destroy')->name('destroy');
            });

        });
    });
});

