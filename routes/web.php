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
/*installer*/
Route::Group(['namespace' => 'Installer', 'middleware' => 'installer'], function () {
    Route::get('/install', ['as' => 'website.installer.welcome', 'uses' => 'InstallerController@welcome']);
    Route::get('/install/requirement', ['as' => 'website.installer.requirement', 'uses' => 'InstallerController@requirement']);
    Route::any('/install/config', ['as' => 'website.installer.config', 'uses' => 'InstallerController@config']);
    Route::get('/install/initDB', ['as' => 'website.installer.initDB', 'uses' => 'InstallerController@initDB']);
    Route::any('/install/website', ['as' => 'website.installer.website', 'uses' => 'InstallerController@website']);
    Route::get('/install/finished', ['as' => 'website.installer.finished', 'uses' => 'InstallerController@finished']);
});


Route::get('/', ['middleware' => 'guide.install', 'as' => 'website.index', 'uses' => 'IndexController@index']);
/*问答*/
Route::get('/questions/{category_name?}/{filter?}', ['as' => 'website.ask', 'uses' => 'IndexController@ask'])->where(['filter' => '(newest|hottest|reward|unAnswered)']);

/*标签*/
Route::get('/topics/{category_name?}', ['as' => 'website.topic', 'uses' => 'IndexController@topic']);

/*文章*/
Route::get('/articles/{category_name?}/{filter?}', ['as' => 'website.blog', 'uses' => 'IndexController@blog'])->where(['filter' => '(recommended|newest|hottest)']);

/*用户*/
Route::get('/users', ['as' => 'website.user', 'uses' => 'IndexController@user']);

/*experts*/
Route::get('/experts/{categorySlug?}/{provinceId?}', ['as' => 'website.experts', 'uses' => 'IndexController@experts']);


/*积分商城*/
Route::get('/shop/{categorySlug?}', ['as' => 'website.shop', 'uses' => 'IndexController@shop']);

/*sitemap*/
Route::get('/sitemap', ['as' => 'website.sitemap', 'uses' => 'SiteMapController@index']);


/*用户账号管理，包含用户登录注册等操作*/
Route::Group(['namespace' => 'Account'], function () {
    Route::match(['get', 'post'], 'login', ['as' => 'auth.user.login', 'uses' => 'UserController@login']);
    Route::match(['get', 'post'], 'register', ['as' => 'auth.user.register', 'uses' => 'UserController@register']);
    Route::get('logout', ['as' => 'auth.user.logout', 'uses' => 'UserController@logout']);
    /*密码找回*/
    Route::get('forgetPassword', ['as' => 'auth.user.forgetPassword', 'uses' => 'UserController@forgetPassword']);
    Route::match(['get', 'post'], 'forgetPassword/mobile', ['as' => 'auth.user.findByMobile', 'uses' => 'UserController@findByMobile']);
    Route::match(['get', 'post'], 'forgetPassword/email', ['as' => 'auth.user.findByEmail', 'uses' => 'UserController@findByEmail']);
    Route::match(['get', 'post'], 'findPassword/{token}', ['as' => 'auth.user.findPassword', 'uses' => 'UserController@findPassword']);

    /*用户auth2.0*/
    Route::get('oauth/{type}/login', ['as' => 'auth.oauth.login', 'uses' => 'OauthController@login'])->where(['type' => '(qq|weibo|weixinweb|weixin)']);
    Route::get('oauth/{type}/callback', ['as' => 'auth.oauth.callback', 'uses' => 'OauthController@callback'])->where(['type' => '(qq|weibo|weixinweb|weixin)']);
    Route::get('oauth/register/{auth_id}', ['as' => 'auth.oauth.profile', 'uses' => 'OauthController@profile']);
    Route::post('oauth/register', ['as' => 'auth.oauth.register', 'uses' => 'OauthController@register']);

    /*用户空间首页*/
    Route::get('people/{user_id}', ['as' => 'auth.space.index', 'uses' => 'SpaceController@index'])->where(['user_id' => '[0-9]+']);
    /*我的提问*/
    Route::get('people/{user_id}/questions', ['as' => 'auth.space.questions', 'uses' => 'SpaceController@questions'])->where(['user_id' => '[0-9]+']);
    /*我的回答*/
    Route::get('people/{user_id}/answers', ['as' => 'auth.space.answers', 'uses' => 'SpaceController@answers'])->where(['user_id' => '[0-9]+']);
    /*我的文章*/
    Route::get('people/{user_id}/articles', ['as' => 'auth.space.articles', 'uses' => 'SpaceController@articles'])->where(['user_id' => '[0-9]+']);
    /*我的讲座*/
    Route::get('people/{user_id}/courses/{filter?}', ['as' => 'auth.space.courses', 'uses' => 'SpaceController@courses'])->where(['user_id' => '[0-9]+', 'filter' => '(involved|started)']);

    /*我的粉丝*/
    Route::get('people/{user_id}/followers', ['as' => 'auth.space.followers', 'uses' => 'SpaceController@followers'])->where(['user_id' => '[0-9]+']);
    /*我的关注*/
    Route::get('people/{user_id}/followed/{source_type}', ['as' => 'auth.space.attentions', 'uses' => 'SpaceController@attentions'])->where(['user_id' => '[0-9]+', 'source_type' => '(questions|tags|users)']);
    /*我的收藏*/
    Route::get('people/{user_id}/collected/{source_type}', ['as' => 'auth.space.collections', 'uses' => 'SpaceController@collections'])->where(['user_id' => '[0-9]+', 'source_type' => '(questions|articles|courses)']);

    /*我的金币*/
    Route::get('people/{user_id}/coins', ['as' => 'auth.space.coins', 'uses' => 'SpaceController@coins'])->where(['user_id' => '[0-9]+']);
    /*我的经验*/
    Route::get('people/{user_id}/credits', ['as' => 'auth.space.credits', 'uses' => 'SpaceController@credits'])->where(['user_id' => '[0-9]+']);


    /*动态*/
    Route::Group(['middleware' => 'auth'], function () {
        Route::get('doings/{filter?}', ['as' => 'auth.doing.index', 'uses' => 'DoingsController@index'])->where(['filter' => '(newest|concerned)']);
        Route::get('/user/drafts', ['as' => 'auth.draft.index', 'uses' => 'DraftController@index']);
        Route::any('/user/drafts/destroy/{id}', ['as' => 'auth.draft.destroy', 'uses' => 'DraftController@destroy']);
        Route::any('/user/drafts/cleanAll', ['as' => 'auth.draft.cleanAll', 'uses' => 'DraftController@cleanAll']);
        Route::post('/user/drafts/create/{type}', ['as' => 'auth.draft.create', 'uses' => 'DraftController@create'])->where(['type' => '(question|article|answer)']);
        /*用户举报*/
        Route::post('report', ['as' => 'auth.report.store', 'uses' => 'ReportController@store']);
    });


    /*全局搜索*/
    Route::get('search/show', ['as' => 'auth.search.show', 'uses' => 'SearchController@show']);
    Route::any('search/{filter?}', ['as' => 'auth.search.index', 'uses' => 'SearchController@index'])->where(['filter' => '(all|questions|articles|tags|users|courses)']);

    /*邮箱token验证*/
    Route::get('email/{action}/{token}', ['as' => 'auth.email.verifyToken', 'uses' => 'EmailController@verifyToken'])->where(['action' => '(register|verify)']);


    /*用户排行榜*/

    /*财富榜*/
    Route::get('top/coins', ['as' => 'auth.top.coins', 'uses' => 'TopController@coins']);

    /*回答榜*/
    Route::get('top/answers', ['as' => 'auth.top.answers', 'uses' => 'TopController@answers']);

    /*文章榜*/
    Route::get('top/articles', ['as' => 'auth.top.articles', 'uses' => 'TopController@articles']);


    Route::Group(['middleware' => 'auth'], function () {
        Route::get('sign', ['as' => 'auth.user.sign', 'uses' => 'UserController@sign']);
        Route::get('email/sendToken', ['as' => 'auth.email.sendToken', 'uses' => 'EmailController@sendToken']);
        Route::get('oauth/{type}/unbind', ['as' => 'auth.oauth.unbind', 'uses' => 'OauthController@unbind']);
        /*用户个人信息修改*/
        Route::any('profile/anyBase', ['uses' => 'ProfileController@anyBase'])->name('auth.profile.base');
        Route::post('profile/postAvatar', ['uses' => 'ProfileController@postAvatar'])->name('auth.profile.avatar');
        Route::any('profile/anyPassword', ['uses' => 'ProfileController@anyPassword'])->name('auth.profile.password');
        Route::any('profile/anyEmail', ['uses' => 'ProfileController@anyEmail'])->name('auth.profile.email');
        Route::any('profile/anyMobile', ['uses' => 'ProfileController@anyMobile'])->name('auth.profile.mobile');
        Route::any('profile/anyOauth', ['uses' => 'ProfileController@anyOauth'])->name('auth.profile.oauth');
        Route::any('profile/anyNotification', ['uses' => 'ProfileController@anyNotification'])->name('auth.profile.notification');
        Route::post('/profile/account', ['uses' => 'ProfileController@account'])->name('auth.profile.account');


        /*行家认证*/
        Route::get('authentication/getIndex', ['uses' => 'AuthenticationController@getIndex'])->name('auth.authentication.index');
        Route::any('authentication/anyEdit', ['uses' => 'AuthenticationController@anyEdit'])->name('auth.authentication.edit');
        Route::post('authentication/postStore', ['uses' => 'AuthenticationController@postStore'])->name('auth.authentication.store');

        /*我的通知*/
        Route::get('notifications/getIndex', ['uses' => 'NotificationController@getIndex'])->name('auth.notification.index');
        Route::get('notifications/getReadAll', ['uses' => 'NotificationController@getReadAll'])->name('auth.notification.readAll');

        /*我的私信*/
        Route::get('messages', ['as' => 'auth.message.index', 'uses' => 'MessageController@index']);
        Route::get('message/{user_id}', ['as' => 'auth.message.show', 'uses' => 'MessageController@show'])->where(['user_id' => '[0-9]+']);
        Route::get('message/destroy/{id}', ['as' => 'auth.message.destroy', 'uses' => 'MessageController@destroy'])->where(['id' => '[0-9]+']);
        Route::get('message/destroySession/{id}', ['as' => 'auth.message.destroySession', 'uses' => 'MessageController@destroySession'])->where(['from_user_id' => '[0-9]+']);
        Route::post('message/store', ['as' => 'auth.message.store', 'uses' => 'MessageController@store']);


        /*邀请我回答的问题*/
        Route::get('questionInvitation', ['as' => 'auth.questionInvitation.index', 'uses' => 'QuestionInvitationController@index']);


        /*收藏问题、文章*/

        Route::get('collect/{source_type}/{source_id}', ['as' => 'auth.collection.store', 'uses' => 'CollectionController@store'])->where(['source_type' => '(question|article|course)', 'source_id' => '[0-9]+']);

        /*关注问题、人、标签*/
        Route::get('follow/{source_type}/{source_id}', ['as' => 'auth.attention.store', 'uses' => 'AttentionController@store'])->where(['source_type' => '(question|tag|user)', 'source_id' => '[0-9]+']);


    });

    /*点赞*/
    Route::get('support/{source_type}/{source_id}', ['as' => 'auth.support.store', 'uses' => 'SupportController@store'])->where(['source_type' => '(answer|article|comment)', 'source_id' => '[0-9]+']);
    Route::get('support/check/{source_type}/{source_id}', ['as' => 'auth.support.check', 'uses' => 'SupportController@check'])->where(['source_type' => '(answer|article|comment)', 'source_id' => '[0-9]+']);


});


/*文章模块*/
Route::Group(['namespace' => 'Blog'], function () {

    /*文章查看*/
    Route::get('article/{id}', ['as' => 'blog.article.detail', 'uses' => 'ArticleController@show'])->where(['id' => '[0-9]+']);

    /*需要登录的模块*/
    Route::Group(['middleware' => ['auth', 'ban.ip']], function () {
        /*文章创建*/
        Route::get('article/create', ['as' => 'blog.article.create', 'uses' => 'ArticleController@create']);
        Route::post('article/store', ['middleware' => 'ban.user', 'as' => 'blog.article.store', 'uses' => 'ArticleController@store']);
        Route::get('article/edit/{id}', ['as' => 'blog.article.edit', 'uses' => 'ArticleController@edit'])->where(['id' => '[0-9]+']);
        Route::post('article/update', ['middleware' => 'ban.user', 'as' => 'blog.article.update', 'uses' => 'ArticleController@update']);
    });

});

/*商城模块*/
Route::Group(['namespace' => 'Shop'], function () {

    /*商品详情查看*/
    Route::get('goods/{id}', ['as' => 'shop.goods.detail', 'uses' => 'GoodsController@show'])->where(['id' => '[0-9]+']);

    Route::Group(['middleware' => ['auth', 'ban.ip']], function () {
        /*兑换礼品*/
        Route::POST('goods/exchange', ['as' => 'shop.goods.exchange', 'uses' => 'GoodsController@exchange']);

        /*我的商城兑换记录*/
        Route::get('exchanges', ['as' => 'shop.exchange.index', 'uses' => 'ExchangeController@index']);
    });

});


/*加载省份城市信息*/
Route::get('ajax/loadCities/{province_id}', ['as' => 'website.ajax.loadCities', 'uses' => 'AjaxController@loadCities'])->where(['province_id' => '[0-9]+']);
/*加载未读通知数目*/
Route::get('ajax/unreadNotifications', ['as' => 'website.ajax.unreadNotifications', 'uses' => 'AjaxController@unreadNotifications']);
Route::get('ajax/loadTags', ['as' => 'website.ajax.loadTags', 'uses' => 'AjaxController@loadTags']);

Route::get('ajax/loadUsers', ['middleware' => 'auth', 'as' => 'website.ajax.loadUsers', 'uses' => 'AjaxController@loadUsers']);
Route::get('ajax/loadInviteUsers', ['middleware' => 'auth', 'as' => 'website.ajax.loadInviteUsers', 'uses' => 'AjaxController@loadInviteUsers']);

/*加载未读私信数目*/
Route::get('ajax/unreadMessages', ['as' => 'website.ajax.unreadMessages', 'uses' => 'AjaxController@unreadMessages']);
Route::post('ajax/sendSmsCode', ['as' => 'website.ajax.sendSmsCode', 'uses' => 'AjaxController@sendSmsCode']);


Route::get('image/avatar/{avatar_name}', ['as' => 'website.image.avatar', 'uses' => 'ImageController@avatar'])->where(['avatar_name' => '[0-9]+_(small|middle|big|origin).jpg']);
Route::get('image/show/{image_name}', ['as' => 'website.image.show', 'uses' => 'ImageController@show']);
Route::post('attach/upload', ['as' => 'website.attach.upload', 'uses' => 'AttachController@upload']);

Route::Group(['middleware' => 'auth'], function () {
    Route::post('image/upload', ['as' => 'website.image.upload', 'uses' => 'ImageController@upload']);
    Route::get('attach/download/{name}', ['as' => 'website.attach.download', 'uses' => 'AttachController@download']);
});

Route::get('test', ['uses' => 'IndexController@test']);
