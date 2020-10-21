<?php
Route::prefix('cron')->group(function () {
    Route::namespace('Cron')->group(function () {
        Route::get('subscription_expiration', 'CronController@subscription_expiration');
        Route::get('package_expiration', 'CronController@package_expiration');
        Route::get('book_next_appointment', 'CronController@book_next_appointment');
        Route::get('book_first_subscription_appointment', 'CronController@book_first_subscription_appointment');
        Route::get('book_first_package_appointment', 'CronController@book_first_package_appointment');
        Route::get('onbreak_expiration', 'CronController@onbreak_expiration');
        Route::get('update_rolledover_lessons', 'CronController@update_rolledover_lessons');
        Route::get('update_line_token', 'CronController@update_line_token');
        Route::get('update_lesson_extension', 'CronController@update_lesson_extension');
        Route::get('update_active_students', 'CronController@update_active_students');
        Route::get('creategdrive', 'CronController@creategdrive');
        Route::get('updategdrive', 'CronController@updategdrive');
        Route::get('appointment_reminder', 'CronController@appointmentReminder');
        
    });
});

