<?php
//use Illuminate\Routing\Route;
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

/*Route::get('/', function () {
    return view('newhome');
})->name('home.index');*/

Route::get('/', 'CmsController@newhome');

Route::post('/setLineNotificationFlag', 'HomeController@setLineNotificationFlag')->name('setLineNotificationFlag');
Route::any('/testWebHook', 'TestController@testWebHook');
Route::any('/currenttime', 'TestController@currenttime');
Route::any('/testpayout', 'TestController@testpayout');
Route::any('/getIcalData', 'TestController@getIcalData');
Route::any('/fixarp', 'TestController@fixarp');
Route::any('/delete_duplicate_keywords', 'TestController@delete_duplicate_keywords');
Route::any('/testgdrive', 'TestController@testgdrive');
/*Route::any('/insert_location', 'TestController@insert_location');
Route::any('/insert_services', 'TestController@insert_services');
Route::any('/insert_students', 'TestController@insert_students');
Route::any('/insert_orders', 'TestController@insert_orders');

Route::any('/migrate_lesson_records', 'TestController@migrate_lesson_records');
Route::any('/migrate_homework_tasks', 'TestController@migrate_homework_tasks');*/


Route::any('/migrate_canvas_data', 'TestController@migrate_canvas_data');
Route::any('/migrate_arps_data', 'TestController@migrate_arps_data');
Route::any('/accent_lesson_record_id', 'TestController@accent_lesson_record_id');
Route::any('/delete_arp_data', 'TestController@delete_arp_data');
Route::any('/fill_arp_data', 'TestController@fill_arp_data');
Route::any('/updategdrive', 'TestController@updategdrive');
Route::any('/createfolderongdrive', 'TestController@createfolderongdrive');
Route::any('/testemail', 'TestController@testemail');
Route::any('/sendtestlinemessage', 'TestController@sendtestlinemessage');
Route::any('/zoho', 'TestController@zoho');
Route::any('/createZohoUser', 'TestController@createZohoUser');
Route::any('/createInvoiceItem', 'TestController@createInvoiceItem');
Route::any('/createInvoiceCustomer', 'TestController@createInvoiceCustomer');
Route::any('/createInvoice', 'TestController@createInvoice');
Route::any('/emailInvoice', 'TestController@emailInvoice');
Route::any('/get_refresh_token', 'TestController@get_refresh_token');
Route::any('/createInvoiceItemFromDb', 'TestController@createInvoiceItemFromDb');
Route::any('/createInvoiceCustomerFromDb', 'TestController@createInvoiceCustomerFromDb');
Route::any('/createPackageItemFromDb', 'TestController@createPackageItemFromDb');
Route::any('/updateInvoice', 'TestController@updateInvoice');
Route::any('/gettraveltime', 'TestController@getTravelTime');

Route::any('/update_orders_date', 'TestController@update_orders_date');

Auth::routes();
Route::get('login', 'Auth\LoginController@showStudentLogin');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('login/onepage', 'Auth\LoginController@showStudentLogin');
Route::get('teacher/login', 'Auth\LoginController@showTeacherLogin')->name('teacher.login.show');
Route::post('teacher/login', 'Auth\LoginController@teacherLogin')->name('teacher.login');
Route::get('teacher/profile/favorite/{id}', 'Auth\LoginController@showStudentLogin');

Route::get('login/startsession', 'Auth\LoginController@showStudentLogin');

//OCE

Route::get('language-partners', 'LanguagePartnersController@index')->name('students.languagepartners.index');
Route::get('list-language-partners', 'LanguagePartnersController@listing')->name('students.languagepartners.listing');
Route::get('getAvailableTeachers', 'LanguagePartnersController@getAvailableTeachers')->name('students.getAvailableTeachers.index');

Route::get('getOnlineTeachers', 'LanguagePartnersController@getOnlineTeachers')->name('students.getOnlineTeachers.index');

Route::any('favorite', 'LanguagePartnersController@favorite')->name('teachers.favorite');
Route::any('unfavorite', 'LanguagePartnersController@unfavorite')->name('teachers.unfavorite');
Route::any('/currentservertime', 'LanguagePartnersController@currentservertime')->name('currentservertime');
		
Route::get('/home', function () {
    return redirect('/');
})->name('home');

/*******CMS Routes*******/
Route::get('privacy-policy', 'CmsController@privacy_policy');
Route::get('terms-of-use', 'CmsController@terms_of_use');
Route::get('about-us', 'CmsController@about_us');
Route::get('company_profile', 'CmsController@company_profile');
Route::get('faq', 'CmsController@faq');
Route::get('contact-us', 'CmsController@contact_us');
Route::post('contact-us', 'CmsController@contact_us_store')->name('contact_us.submit');
Route::get('aspire-coaching', 'CmsController@aspire_coaching');
Route::get('eatt', 'CmsController@eatt');
Route::get('freshbook/token', 'CmsController@freshbookToken');
Route::get('generate/ical/{ids}', 'CmsController@generateIcal');

Route::get('customised_course', 'CmsController@customised_course');
Route::get('onepage_canvas', 'CmsController@onepage_canvas');
Route::get('lesson_anywhere', 'CmsController@lesson_anywhere');
Route::get('language_partners', 'CmsController@language_partners');
Route::get('pricing', 'CmsController@pricing')->name('pricing.index');
Route::get('testimonials', 'CmsController@testimonials');
Route::get('kids', 'CmsController@kids');
Route::get('casual_conversation', 'CmsController@casual_conversation');
Route::get('aspire_coaching', 'CmsController@aspire_coaching');
Route::get('newhome', 'CmsController@newhome');

Route::any('linewebhook', 'HookController@line_webhook');
Route::any('zohoinvwebhook', 'HookController@zoho_invoice_webhook');


// Route::any('paypal/webhook', 'CmsController@SuccessWebHook')->name('students.account.paypal.webhook');
Route::any('paypal/webhook', 'HookController@SuccessWebHook')->name('students.account.paypal.webhook');
/*******CMS Routes*******/

Route::prefix('admin')->group(function () {
    Route::namespace('Admin')->group(function () {
        Route::namespace('Auth')->group(function () {
            Route::get('/', function () {
                if (Auth::guard('admin')->check()) {
                    return redirect()->route('admin.dashboard');
                } else {
                    return redirect('admin/login');
                }
            });

            // Route::get('login', function () {
            //     if(Auth::guard('admin')->check()){
            //         return redirect()->route('admin.dashboard');
            //     } else {
            //         return view('admin.auth.login', ['url' => 'admin']);
            //     }
            // });
            Route::get('login', 'LoginController@showLoginForm')->name('admin.login.show');
            Route::post('login', ['as' => 'admin.login', 'uses' => 'LoginController@login']);
            Route::any('logout', ['as' => 'admin.logout', 'uses' => 'LoginController@logout']);
            Route::get('forgot-password', ['as' => 'admin.password.request', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
            Route::post('forgot-password', ['as' => 'admin.password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
            Route::get('reset-password/{token}', ['as' => 'admin.password.reset', 'uses' => 'ResetPasswordController@showResetForm']);
            Route::post('reset-password', ['as' => 'admin.password.update', 'uses' => 'ResetPasswordController@reset']);
        });

        Route::get('/user', 'GraphController@retrieveUserProfile');
        Route::any('/user/facebook/post', 'GraphController@publishPost');
        Route::group(['guard' => 'admin', 'middleware' => ['admin']], function () {
            Route::get('/dashboard', 'LessonReports\DashboardController@index')->name('admin.dashboard');
			Route::get('/remaingBalance', 'LessonReports\DashboardController@remaingBalance')->name('admin.remaingBalance');

            /*******Admin User Routes*******/
            Route::resource('admin-users', 'AdminUsersController');
            Route::post('get-admin-users', 'AdminUsersController@getusers');
            Route::post('admin-user-detail', 'AdminUsersController@userdetail');

            Route::get('admin-profile', 'ProfileController@profile')->name('admin-profile');
            Route::post('editprofile', 'ProfileController@editprofile')->name('editprofile');
            Route::get('admin-change-password', 'ProfileController@changepassword')->name('admin-change-password');
            Route::post('admin-new-password', 'ProfileController@storenewpassword')->name('admin-new-password');
            /*******Admin User Routes*******/

            /******* Teachers Routes*******/
            Route::resource('teachers', 'TeachersController', ['as' => 'admin']);
            Route::post('teachers/get', 'TeachersController@getTeachers')->name('admin.teachers.get');
            Route::post('teachers/email-exists', 'TeachersController@checkEmailAlready')->name('admin.teachers.email.exist');
            Route::any('teachers/attachment/{id}', 'TeachersController@attachment')->name('admin.teachers.attachment');
            Route::any('teachers/location/{id}', 'TeachersController@location')->name('admin.teachers.location');
            Route::any('add-location-service/{id}', 'TeachersController@addLocationService')->name('add.location.service');
            Route::any('teachers/get-schedule/{id}', 'TeachersController@getSchedule')->name('admin.teachers.get.schedule');
            Route::any('update-schedule/{id}', 'TeachersController@updateSchedule')->name('admin.teachers.update.schedule');
            Route::any('teachers/get-earning/{id}', 'TeachersController@getEarning')->name('admin.teachers.get.earnings');
            Route::post('teachers/earning/detail', 'TeachersController@getEarningDetail')->name('admin.teachers.get.earning.detail');
            Route::any('teachers/generateIcal/{ids}', 'TeachersController@generateIcal');
            /******* Teachers Routes*******/

            /******* Students Routes*******/
            Route::resource('students', 'StudentsController', ['as' => 'admin']);
            Route::post('students/get', 'StudentsController@getStudents')->name('admin.students.get');
            Route::any('students/points/{id}', 'StudentsController@points')->name('admin.students.points');
            Route::any('update-points/{id}', 'StudentsController@updatePoints')->name('admin.students.update.points');
            /******* Students Routes*******/

            /*******Static page Routes*******/
            Route::resource('static-pages', 'StaticPageController', ['as' => 'admin']);
            Route::post('static-pages/get', 'StaticPageController@getStaticPages')->name('admin.static-pages.get');
            /*******Static page Routes*******/

            /*******Location Type Routes*******/
            Route::resource('location-type', 'LocationTypeController', ['as' => 'admin']);
            Route::post('location-type/get', 'LocationTypeController@getLocationType')->name('admin.location-type.get');
            /*******Location Type Routes*******/

            /*******Location Routes*******/
            Route::resource('locations', 'LocationsController', ['as' => 'admin']);
            Route::post('locations/get', 'LocationsController@getLocation')->name('admin.locations.get');
            Route::post('locations/get-state', 'LocationsController@getState')->name('admin.locations.getState');
            Route::post('locations/get-city', 'LocationsController@getCity')->name('admin.locations.getCity');
            /*******Location Routes*******/

            /*******Packages Routes*******/
            Route::resource('packages', 'PackagesController', ['as' => 'admin']);
            Route::post('packages/get', 'PackagesController@getPackage')->name('admin.packages.get');
            /*******Packages Routes*******/

            /*******Services Routes*******/
            Route::resource('services', 'ServicesController', ['as' => 'admin']);
            Route::post('services/get', 'ServicesController@getService')->name('admin.services.get');
            /*******Services Routes*******/
			
			/*******Categories Routes*******/
            Route::resource('categories', 'CategoriesController', ['as' => 'admin']);
            Route::post('categories/get', 'CategoriesController@getCategories')->name('admin.categories.get');
            /*******categories Routes*******/

            /*******One Page Levels Routes*******/
            Route::resource('one-page-levels', 'OnePageLevelsController', ['as' => 'admin']);
            Route::post('one-page-levels/get', 'OnePageLevelsController@getLevels')->name('admin.one-page-levels.get');
            /*******One Page Levels Routes*******/

            /*******One Page Levels Points Routes*******/
            Route::resource('one-page-points', 'OnePageLevelsPointsController', ['as' => 'admin']);
            Route::post('one-page-points/get', 'OnePageLevelsPointsController@getLevelsPoints')->name('admin.one-page-points.get');
            /*******One Page Levels Points Routes*******/

            /*******Badges Routes*******/
            Route::resource('badges', 'BadgesController', ['as' => 'admin']);
            Route::post('badges/get', 'BadgesController@getBadges')->name('admin.badges.get');
            /*******Badges Routes*******/

            /*******Rating Types Routes*******/
            Route::resource('rating-types', 'RatingTypesController', ['as' => 'admin']);
            Route::post('rating-types/get', 'RatingTypesController@getRatingTypes')->name('admin.rating-types.get');
            /*******Rating Types Routes*******/

            /*******Teachers Rating Routes*******/
            Route::resource('teacher-ratings', 'TeacherRatingsController', ['as' => 'admin']);
            Route::post('teacher-ratings/get', 'TeacherRatingsController@getTeacherRatings')->name('admin.rating-types.get');
             Route::get('teacher-ratings/details/{id}', 'TeacherRatingsController@RatingDetails')->name('admin.rating.details');
            /*******Teachers Rating Routes*******/

            /*******Coupons Routes*******/
            Route::resource('coupons', 'CouponsController', ['as' => 'admin']);
            Route::post('coupons/get', 'CouponsController@getCoupons')->name('admin.coupons.get');
            /*******Coupons Routes*******/

            /*******Bookings Routes*******/
            Route::post('bookings/get', 'BookingsController@getBooking')->name('admin.bookings.get');
            Route::post('bookings/getTeachers', 'BookingsController@getTeachers')->name('admin.bookings.getTeachers');
            Route::post('bookings/getServices', 'BookingsController@getServices')->name('admin.bookings.getServices');
            Route::post('bookings/changeService', 'BookingsController@changeService')->name('admin.bookings.changeService');
            Route::get('bookings/get-student', 'BookingsController@getStudent')->name('admin.bookings.get.student');
            Route::resource('bookings', 'BookingsController', ['as' => 'admin']);
            Route::post('bookings/set-datepicker', 'BookingsController@setDatePicker')->name('admin.bookings.setDatepicker');
            /*******Bookings Routes*******/

            /*******Orders Routes*******/
            Route::get('orders', 'OrdersController@index')->name('admin.orders');
            Route::post('orders/get', 'OrdersController@getOrders')->name('admin.orders.get');
            Route::get('orders/details/{id}', 'OrdersController@OrdersDetails')->name('admin.orders.details');
            Route::get('orders/re-order/{id}', 'OrdersController@Reorder')->name('admin.orders.reorder');
            Route::get('orders/{id}/edit', 'OrdersController@edit')->name('admin.orders.edit');
            Route::patch('orders/{id}/edit', 'OrdersController@update')->name('admin.orders.update');

            /*******Orders Routes*******/


            /*******Orders Routes*******/
            Route::get('teacher-earnings', 'TeacherEarningsController@index')->name('admin.teacherEarnings');
            Route::post('teacher-earnings/get', 'TeacherEarningsController@getEarnings')->name('admin.teacherEarnings.get');
            /*******Orders Routes*******/

            /*******Facebook Post Routes*******/
            Route::resource('facebook-posts', 'FacebookPostController', ['as' => 'admin']);
            Route::post('facebook-posts/get', 'FacebookPostController@getFacebookPosts')->name('admin.facebook-posts.get');
            /*******Facebook Post Routes*******/

            /*******Setting Routes*******/
            Route::get('settings', 'SettingsController@index')->name('admin.settings.index');
            Route::post('save-settings', 'SettingsController@store')->name('admin.settings.store');
            /*******Setting Routes*******/

            /******* Setting Routes*******/
            Route::get('holiday-setting', 'HolidaySettingsController@index')->name('admin.holiday.setting.index');
            Route::post('save-holiday-setting', 'HolidaySettingsController@store')->name('admin.holiday.setting.store');
            /*******Setting Routes*******/

            /******* Student Lessons Routes*******/
            Route::get('student-lessons', 'StudentLessonsController@index')->name('admin.student.lessons.index');
            Route::get('student-lessons/create', 'StudentLessonsController@create')->name('admin.student.lessons.create');
            Route::post('student-lessons/create', 'StudentLessonsController@store')->name('admin.student.lessons.create');
            Route::post('student-lessons/get', 'StudentLessonsController@getStudentLessons')->name('admin.student.lessons.get');
            Route::get('student-lessons/{id}', 'StudentLessonsController@edit')->name('admin.student.lessons.edit');
            Route::Patch('student-lessons/{id}', 'StudentLessonsController@update')->name('admin.student.lessons.update');
            Route::delete('student-lessons/{id}', 'StudentLessonsController@destroy')->name('admin.student.lessons.destroy');
            Route::post('student-lessons/get-services', 'StudentLessonsController@getServices')->name('admin.student.lessons.getServices');

            /*******Student Lessons Routes*******/

            /******* Admin Calender Routes*******/
            Route::get('calender', 'CalenderController@index')->name('admin.calender.index');
            Route::get('calender/get', 'CalenderController@getCalender')->name('admin.calender.get');
            Route::any('calender/getIcalData', 'CalenderController@getIcalData')->name('admin.calender.getIcalData');

            /******* Admin Calender Routes*******/

            /*******Testimonial Routes*******/
            Route::resource('testimonial', 'TestimonialController', ['as' => 'admin']);
            Route::post('testimonial/get', 'TestimonialController@getTestimonial')->name('admin.testimonial.get');
            /*******Testimonial Routes*******/

			/*******Search Analytics********/
			
			Route::get('search-analytics', 'SearchAnalyticsController@index')->name('admin.search-analytics.index');
            Route::get('search-analytics/download', 'SearchAnalyticsController@search_analytics_download')->name('admin.search-analytics-download');
			/*******Search Analytics********/
			
            /*******Contact-Us Routes*******/
            Route::get('contact-us', 'ContactUsController@index')->name('admin.contact-us.index');
            Route::post('contact-us/get', 'ContactUsController@getContactUs')->name('admin.contact-us.get');
            Route::get('contact-us/{id}', 'ContactUsController@edit')->name('admin.contact-us.edit');
            Route::Patch('contact-us/{id}', 'ContactUsController@update')->name('admin.contact-us.update');
            Route::delete('contact-us/{id}', 'ContactUsController@destroy')->name('admin.contact-us.destroy');
            /*******Contact-Us Routes*******/

            /********* Lessons Dashboard Reports **********/
            Route::get('lesson/reports', 'LessonReports\DashboardController@index')->name('admin.lesson-reports.dashboard');
            Route::post('lesson-reports/dashboard/getReport', 'LessonReports\LessonDashboardController@getReportData')->name('admin.lesson-reports.dashboard.get');
            /********* Lessons Dashboard Reports **********/

            /********* Admin Lesson Reports **********/
            Route::get('lesson-reports/admin-lessons-report', 'LessonReports\AdminLessonController@index')->name('admin.admin-lessons-report.index');
            Route::post('lesson-reports/admin-lessons-report/get', 'LessonReports\AdminLessonController@getLessonReport');

            Route::any('reports/amounts', 'LessonReports\AmountReportController@index')->name('admin.reports.amount.index');
            Route::any('reports/ratings', 'LessonReports\RatingReportController@index')->name('admin.reports.ratings.index');
            Route::any('reports/cancelled', 'LessonReports\CancelReportController@index')->name('admin.reports.cancelled.index');

            /*********  Admin Lesson Reports **********/

            /*******Setting Routes*******/
            Route::get('manage-report-goals', 'LessonReports\ReportSettingsController@index')->name('admin.report.settings.index');
            Route::post('save-report-settings', 'LessonReports\ReportSettingsController@store')->name('admin.report.settings.store');
            /*******Setting Routes*******/

            /******* Student Packages Routes*******/
            Route::resource('student-packages', 'StudentPackagesController', ['as' => 'admin']);
            Route::post('student-packages/get', 'StudentPackagesController@getPackage')->name('admin.student-packages.get');
            Route::get('student-packages/suspend/{id}', 'StudentPackagesController@suspendSubscription')->name('admin.student-packages.suspend');
            Route::get('student-packages/reactivate/{id}', 'StudentPackagesController@reactivateSubscription')->name('admin.student-packages.reactivate');
            /*******Student Packages Routes*******/

            /*******  Student Lesson Record Routes*******/
            Route::get('last-login-teachers', 'LastLoginTeacherController@index')->name('admin.last-login-teachers.index');
            Route::post('last-login-teachers/get', 'LastLoginTeacherController@getRecords')->name('admin.last-login-teachers.get');
            /*******  Student Lesson Record Routes*******/

            /*******  Student Lesson Record Routes*******/
            Route::get('student-lesson-records', 'StudentLessonRecordController@index')->name('admin.student.lesson.records.index');
            Route::get('student-lesson-records/csv', 'StudentLessonRecordController@ExportCsv')->name('admin.student.lesson.records.csv');
            Route::get('student-lesson-records/active_student', 'StudentLessonRecordController@ActiveStudentExportCsv')->name('admin.student.lesson.records.active_student_csv');
            Route::post('get-student-lesson-records', 'StudentLessonRecordController@getLessonRecord')->name('admin.student.get.lesson.records');

            Route::get('student-lesson-records/packages/{id}', 'StudentLessonRecordController@packages')->name('admin.student.lesson.records.package');
            Route::get('student-lesson-records/bookings', 'StudentLessonRecordController@bookings')->name('admin.student.lesson.records.bookings');
			Route::get('student-lesson-records/packagebookings', 'StudentLessonRecordController@packagebookings')->name('admin.student.lesson.records.packagebookings');

            /*******  Student Lesson Record Routes*******/
			
			Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


        });
    });
});

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

//Route::get('db-table/{table}/{column}', 'Student\ShareOnepageController@dbTable');

Route::post('/upload_image', function (Illuminate\Http\Request $request) {

    $CKEditor = $request->get('CKEditor');
    $funcNum = $request->get('CKEditorFuncNum', 1);
    $message = $url = '';
    if ($request->hasFile('upload')) {
        $file = $request->file('upload');
        if ($file->isValid()) {
            $filename = $file->getClientOriginalName();
            $file->move(public_path() . '/ckeditor/images/', $filename);
            $url = Illuminate\Support\Facades\URL::asset('/ckeditor/images/' . $filename);
        } else {
            $message = 'An error occured while uploading the file.';
        }
    } else {
        $message = 'No file uploaded.';
    }

    return "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($funcNum, '$url', '$message');</script>";
});

Route::get('start-drive', 'DriveController@index');
