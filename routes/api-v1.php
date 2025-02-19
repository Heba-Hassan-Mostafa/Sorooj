<?php

use App\Http\Controllers\Api\V1\Client\Audios\AudioCategoryController;
use App\Http\Controllers\Api\V1\Client\Audios\AudioLibraryController;
use App\Http\Controllers\Api\V1\Client\AuthController;
use App\Http\Controllers\Api\V1\Client\Blogs\BlogCategoryController;
use App\Http\Controllers\Api\V1\Client\Blogs\BlogController;
use App\Http\Controllers\Api\V1\Client\Books\BookCategoryController;
use App\Http\Controllers\Api\V1\Client\Books\BookController;
use App\Http\Controllers\Api\V1\Client\ContactController;
use App\Http\Controllers\Api\V1\Client\Courses\CategoryController;
use App\Http\Controllers\Api\V1\Client\Courses\CourseController;
use App\Http\Controllers\Api\V1\Client\FavoriteController;
use App\Http\Controllers\Api\V1\Client\HomePage\FatwaAnswerController;
use App\Http\Controllers\Api\V1\Client\HomePage\FatwaQuestionController;
use App\Http\Controllers\Api\V1\Client\HomePage\MostViewedController;
use App\Http\Controllers\Api\V1\Client\HomePage\SearchController;
use App\Http\Controllers\Api\V1\Client\HomePage\SliderController;
use App\Http\Controllers\Api\V1\Client\HomePage\StatisticsController;
use App\Http\Controllers\Api\V1\Client\HomePage\SubscriberController;
use App\Http\Controllers\Api\V1\Client\HomePage\UpcomingEventController;
use App\Http\Controllers\Api\V1\Client\HomePage\VideoController;
use App\Http\Controllers\Api\V1\Client\ManagementMemberController;
use App\Http\Controllers\Api\V1\Client\SocialiteController;
use App\Http\Controllers\Api\V1\Client\StaticPageController;
use App\Http\Controllers\Api\V1\Client\Videos\VideoCategoryController;
use App\Http\Controllers\Api\V1\Client\Videos\VideoLibraryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix("auth")->group(function () {
    Route::middleware(["auth:sanctum"])->group(function () {
        Route::post('resend-otp', [AuthController::class, 'resendOTP']);
        Route::post('verify-otp', [AuthController::class, 'verifyOTP']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('profile', [AuthController::class, 'profile']);
        Route::post('can-change-mobile', [AuthController::class, 'canChangeMobile']);
        Route::post('change-mobile', [AuthController::class, 'changeMobile']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
        Route::post('update-profile', [AuthController::class, 'updateProfile']);
        Route::delete('delete-account', [AuthController::class, 'deleteAccount']);
    });
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('validate-mobile-email', [AuthController::class, 'validateMobileorEmail']);
    Route::post('send-otp', [AuthController::class, 'sendOTP']);

    Route::get('/{provider}/redirect', [SocialiteController::class, 'loginSocial'])
        ->name('socialite.redirect');

    Route::get('/{provider}/callback', [SocialiteController::class, 'callbackSocial'])
        ->name('socialite.callback');
});

        //courses
        Route::group(['prefix' => 'courses', 'as' => 'courses.'], function () {

            //categories
            Route::get('categories', [CategoryController::class, 'index'])->name('category.index');
            //index
            Route::get('/', [CourseController::class, 'index'])->name('courses.index');
            //suggested
            Route::get('/suggested-courses', [CourseController::class, 'suggestedCourses'])->name('suggested-courses');

            //show
            Route::get('/{slug}', [CourseController::class, 'show'])->name('courses.show');

            //comments
            Route::post('/add-comment/{courseId}', [CourseController::class, 'addComment'])
                ->name('add-comment')->middleware('auth:sanctum');
            //favorite
            Route::post('/toggle-favorite/{courseId}', [CourseController::class, 'toggleFavorite'])
                ->name('toggle-favorite')->middleware('auth:sanctum');
            //subscription
            Route::post('/add-subscription/{courseId}', [CourseController::class, 'addSubscription'])
                ->name('add-subscription')->middleware('auth:sanctum');

            //set view count
            Route::post('/set-view-count/{slug}', [CourseController::class, 'setCourseViewCount'])->name('set-view-count');

        });


        //books
        Route::group(['prefix' => 'books', 'as' => 'books.'], function () {

            //categories
            Route::get('categories', [BookCategoryController::class, 'index'])->name('category.index');
            //index
            Route::get('/', [BookController::class, 'index'])->name('index');
            //suggested
            Route::get('/suggested-books', [BookController::class, 'suggestedBooks'])->name('suggested-books');
            //show
            Route::get('/{slug}', [BookController::class, 'show'])->name('show');

            //comments
            Route::post('/add-comment/{courseId}', [BookController::class, 'addComment'])
                ->name('add-comment')->middleware('auth:sanctum');
            //favorite
            Route::post('toggle-favorite/{courseId}', [BookController::class, 'toggleFavorite'])
                ->name('toggle-favorite')->middleware('auth:sanctum');

            //set view count
            Route::post('/set-view-count/{slug}', [BookController::class, 'setBookViewCount'])->name('set-view-count');

            //set download count
            Route::post('/set-download-count/{slug}', [BookController::class, 'setBookDownloadCount'])->name('set-download-count');

        });

            //blogs
            Route::group(['prefix' => 'blogs', 'as' => 'blogs.'], function () {

                //categories
                Route::get('categories', [BlogCategoryController::class, 'index'])->name('category.index');
                //index
                Route::get('/', [BlogController::class, 'index'])->name('blogs.index');
                //suggested
                Route::get('/suggested-blogs', [BlogController::class, 'suggestedBlogs'])->name('suggested-blogs');

                //show
                Route::get('/{slug}', [BlogController::class, 'show'])->name('blogs.show');

                //comments
                Route::post('/add-comment/{blogId}', [BlogController::class, 'addComment'])
                    ->name('add-comment')->middleware('auth:sanctum');
                //favorite
                Route::post('/toggle-favorite/{blogId}', [BlogController::class, 'toggleFavorite'])
                    ->name('toggle-favorite')->middleware('auth:sanctum');

                //set view count
                Route::post('/set-view-count/{slug}', [BlogController::class, 'setBlogViewCount'])->name('set-view-count');

                //set download count
                Route::post('/set-download-count/{slug}', [BlogController::class, 'setBlogDownloadCount'])->name('set-download-count');

            });
            //videos library
            Route::group(['prefix' => 'videos', 'as' => 'videos.'], function () {

                //categories
                Route::get('/categories', [VideoCategoryController::class, 'index'])->name('category.index');
                //index
                Route::get('/', [VideoLibraryController::class, 'index'])->name('index');
            });

            //audios library
            Route::group(['prefix' => 'audios', 'as' => 'audios.'], function () {

                //categories
                Route::get('/categories', [AudioCategoryController::class, 'index'])->name('category.index');
                //index
                Route::get('/', [AudioLibraryController::class, 'index'])->name('index');
                //suggested
                Route::get('/suggested-audios', [AudioLibraryController::class, 'suggestedAudios'])->name('suggested-audios');

                //show
                Route::get('/{slug}', [AudioLibraryController::class, 'show'])->name('audios.show');

                //set view count
                Route::post('/set-view-count/{slug}', [AudioLibraryController::class, 'setAudioViewCount'])->name('set-view-count');

                //set download count
                Route::post('/set-download-count/{slug}', [AudioLibraryController::class, 'setAudioDownloadCount'])->name('set-download-count');


            });
        # fatwa
            Route::group(['prefix' => 'fatwa', 'as' => 'fatwa.'], function () {

                //get-questions-answers
                Route::get('get-questions', [FatwaQuestionController::class, 'index'])->name('get-questions.index');
                //get-answer
                Route::get('/{slug}', [FatwaAnswerController::class, 'show'])->name('fatwaAnswers.show');
            });

            Route::group(['prefix' => 'home', 'as' => 'home.'], function () {
                //slider
                Route::get('slider', [SliderController::class, 'index'])->name('slider.index');
                //UpcomingEvent
                Route::get('upcoming-events', [UpcomingEventController::class, 'index'])->name('upcoming-events.index');
                //Videos
                Route::get('videos', [VideoController::class, 'index'])->name('videos.index');
                //most-viewed
                Route::get('most-viewed', [MostViewedController::class, 'index'])->name('most-viewed.index');
                //get-questions-answers
                Route::get('get-questions-answers', [FatwaQuestionController::class, 'index'])->name('get-questions-answers.index');
                //add-fatwa
                Route::post('add-fatwa', [FatwaQuestionController::class, 'store'])
                    ->name('add-fatwa.store')->middleware('auth:sanctum');
                //add-subscriber
                Route::post('add-subscriber', [SubscriberController::class, 'store'])
                    ->name('add-subscriber.store');
                //statistics
                Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');

                //search
                Route::post('search', [SearchController::class, 'search'])->name('search');



            });
            //contact-us
            Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');

            Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {

                //get-courses-favorites
                Route::get('/get-all-favorites', [FavoriteController::class, 'index'])
                    ->name('get-all-favorites')->middleware('auth:sanctum');
            //get-courses-favorites
            Route::get('/get-courses-favorites', [CourseController::class, 'getFavorites'])
                ->name('get-courses-favorites')->middleware('auth:sanctum');

                //get-courses-favorites
                Route::get('/get-courses-subscriptions', [CourseController::class, 'getSubscriptions'])
                    ->name('get-courses-subscriptions')->middleware('auth:sanctum');

                //get-books-favorites
                Route::get('/get-books-favorites', [BookController::class, 'getFavorites'])
                    ->name('get-books-favorites')->middleware('auth:sanctum');

                //get-questions
                Route::get('/get-my-questions', [FatwaQuestionController::class, 'getMyQuestions'])
                    ->name('get-my-questions')->middleware('auth:sanctum');

            });

            Route::group(['prefix' => 'static-pages'], function () {

                Route::get('about-center', [StaticPageController::class, 'getAboutCenter']);
                Route::get('vision', [StaticPageController::class, 'getVision']);
                Route::get('message', [StaticPageController::class, 'getMessage']);
                Route::get('general-objectives', [StaticPageController::class, 'getGeneralObjectives']);
                Route::get('tracks-center-areas', [StaticPageController::class, 'getTracksCenterAreas']);
                Route::get('center-mechanism', [StaticPageController::class, 'getCenterMechanism']);
                Route::get('social-contacts', [StaticPageController::class, 'getContactsInfo']);
                Route::get('privacy-policy', [StaticPageController::class, 'getPrivacyPolicy']);
                Route::get('terms-conditions', [StaticPageController::class, 'getTermsAndConditions']);
                Route::get('delete-account', [StaticPageController::class, 'getDeleteAccount']);
                Route::get('keywords', [StaticPageController::class, 'getKeywords']);
                Route::get('description', [StaticPageController::class, 'getDescription']);
                Route::get('management-members', [ManagementMemberController::class, 'index']);
                Route::get('hide-section-members', [StaticPageController::class, 'getHideSectionMembers']);

            });

            Route::group(['prefix' => 'live'], function () {
                Route::get('youtube-live', [StaticPageController::class, 'getYoutubeLive']);
                Route::get('telegram-live', [StaticPageController::class, 'getTelegramLive']);
                Route::get('facebook-live', [StaticPageController::class, 'getFacebookLive']);

                Route::get('mixlr-live', [StaticPageController::class, 'getMixlrLive']);
            });

