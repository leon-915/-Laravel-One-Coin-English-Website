<?php
use App\Http\Middleware\Loggedinteachers;

Route::group(['middleware' => [Loggedinteachers::class]], function () {
Route::get('teachers', 'TeacherController@index')->name('front.teachers');

Route::prefix('teacher')->group(function () {
    Route::namespace('Teacher')->group(function () {
        Route::get('recruitment', 'RegisterController@recruitment')->name('teachers.register.recruitment');
        Route::get('register', 'RegisterController@index')->name('teachers.register.index');
        Route::post('register-user', 'RegisterController@store')->name('teachers.register.store');
        Route::post('register/email-exists', 'RegisterController@checkEmailAlready')->name('teachers.register.email.exist');

        Route::get('register/step-2/{token}', 'RegisterController@step2VerifyUser')->name('teachers.register.step2');
        Route::post('register/step-2/confirm', 'RegisterController@step2ConfirmUser')->name('teachers.register.step2.confirm');

        Route::get('public/profile/{id}', 'PublictProfileController@index')->name('teachers.public.profile');
        Route::any('rating', 'PublictProfileController@storeRating')->name('teachers.rating');
        Route::any('favorite', 'PublictProfileController@favorite')->name('teachers.favorite');
        Route::any('unfavorite', 'PublictProfileController@unfavorite')->name('teachers.unfavorite');

        Route::group(['middleware' => ['auth']], function () {
            /* Profile Routes */
            Route::get('profile', 'ProfileController@index')->name('teachers.profile.index');
            Route::post('profile/save', 'ProfileController@store')->name('teachers.profile.save');
            Route::post('profile/info/save', 'ProfileController@saveInfo')->name('teachers.profile.info.save');
            Route::get('profile/change-password', 'ProfileController@showChangePassword')->name('teachers.profile.change.password');
            Route::get('profile/delete-account', 'ProfileController@deleteAccount')->name('teachers.profile.delete.account');
            Route::post('profile/update-password', 'ProfileController@changePassword')->name('teachers.profile.update.password');
            Route::post('profile/refer-earn-reward', 'ProfileController@ReferEarnReward')->name('teachers.profile.refer.earn.reward');
            Route::post('deletemedia', 'ProfileController@deletemedia')->name('teachers.delete.media');


            /* My Account Settings Routes */
            Route::get('settings', 'SettingsController@index')->name('teachers.settings.index');
            Route::post('get-schedule', 'SettingsController@getSchedule')->name('teachers.settings.get.schedule');
            Route::post('update-schedule', 'SettingsController@updateSchedule')->name('teachers.settings.update.schedule');

            Route::post('get-facebook-post', 'SettingsController@getFacebookPost')->name('teachers.settings.get.facebook.post');
            Route::post('get-facebook-post-list', 'SettingsController@getFacebookPostList')->name('teachers.settings.get.facebook.post.list');
            Route::any('store-facebook-post', 'SettingsController@storeFacebookPost')->name('teachers.settings.store.facebook.post');
            Route::get('edit-facebook-post/{id}', 'SettingsController@editFacebookPost')->name('teacher.facebook.post.edit');
            Route::get('delete-facebook-post/{id}', 'SettingsController@deleteFacebookPost')->name('teacher.facebook.post.delete');

            Route::post('get-lessons', 'SettingsController@getLessons')->name('teachers.settings.get.lessons');
            Route::post('get-lessons-list', 'SettingsController@getLessonsList')->name('teachers.settings.get.lessons.list');
            Route::get('edit-lesson/{id}', 'SettingsController@editLesson')->name('teacher.settings.lesson.edit');
            Route::post('update-lesson/{id}', 'SettingsController@updateLesson')->name('teacher.settings.lesson.update');

            Route::post('get-filtered-record', 'SettingsController@getFilteredRecord')->name('teachers.settings.get.filtered.record');

            Route::post('get-calender', 'SettingsController@getCalender')->name('teachers.settings.get.calender');


            /* Teacher Dashboard Routes */
            Route::get('dashboard', 'DashboardController@index')->name('teachers.dashboard.index');
            
            Route::post('get-tops', 'DashboardController@getTops')->name('teachers.dashboard.get.tops');
			
			Route::post('get-pdfs', 'DashboardController@getAllPdfs')->name('teachers.dashboard.get.pdfs');
			
            Route::post('get-onepage', 'DashboardController@getOnepage')->name('teachers.dashboard.get.onepage');
            Route::post('get-keywords', 'DashboardController@getKeywords')->name('teachers.dashboard.get.keywords');
            Route::post('start-session', 'DashboardController@startSession')->name('teachers.dashboard.start.session');
            Route::post('auto-save', 'DashboardController@autoSave')->name('teachers.dashboard.auto.save');
            Route::post('auto-save-filter-point', 'DashboardController@autoSaveFilterPoint')->name('teachers.dashboard.auto.save.filter.point');
            Route::post('edit-item', 'DashboardController@editItem')->name('teachers.dashboard.edit.item');
            Route::post('update-points', 'DashboardController@updatePoints')->name('teachers.dashboard.update.points');
            Route::post('wrap-lesson', 'DashboardController@wrapLesson')->name('teachers.dashboard.onepage.wraplesson');
            Route::post('update-status', 'DashboardController@updateStatus')->name('teachers.dashboard.onepage.update.status.data');

            /* Update student level */
            Route::post('onepage/update-level', 'DashboardController@updateStudentLevel')->name('teachers.dashboard.onepage.updatelevel');

            Route::post('get-keyword/search', 'DashboardController@getKeywordSearch')->name('teachers.dashboard.get.keywords.search');
            Route::post('get-onepage/search', 'DashboardController@getOnepageSearch')->name('teachers.dashboard.get.keywords.search.onepage');
            Route::post('get-keyword-onepage/search', 'DashboardController@getKeywordOnepageSearch')->name('teachers.dashboard.get.keywords.search.keywordonepage');
            Route::post('get-keywords-list', 'DashboardController@getKeywordList')->name('teachers.dashboard.get.keywords.list');
            Route::post('get-onepage-list', 'DashboardController@getOnepageList')->name('teachers.dashboard.get.onepage.list');
            Route::post('get-keyword-onepage-list', 'DashboardController@getKeywordOnepageList')->name('teachers.dashboard.get.keywordonepage.list');
			
			Route::any('getsearch', 'DashboardController@getSearch')->name('teachers.dashboard.getsearch');
			
            /**Bid Job*/
            Route::get('joblist', 'BidJobController@jobList')->name('teachers.job.list');
            Route::get('jobbidhistory', 'BidJobController@jobBidHistory')->name('teachers.job.history');
            Route::any('bid_accept/{id}', 'BidJobController@acceptBid')->name('teachers.job.bidaccept');
            Route::any('job-bid-history', 'BidJobController@jobBidTable')->name('teachers.job.bid.history');
            Route::any('history-detail/{id}', 'BidJobController@historyDetail')->name('teachers.post.job.historyDetail');
            Route::post('make-bid', 'BidJobController@makebid')->name('teachers.make.bid');
            Route::any('add-trans', 'BidJobController@addTranslation')->name('teachers.add.translation');


            /**Google Drive*/
            Route::any('getfolderData', 'DashboardController@getFolderData')->name('teachers.dashboard.get.folderdata');
            Route::any('uploadfiletoFolder', 'DashboardController@uploadFile')->name('teachers.dashboard.get.uploadfile');


            Route::any('testIcal', 'SettingsController@testIcal');
            Route::any('testdata', 'SettingsController@testdata');
        });
    });
});
});

