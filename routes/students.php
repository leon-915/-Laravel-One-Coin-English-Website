<?php

Route::get('onepage-report/{id}', 'Student\ShareOnepageController@index')->name('students.share.onepage.index');



//Product Route//
Route::get('aspire-coaching-pricing', 'Student\CartController@aspireCoachingPricing')->name('students.aspire.product.index');
Route::get('casual-conversation-pricing', 'Student\CartController@casualConversationPricing')->name('students.casual.product.index');
Route::get('accent-kids-pricing', 'Student\CartController@accentKidsPricing')->name('students.kids.product.index');
			
Route::prefix('student')->group(function () {
    Route::namespace('Student')->group(function () {
        Route::get('register', 'RegisterController@index')->name('students.register.index');
        Route::post('register', 'RegisterController@store')->name('students.register.store');

        Route::group(['middleware' => ['auth']], function () {
            Route::get('register/step-two/{id}', 'RegisterController@stepTwo')->name('student.register.stepTwo');
            Route::post('register/store-step-two', 'RegisterController@storeStepTwo')->name('students.register.storeStepTwo');

            //Route::get('register/step-three/{id}', 'RegisterController@stepThree')->name('student.register.stepThree');
            Route::get('register/step-three', 'RegisterController@stepThree')->name('student.register.stepThree');
            Route::post('register/store-step-three', 'RegisterController@storeStepThree')->name('students.register.storeStepThree');

            Route::post('register/get-locations', 'RegisterController@getLocations')->name('student.register.getLocations');
            Route::post('register/set-datepicker', 'RegisterController@setDatePicker')->name('student.register.setDatepicker');
            Route::post('register/get-services', 'RegisterController@getServices')->name('student.register.getServices');

            Route::get('profile', 'ProfileController@index')->name('students.profile.index');
            Route::post('profile', 'ProfileController@update')->name('students.profile.update');
            Route::post('profile/earn-reward', 'ProfileController@EarnReward')->name('students.profile.earn.reward');
            Route::post('profile/share-gift-point', 'ProfileController@ShareGiftPoint')->name('students.profile.share.giftpoint');
            Route::post('profile/share-lesson-record', 'ProfileController@ShareLessonRecord')->name('students.profile.share.lesson_record');

            Route::get('account', 'AccountController@index')->name('students.account.index');
            Route::post('account/payment', 'AccountController@payment')->name('students.account.payment');

            Route::any('package/pay-with-paypal', 'AccountController@paypalPayment')->name('students.account.paypalPayment');
            Route::any('package/paypal-success', 'AccountController@paypalSuccess')->name('students.account.paypalSuccess');
            Route::any('package/paypal-fail', 'AccountController@paypalFail')->name('students.account.paypalFail');

            Route::any('package/subscription', 'SubscriptionController@paypalPayment')->name('students.package.subscription');
            Route::any('package/subscription/success', 'SubscriptionController@paypalSuccess')->name('students.package.subscription.success');
            Route::any('package/subscription/cancel', 'SubscriptionController@paypalFail')->name('students.package.subscription.cancel');

			Route::any('suspendSubscription', 'SubscriptionController@suspendSubscription');
			Route::any('reactivateSubscription', 'SubscriptionController@reactivateSubscription');



            Route::get('on-break-plan', 'AccountController@onBreak')->name('students.account.onbreak');
            Route::post('on-break-plan/payment', 'AccountController@onBreakPayment')->name('students.account.onbreak.payment');

            Route::get('dashboard', 'DashboardController@index')->name('students.dashboard.index');

            Route::get('reservation', 'ReservationController@index')->name('students.reservation.index');

            Route::post('reservation/store', 'ReservationController@store')->name('students.reservation.store');
            Route::post('reservation/changeService', 'ReservationController@changeService')->name('student.reservation.changeService');
            Route::post('reservation/changeLocation', 'ReservationController@changeLocation')->name('student.reservation.changeLocation');
            Route::post('teacher-booking-profile', 'ReservationController@teacherProfile')->name('students.reservation.booking.teacher.profile');

            Route::post('get-orders', 'DashboardController@getOrder')->name('student.dashboard.get.orders');
            Route::post('get-orders-list', 'DashboardController@getOrderData')->name('students.dashboard.get.orders.list');
            Route::any('order-detail/{id}', 'DashboardController@orderDetail');

            Route::any('current-course', 'DashboardController@currentCourse')->name('student.dashboard.get.current');
            Route::any('current-course/get-booking', 'DashboardController@currentCourseBookings')->name('student.dashboard.get.current.detail.bookings');
            Route::any('current-package/get-booking', 'DashboardController@currentPackageBookings')->name('student.dashboard.get.current.detail.bookings');
            Route::any('current-course/booking-detail/{id}', 'DashboardController@currentCourseDetail')->name('student.dashboard.get.current.detail');
            Route::any('current-course-edit/{id}', 'DashboardController@changeLocation')->name('student.dashboard.changeLocation');
            Route::any('current-course-edit-teacher', 'DashboardController@changeTeacher')->name('student.dashboard.changeTeacher');
            Route::post('current-course/update-booking/{id}', 'DashboardController@updateService')->name('students.dashboard.update.service');
            Route::any('update-status/{id}', 'DashboardController@cacelBooking')->name('student.dashboard.update.status');


            Route::post('previous-course', 'DashboardController@previousCourse')->name('student.dashboard.get.previous');
            Route::any('previous-course/booking-detail/{id}', 'DashboardController@previousCourseDetail')->name('student.dashboard.get.previous.detail');
            Route::post('get-previous-course-list', 'DashboardController@getPreviousCourseData')->name('students.dashboard.get.previous.list');
            Route::any('get-previous-course-detail', 'DashboardController@getPreviousCourseDetail')->name('students.dashboard.get.previous.detail');

            Route::post('classRoomHtml', 'AccountController@classRoomHtml')->name('student.account.get.class');

			
			
            //Cart Routes//
            Route::get('cart', 'CartController@index')->name('students.cart.index');
            Route::any('add-cart/{id}', 'CartController@addToCart')->name('students.cart.addcart');
            Route::any('delete-cart/{id}', 'CartController@deleteFromCart')->name('students.cart.deletecart');
            Route::any('validate-coupon', 'CartController@validateCoupon')->name('students.cart.validateCoupon');
            Route::any('pay-with-stripe', 'CartController@paymentStripe')->name('students.cart.stripePayment');
            Route::any('pay-with-paypal', 'CartController@paypalPayment')->name('students.cart.paypalPayment');
            Route::any('pay-with-bank', 'CartController@bankPayment')->name('students.cart.bankPayment');
            Route::any('paypal-success', 'CartController@paypalSuccess')->name('students.cart.paypalSuccess');
            Route::any('paypal-fail', 'CartController@paypalFail')->name('students.cart.paypalFail');

            //Post New Jobs Routes//
            Route::get('job-post', 'JobPostController@index')->name('students.post.job.index');
            Route::get('job-post-form', 'JobPostController@postJobForm')->name('students.post.job.form');
            Route::any('job-post-create', 'JobPostController@postJobStore')->name('students.post.job.create');
            Route::any('job-post-history', 'JobPostController@jobhistory')->name('students.post.job.history');
            Route::any('job-post-table', 'JobPostController@jobhistoryTable')->name('students.post.job.historytable');
            Route::any('history-detail/{id}', 'JobPostController@historyDetail')->name('students.post.job.historyDetail');
            Route::any('bid-detail/{id}', 'JobPostController@bidDetail')->name('students.post.job.bidDetail');
            Route::any('accept-bid/{id}', 'JobPostController@acceptBid')->name('students.post.job.accept');
            Route::any('reject-bid/{id}', 'JobPostController@rejectBid')->name('students.post.job.reject');
            Route::any('rating', 'JobPostController@addRating')->name('students.post.job.rating');


            /* Onepage Routes */
            Route::get('onepage', 'OnepageController@index')->name('students.onepage.index');
            Route::get('onepage/generate-pdf', 'OnepageController@generatePDF')->name('students.onepage.generate.pdf');


            /* Keywords Routes */
            Route::get('keywords', 'KeywordsController@index')->name('students.keywords.index');
            Route::post('get-keywords-list', 'KeywordsController@getKeywordList')->name('students.get.keywords.list');
            Route::post('get-onepage-list', 'KeywordsController@getOnepageList')->name('students.get.onepage.list');
            Route::post('get-keyword/search', 'KeywordsController@getKeywordSearch')->name('students.get.keywords.search');
            Route::post('get-onepage/search', 'KeywordsController@getOnepageSearch')->name('students.get.keywords.search.onepage');

            Route::post('get-keyword-onepage/search', 'KeywordsController@getKeywordOnepageSearch')->name('students.get.keywords.search.keywordonepage');
            Route::post('get-keyword-onepage-list', 'KeywordsController@getKeywordOnepageList')->name('students.get.keywordonepage.list');

            /**Test*/
            Route::get('testdrive', 'CartController@testdrive');


            /**Google Drive*/
            Route::any('getfolderData', 'OnepageController@getFolderData')->name('students.dashboard.get.folderdata');
            Route::any('uploadfiletoFolder', 'OnepageController@uploadFile')->name('students.dashboard.get.uploadfile');
			
			Route::post('createCustomer', 'RegisterController@createCustomer')->name('students.createCustomer.index');
			Route::post('bookSession', 'RegisterController@bookSession')->name('students.bookSession.index');
			Route::get('sessions', 'SessionController@index')->name('students.session.index');
			Route::post('getbookings', 'SessionController@getbookings')->name('student.sessions.getbookings');
			
			Route::any('teacheravailability', 'SessionController@teacheravailability')->name('student.teacheravailability');
			Route::any('favoritelp', 'SessionController@favorite')->name('student.favoritelp');
			Route::any('unfavoritelp', 'SessionController@unfavorite')->name('student.unfavoritelp');
			Route::any('updatelessonstatus', 'SessionController@updatelessonstatus')->name('student.sessions.updatelessonstatus');
			Route::any('extendlesson', 'SessionController@extendlesson')->name('student.sessions.extendlesson');
			
			Route::get('directCharge', 'SessionController@directCharge')->name('student.sessions.directCharge');
			Route::any('ocerating', 'SessionController@storeOceRating')->name('student.ocerating');
		});
    });
});
