<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use App\Events\AssignTask;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test-email', function () {
    $details = [
        'subject' => 'Test Email',
        'body' => 'This is a test email.'
    ];
    Mail::raw($details['body'], function ($message) use ($details) {
        $message->to('johnbrrighte7427206@gmail.com')
                ->subject($details['subject']);
    });
    return 'Email Sent';
});


Route::get('/', function () {
    return view('auth.login');
});

Route::get('event', function(){
    event(new AssignTask());
});

// `Auth::routes()` is provided by the `laravel/ui` package.
// Guard it so artisan commands (like `migrate`) work even if UI scaffolding isn't installed.
// If UI isn't installed, register the minimal auth routes we need for `resources/views/auth/login.blade.php`.
if (class_exists(\Laravel\Ui\UiServiceProvider::class)) {
    Auth::routes();
} else {
    Route::middleware('guest')->get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::middleware('guest')->get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::middleware('guest')->post('register', [RegisterController::class, 'register'])->name('register');
    Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
}
Route::post('admin-logout', function(){
	\Auth::logout();
	return redirect()->route('login');
})->name('admin-logout');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	
// Route::resource('register-user', App\Http\Controllers\UserRegistrationController::class);
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'CheckUserRole']], function() {
    Route::get('/', [App\Http\Controllers\Admin\AdminNavigationController::class, 'dashboard'])->name('dashboard');    
    Route::resource('users', App\Http\Controllers\Admin\AllUserController::class);
    Route::resource('staff', App\Http\Controllers\Admin\StaffController::class);
    Route::resource('news_papers', App\Http\Controllers\Admin\NewsPaperController::class);
    Route::resource('area', App\Http\Controllers\Admin\AreaController::class);
    Route::resource('news_groups', App\Http\Controllers\Admin\NewsGroupController::class);
    Route::resource('borough', App\Http\Controllers\Admin\BoroughController::class);
    Route::resource('bookings', App\Http\Controllers\Admin\BookingsController::class);
    Route::get('bookings/{id}', [App\Http\Controllers\Admin\BookingsController::class, 'showBookingById'])->name('showBookingById');

    Route::get('processing_bookings', [App\Http\Controllers\Admin\BookingsController::class, 'processing_bookings'])->name('processing_bookings');
    Route::get('completed_bookings', [App\Http\Controllers\Admin\BookingsController::class, 'completed_bookings'])->name('completed_bookings');
    Route::get('cancelled_bookings', [App\Http\Controllers\Admin\BookingsController::class, 'cancelled_bookings'])->name('cancelled_bookings');

    Route::get('plo_index', [App\Http\Controllers\Admin\BookingsController::class, 'plo_index'])->name('plo_index');
    Route::get('plo_processing_bookings', [App\Http\Controllers\Admin\BookingsController::class, 'plo_processing_bookings'])->name('plo_processing_bookings');
    Route::get('plo_completed_bookings', [App\Http\Controllers\Admin\BookingsController::class, 'plo_completed_bookings'])->name('plo_completed_bookings');
    Route::get('plo_cancelled_bookings', [App\Http\Controllers\Admin\BookingsController::class, 'plo_cancelled_bookings'])->name('plo_cancelled_bookings');

    Route::post('/proof_pdf', [App\Http\Controllers\Admin\BookingsController::class, 'proof_pdf'])->name('proof_pdf');  

    Route::get('/update_booking_status/{booking_id}/{booking_status}', [App\Http\Controllers\Admin\BookingsController::class, 'update_booking_status'])->name('update_booking_status');

    Route::get('/assign_staff/{booking_id}/{staff_id}', [App\Http\Controllers\Admin\BookingsController::class, 'assign_staff'])->name('assign_staff');
    
    Route::get('/newspaper_mail/{booking_id}', [App\Http\Controllers\Admin\BookingsController::class, 'newspaper_mail'])->name('newspaper_mail');
    
    // Route to show details of a specific booking
	Route::get('/bookings/{id}', [App\Http\Controllers\Admin\BookingsController::class, 'showBookingByIdForMail'])->name('bookings.show');
    Route::post('/bookings/{id}/accept', [App\Http\Controllers\Admin\BookingsController::class, 'acceptBooking'])->name('bookings_accept');
    
    Route::get('/bookings/mail/{id}', [App\Http\Controllers\Admin\BookingsController::class, 'mail'])->name('mail');
    Route::get('/bookings/recipient-details/{id}', [App\Http\Controllers\Admin\BookingsController::class, 'recipientDetails'])->name('recipient-details');
}); 

Route::get("user/tmplan_create", [App\Http\Controllers\DraftTMPlanBookingsController::class, 'create'])->name("user.tmplan_create"); // tmplan_create
    
Route::post("user/tmplan_store", [App\Http\Controllers\DraftTMPlanBookingsController::class, 'store'])->name("user.tmplan_store"); // tmplan_create
Route::get('user/tmplan_list', [App\Http\Controllers\DraftTMPlanBookingsController::class, 'getMaps'])->name('user.tmplan_list');


Route::group([ 'prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth', 'CheckUserRole']], function() {
    Route::get('/', [App\Http\Controllers\Users\UserNavigationController::class, 'dashboard'])->name('dashboard');
    Route::post('/update_profile', [App\Http\Controllers\Users\UserNavigationController::class, 'update_profile'])->name('update_profile');
    
    Route::resource('bookings', App\Http\Controllers\Users\DraftBookingsController::class);
    Route::post('/bookings/store_draft', [App\Http\Controllers\Users\DraftBookingsController::class, 'store'])->name('store_draft');
    
    Route::get("drafts/download/{id}", [App\Http\Controllers\Users\DraftBookingsController::class, 'download'])->name("download"); 
    
    Route::get("drafts/download_section_23/{id}", [App\Http\Controllers\Users\DraftBookingsController::class, 'downloadSection23'])->name("download_section_23"); //downloadSection23

    Route::get("drafts/download_section_6/{id}", [App\Http\Controllers\Users\DraftBookingsController::class, 'downloadSection6'])->name("download_section_6"); //downloadSection23
    
    Route::get("drafts/download_section_15_2/{id}", [App\Http\Controllers\Users\DraftBookingsController::class, 'downloadSection15_2'])->name("download_section_15_2"); //downloadSection23


    Route::get('/temporary_intent', [App\Http\Controllers\Users\DraftBookingsController::class, 'temporary_intent'])->name('temporary_intent');
    Route::get('/temporary_making', [App\Http\Controllers\Users\DraftBookingsController::class, 'temporary_making'])->name('temporary_making');
    Route::get('/permanent_intent', [App\Http\Controllers\Users\DraftBookingsController::class, 'permanent_intent'])->name('permanent_intent');
    Route::get('/permanent_making', [App\Http\Controllers\Users\DraftBookingsController::class, 'permanent_making'])->name('permanent_making');
    Route::get('/experimental_intent', [App\Http\Controllers\Users\DraftBookingsController::class, 'experimental_intent'])->name('experimental_intent');
    Route::get('/experimental_making', [App\Http\Controllers\Users\DraftBookingsController::class, 'experimental_making'])->name('experimental_making');
    Route::get('/update_proof_doc_status/{booking_id}/{doc_status}', [App\Http\Controllers\Users\BookingsController::class, 'update_proof_doc_status'])->name('update_proof_doc_status');

    Route::resource('report', App\Http\Controllers\Users\ReportsController::class); // TMPlanBookingsController
    Route::get('/download_all_bookings', [App\Http\Controllers\Users\ReportsController::class, 'download_all_bookings'])->name('download_all_bookings');
    Route::get('/download_borough_bookings/{borough_id}', [App\Http\Controllers\Users\ReportsController::class, 'download_borough_bookings'])->name('download_borough_bookings');

    Route::resource('plans', App\Http\Controllers\DraftTMPlanBookingsController::class);
    
    

    Route::get("drafts/dashboard", function(){return view("users.dashboard");})->name("draft_dashboard");
    
    Route::get("drafts_list", [App\Http\Controllers\Drafts\DraftsController::class, 'drafts_list'])->name("drafts_list");
    
    Route::get("drafts", [App\Http\Controllers\Drafts\DraftsController::class, 'index'])->name("public_notice");
    
    Route::get("profile", [App\Http\Controllers\Drafts\DraftsController::class, 'profile'])->name("profile");
    
    Route::post("save_draft", [App\Http\Controllers\Drafts\DraftsController::class, 'store'])->name("save_draft"); 
    
  

    Route::put("draft_update/{id}", [App\Http\Controllers\Drafts\DraftsController::class, 'update'])->name("draft_update");
    
    Route::delete("destroy/{id}", [App\Http\Controllers\Drafts\DraftsController::class, 'destroy'])->name("destroy");

    Route::get("drafts/create", [App\Http\Controllers\Drafts\DraftsController::class, 'create'])->name("create_public_notice");
    Route::get("drafts/map", [App\Http\Controllers\Drafts\DraftsController::class, 'map'])->name("map");
    Route::get("drafts/tro-gis-map", [App\Http\Controllers\Drafts\DraftsController::class, 'troGisMap'])->name("tro_gis_map");

    // TRO GIS API Routes
    Route::get('api/orders', [App\Http\Controllers\TroGisController::class, 'getOrders'])->name('orders.api');
    Route::get('api/bookings', [App\Http\Controllers\TroGisController::class, 'getBookings'])->name('bookings.api');
    Route::post('api/annotations/store', [App\Http\Controllers\TroGisController::class, 'saveAnnotation'])->name('annotations.store');
    Route::delete('api/annotations/delete', [App\Http\Controllers\TroGisController::class, 'deleteAnnotation'])->name('annotations.delete');
    Route::get('api/boroughs', [App\Http\Controllers\TroGisController::class, 'getBoroughs'])->name('boroughs.api');
    Route::get('api/areas', [App\Http\Controllers\TroGisController::class, 'getAreas'])->name('areas.api');


    Route::get("drafts/login", function(){return view("users.login");})->name("login");

    Route::get("drafts/signup", function(){return view("users.signup");})->name("signup");
});


// Route::group([ 'prefix' => 'staff', 'as' => 'staff.', 'middleware' => ['auth', 'CheckUserRole']], function() {

//     Route::get('/', [App\Http\Controllers\Staff\StaffNavigationController::class, 'dashboard'])->name('dashboard');
//     Route::resource('bookings', App\Http\Controllers\Staff\BookingsController::class);
//     Route::post('/update_delivery_status', [App\Http\Controllers\Staff\BookingsController::class, 'update_delivery_status'])->name('update_delivery_status');

// });

Route::prefix('dev')->group(function(){
	Route::get('controller', function(){
		try{
			\Artisan::call('make:controller Admin/MessagesController -r');
			echo "Controller Created Successfully !";
		} catch( \Exception $e) {
			dd($e->getMessage());
		}
	});
});
