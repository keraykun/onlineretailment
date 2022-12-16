<?php

use App\Http\Controllers\Cart\CartController;
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
Route::group(['middleware' => 'prevent-back-history'],function(){

Auth::routes(['verify'=>true]);


// Client
Route::middleware(['auth','user-access:client','verified'])->prefix('client/')->as('client.')->group(function(){
    Route::controller(App\Http\Controllers\Client\ClientController::class)->group(function(){
    Route::get('dashboard',  'dashboard')->name('dashboard');
    });
    //product
    Route::controller(App\Http\Controllers\Client\Product\ProductController::class)->group(function(){
        Route::get('category',  'index')->name('product.index');
        Route::post('category',  'create')->name('product.create');
        Route::delete('destroy/{product}',  'destroy')->name('product.destroy');
        Route::patch('update',  'update')->name('product.update');
    });
    //order user
    Route::controller(App\Http\Controllers\Client\Order\UserOrderController::class)->group(function(){
        Route::get('user_order',  'index')->name('order.user.index');
        Route::post('user_order',  'create')->name('order.user.create');
        Route::post('user_update',  'update')->name('order.user.update');
        Route::post('user_remove',  'remove')->name('order.user.remove');
    });
    //order client
    Route::controller(App\Http\Controllers\Client\Order\ClientOrderController::class)->group(function(){
       // Route::get('my_order',  'index')->name('order.client.index');
        // Route::post('category',  'create')->name('product.create');
        // Route::delete('destroy/{product}',  'destroy')->name('product.destroy');
        // Route::patch('update',  'update')->name('product.update');
    });

    //report
    Route::controller(App\Http\Controllers\Client\Report\ReportController::class)->group(function(){
        Route::get('report_list',  'index')->name('report.list.index');
        //refund
        Route::controller(App\Http\Controllers\Client\Report\Refund\RefundController::class)->group(function(){
            Route::get('report_list_refund', 'index')->name('report.refund.index');
            Route::post('report_refund',  'store')->name('report.refund.store');
            Route::get('report_message/{product}/{user}',  'show')->name('report.refund.show'); //show message
            Route::delete('report_destroy/{replyreports}',  'destroy')->name('report.refund.destroy'); //remove comment

            Route::delete('report_trash/{productRefund}',  'trash')->name('report.refund.trash');
            Route::patch('report_solve/{productRefund}',  'solve')->name('report.refund.solve'); //solve message

            Route::patch('report_order/{productRefund}',  'order')->name('report.refund.order'); //order return
        });
        //feedback
        Route::controller(App\Http\Controllers\Client\Report\Feedback\FeedbackController::class)->group(function(){
            Route::get('report_list_feedback', 'index')->name('report.feedback.index');
            Route::patch('report_list_show/{product}', 'show')->name('report.feedback.show');
        });
        //violation
        Route::controller(App\Http\Controllers\Client\Report\Violation\ViolationController::class)->group(function(){
            Route::get('report_list_violation', 'index')->name('report.violation.index');
            Route::get('report_list_violation_show/{data}', 'show')->name('report.violation.show');
            Route::post('report_list_violation_store',  'store')->name('report.violation.store');
            Route::delete('report_list_violation_destroy/{replyreports}',  'destroy')->name('report.violation.destroy');
            Route::patch('report_list_violation_solve/{violationReports}',  'solve')->name('report.violation.solve');
        });
    });

    //history
     Route::controller(App\Http\Controllers\Client\History\HistoryController::class)->group(function(){
        Route::get('history',  'index')->name('history.index');
    });

    //printer
    Route::controller(App\Http\Controllers\Client\Printer\PrinterController::class)->group(function(){
        Route::get('printer',  'index')->name('printer.index');
        Route::post('print',  'print')->name('printer.print');
    });

    //settings
    Route::controller(App\Http\Controllers\Client\Settings\SettingsController::class)->group(function(){
        Route::get('setting',  'index')->name('setting.index');
        Route::post('setting_detail',  'detail')->name('setting.detail');
        Route::post('setting_password',  'password')->name('setting.password');
        Route::post('setting_picture',  'picture')->name('setting.picture');
    });
});
// Admin
Route::middleware(['auth','user-access:admin'])->prefix('admin/')->as('admin.')->group(function(){
    //dashboard
    Route::controller(App\Http\Controllers\Admin\AdminController::class)->group(function(){
        Route::get('dashboard',  'dashboard')->name('dashboard');
    });
    //users
    Route::controller(App\Http\Controllers\Admin\Users\UsersController::class)->group(function(){
        Route::get('users',  'index')->name('users.index');
        Route::patch('status',  'status')->name('users.status'); //ban
        Route::get('users_list/{user}',  'show')->name('users.show');

        //client controller
        Route::controller(App\Http\Controllers\Admin\Users\Details\ClientDetailsController::class)->group(function(){
            // Route::get('client_list_product/{data}',  'products')->name('users.client.products');
            Route::get('client_list_product_history/{data}',  'history')->name('users.client.history');
            Route::get('client_list_product_violation/{data}',  'violation')->name('users.client.violation');
            Route::get('client_list_product_message/{data}',  'message')->name('users.client.message');
            Route::get('client_list_product_show/{data}',  'show')->name('users.client.show');
            Route::post('client_list_product_create',  'create')->name('users.client.create');
            Route::post('client_list_product_store',  'store')->name('users.client.store');
            Route::delete('client_list_product_destroy/{replyreports}',  'destroy')->name('users.client.destroy');
            Route::patch('client_list_product_solve/{violationReports}',  'solve')->name('users.client.solve');
        });

        //user controller
        Route::controller(App\Http\Controllers\Admin\Users\Details\UserDetailsController::class)->group(function(){
            Route::get('users_list_product/{data}',  'products')->name('users.user.show');
            Route::get('users_list_product_history/{data}',  'history')->name('users.user.history');
            Route::get('users_list_product_wishlist/{data}',  'wishlist')->name('users.user.wishlist');
            Route::get('users_list_product_violation/{data}',  'violation')->name('users.user.violation');
            Route::get('users_list_product_message/{data}',  'message')->name('users.user.message');
            Route::get('users_list_product_show/{data}',  'show')->name('users.user.show');
            Route::post('users_list_product_create',  'create')->name('users.user.create');
            Route::post('users_list_product_store',  'store')->name('users.user.store');
            Route::delete('users_list_product_destroy/{replyreports}',  'destroy')->name('users.user.destroy');
            Route::patch('users_list_product_solve/{violationReports}',  'solve')->name('users.user.solve');
        });
    });

    //categories
    Route::controller(App\Http\Controllers\Admin\Category\CategoryController::class)->group(function(){
        Route::get('category',  'index')->name('category.index');
        Route::post('category',  'create')->name('category.create');
        Route::delete('destroy/{category}',  'destroy')->name('category.destroy');
        Route::patch('update',  'update')->name('category.update');
    });

    //reports

    Route::controller(App\Http\Controllers\Admin\Reports\ReportController::class)->group(function(){
        Route::get('report',  'index')->name('report.index');
        //report user
        Route::controller(App\Http\Controllers\Admin\Reports\User\UserReportController::class)->group(function(){
            Route::get('user_report',  'index')->name('report.user.index');
            Route::post('user_store',  'store')->name('report.user.store');
            Route::get('user_report_message/{userreport}',  'show')->name('report.user.show');
            // Route::get('user_report_edit/{replyreports}','edit')->name('report.user.edit');
            Route::delete('user_report_destroy/{replyreports}','destroy')->name('report.user.destroy');
            Route::patch('product_report_destroy/{replyreports}','update')->name('report.user.update');
        });
         //report product
         Route::controller(App\Http\Controllers\Admin\Reports\Product\ProductController::class)->group(function(){
            Route::get('product_report',  'index')->name('report.product.index');
            Route::post('product_store',  'store')->name('report.product.store');
            Route::get('product_report_message/{productreport}',  'show')->name('report.product.show');
            Route::delete('product_report_destroy/{productReports}','destroy')->name('report.product.destroy');
            Route::patch('product_report_destroy/{productReports}','update')->name('report.product.update');
        });
    });

    //settings
    Route::controller(App\Http\Controllers\Admin\Settings\SettingsController::class)->group(function(){
        Route::get('setting_user',  'index')->name('setting.index');
        Route::post('setting_detail',  'detail')->name('setting.detail');
        Route::post('setting_password',  'password')->name('setting.password');
        Route::post('setting_picture',  'picture')->name('setting.picture');
    });


});
//Cart
Route::middleware(['guest'])->prefix('cart/')->as('cart.')->group(function(){
    // Route::resource('/cart', CartController::class);
    Route::controller(App\Http\Controllers\Cart\CartController::class)->group(function(){
       Route::get('/',  'index')->name('index');
       Route::post('/store',  'store')->name('store');
       Route::post('/proceed',  'create')->name('create');
       Route::get('/proceed',  'proceed')->name('proceed');
       Route::get('/order',  'order')->name('order');
       Route::delete('/destroy/{cart}',  'destroy')->name('destroy');
    });

    Route::controller(App\Http\Controllers\Cart\WishlistController::class)->group(function(){
        Route::get('/wishlist',  'index')->name('wishlist.index');
        Route::post('/wishlist',  'store')->name('wishlist.store');
        Route::post('/wishlist/{wishlist}',  'create')->name('wishlist.create');
        Route::delete('/wishlist/{wishlist}',  'destroy')->name('wishlist.destroy');
     });


});
// Guest
Route::middleware(['guest'])->prefix('/')->as('guest.')->group(function(){
    Route::controller(App\Http\Controllers\Guest\HomeController::class)->group(function(){
        Route::get('/',  'index')->name('home');
        Route::get('/product',  'product')->name('product');
        Route::get('/login',  'login')->name('login');
        Route::get('/register',  'register')->name('register');
        Route::get('/show/{product}',  'show')->name('feedback');
    }); // Home Area

    Route::controller(App\Http\Controllers\Guest\AccountController::class)->group(function(){
        Route::post('/login', 'authenticate')->name('authenticate');
        Route::post('/register', 'validators')->name('validator');
        Route::get('/logout',  'logout')->name('logout');
    }); // Account Area
});

// User
Route::middleware(['auth','user-access:user','verified'])->prefix('user/')->as('user.')->group(function(){
    Route::controller(App\Http\Controllers\User\UserController::class)->group(function(){
    Route::get('dashboard',  'dashboard')->name('dashboard');
    });
        //order
        Route::controller(App\Http\Controllers\User\Order\OrderController::class)->group(function(){
            Route::get('order_product',  'index')->name('orders.index');
        });
         //product report
        Route::controller(App\Http\Controllers\User\Order\ProductReportController::class)->group(function(){
            Route::post('create',  'create')->name('report.create');
        });
          //feedback report
        Route::controller(App\Http\Controllers\User\Order\FeedbackReportController::class)->group(function(){
            Route::post('store',  'store')->name('report.store');
        });
        // refund report
        Route::controller(App\Http\Controllers\User\Order\RefundReportController::class)->group(function(){
            Route::post('refund',  'refund')->name('report.refund');
        });

        //violation
        Route::controller(App\Http\Controllers\User\Violation\ViolationController::class)->group(function(){
            Route::get('report_list_violation', 'index')->name('violation.index');
            Route::get('report_list_violation_show/{data}', 'show')->name('violation.show');
            Route::post('report_list_violation_store',  'store')->name('violation.store');
            Route::delete('report_list_violation_destroy/{replyreports}',  'destroy')->name('violation.destroy');
            Route::patch('report_list_violation_solve/{violationReports}',  'solve')->name('violation.solve');
        });

        //history
        Route::controller(App\Http\Controllers\User\History\HistoryController::class)->group(function(){
            Route::get('history',  'index')->name('history.index');
        });

        //refund
        Route::controller(App\Http\Controllers\User\Report\RefundReportController::class)->group(function(){
           Route::get('report',  'index')->name('report.refund.index');
           Route::post('report_store',  'store')->name('report.refund.store');
           Route::get('report_message/{product}',  'show')->name('report.refund.show');
           Route::delete('report_destroy/{replyreports}',  'destroy')->name('report.refund.destroy');

           Route::delete('report_trash/{productrefund}',  'trash')->name('report.refund.trash'); //remove product
           Route::patch('report_solve/{productrefund}',  'solve')->name('report.refund.solve'); //solve product
        });

         //settings
        Route::controller(App\Http\Controllers\User\Settings\SettingsController::class)->group(function(){
            Route::get('setting_user',  'index')->name('setting.index');
            Route::post('setting_detail',  'detail')->name('setting.detail');
            Route::post('setting_password',  'password')->name('setting.password');
            Route::post('setting_picture',  'picture')->name('setting.picture');
    });

});

}); //end of preventhistoryback


