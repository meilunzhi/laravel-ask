<?php
/*后台管理部分处理*/
Route::Group(['prefix'=>'admin','namespace'=>'Admin','middleware' =>['auth','auth.admin','operation.log','ban.ip']],function(){


    /*用户登陆*/
    Route::match(['get','post'],'login',['as'=>'admin.account.login','uses'=>'AccountController@login']);


    /*用户退出*/
    Route::get('logout',['as'=>'admin.account.logout','uses'=>'AccountController@logout']);

    Route::get('system/index',['as'=>'admin.system.index','uses'=>'SystemController@index']);
    Route::post('system/upgrade',['as'=>'admin.system.upgrade','uses'=>'SystemController@upgrade']);
    Route::post('system/adjust',['as'=>'admin.system.adjust','uses'=>'SystemController@adjust']);
    Route::any('system/import',['as'=>'admin.system.import','uses'=>'SystemController@import']);

    /*首页*/
    Route::resource('index', 'IndexController', ['as'=>'admin','only' => ['index']]);
    Route::get('index/sidebar',['as'=>'sidebar','uses'=>'IndexController@sidebar']);

    /*权限管理*/
    Route::post('permission/destroy',['as'=>'admin.permission.destroy','uses'=>'PermissionController@destroy']);
    Route::resource('permission', 'PermissionController',['as'=>'admin','except' => ['show','destroy']]);

    /*角色管理*/
    Route::post('role/destroy',['as'=>'admin.role.destroy','uses'=>'RoleController@destroy']);
    Route::post('role/permission',['as'=>'admin.role.permission','uses'=>'RoleController@permission']);
    Route::resource('role', 'RoleController',['as'=>'admin','except' => ['show','destroy']]);

    /*用户删除*/
    Route::post('user/destroy',['as'=>'admin.user.destroy','uses'=>'UserController@destroy']);
    /*用户审核*/
    Route::post('user/verify',['as'=>'admin.user.verify','uses'=>'UserController@verify']);
    /*用户管理*/
    Route::resource('user', 'UserController',['as'=>'admin','except' => ['show','destroy']]);

    /*认证管理*/
    Route::post('authentication/destroy',['as'=>'admin.authentication.destroy','uses'=>'AuthenticationController@destroy']);
    Route::post('authentication/verify',['as'=>'admin.authentication.verify','uses'=>'AuthenticationController@verify']);
    Route::post('authentication/recommend',['as'=>'admin.authentication.recommend','uses'=>'AuthenticationController@recommend']);
    /*修改分类核*/
    Route::post('authentication/changeCategories',['as'=>'admin.authentication.changeCategories','uses'=>'AuthenticationController@changeCategories']);
    Route::resource('authentication', 'AuthenticationController',['as'=>'admin','except' => ['show','destroy']]);

    /*站点设置*/
    Route::any('setting/website',['as'=>'admin.setting.website','uses'=>'SettingController@website']);
    /*邮箱设置*/
    Route::any('setting/email',['as'=>'admin.setting.email','uses'=>'SettingController@email']);
    /*时间设置*/
    Route::any('setting/time',['as'=>'admin.setting.time','uses'=>'SettingController@time']);
    /*注册设置*/
    Route::any('setting/register',['as'=>'admin.setting.register','uses'=>'SettingController@register']);
    /*防灌水*/
    Route::any('setting/irrigation',['as'=>'admin.setting.irrigation','uses'=>'SettingController@irrigation']);
    /*积分设置*/
    Route::any('setting/credits',['as'=>'admin.setting.credits','uses'=>'SettingController@credits']);
    /*SEO设置*/
    Route::any('setting/seo',['as'=>'admin.setting.seo','uses'=>'SettingController@seo']);
    /*功能定义*/
    Route::any('setting/custom',['as'=>'admin.setting.custom','uses'=>'SettingController@custom']);
    /*功能定义*/
    Route::any('setting/attach',['as'=>'admin.setting.attach','uses'=>'SettingController@attach']);

    /*xunsearch整合*/
    Route::any('setting/xunSearch',['as'=>'admin.setting.xunSearch','uses'=>'SettingController@xunSearch']);
    /*oauth2.0*/
    Route::any('setting/oauth',['as'=>'admin.setting.oauth','uses'=>'SettingController@oauth']);

    /*alidayu*/
    Route::any('setting/sms/{type?}',['as'=>'admin.setting.sms','uses'=>'SettingController@sms']);

    /*ali vod*/
    Route::any('setting/video',['as'=>'admin.setting.video','uses'=>'SettingController@video']);

    /*geetest*/
    Route::any('setting/geetest',['as'=>'admin.setting.geetest','uses'=>'SettingController@geetest']);

    /*微信小程序配置*/
    Route::any('setting/weChatApp',['as'=>'admin.setting.weChatApp','uses'=>'SettingController@weChatApp']);


    /*问题删除*/
    Route::post('question/destroy',['as'=>'admin.question.destroy','uses'=>'QuestionController@destroy']);
    /*修改分类核*/
    Route::post('question/changeCategories',['as'=>'admin.question.changeCategories','uses'=>'QuestionController@changeCategories']);
    /*问题审核*/
    Route::post('question/verify',['as'=>'admin.question.verify','uses'=>'QuestionController@verify']);
    /*问题管理*/
    Route::resource('question', 'QuestionController',['as'=>'admin','only' => ['index','edit','update']]);


    /*回答删除*/
    Route::post('answer/destroy',['as'=>'admin.answer.destroy','uses'=>'AnswerController@destroy']);
    /*回答审核*/
    Route::post('answer/verify',['as'=>'admin.answer.verify','uses'=>'AnswerController@verify']);
    /*回答管理*/
    Route::resource('answer', 'AnswerController',['as'=>'admin','only' => ['index','edit','update']]);

    /*文章删除*/
    Route::post('article/destroy',['as'=>'admin.article.destroy','uses'=>'ArticleController@destroy']);
    /*文章审核*/
    Route::post('article/verify',['as'=>'admin.article.verify','uses'=>'ArticleController@verify']);
    /*修改分类核*/
    Route::post('article/changeCategories',['as'=>'admin.article.changeCategories','uses'=>'ArticleController@changeCategories']);
    /*文章管理*/
    Route::resource('article', 'ArticleController',['as'=>'admin','only' => ['index','edit','update']]);

    /*评论删除*/
    Route::post('comment/destroy',['as'=>'admin.comment.destroy','uses'=>'CommentController@destroy']);
    /*评论审核*/
    Route::post('comment/verify',['as'=>'admin.comment.verify','uses'=>'CommentController@verify']);
    /*评论管理*/
    Route::resource('comment', 'CommentController',['as'=>'admin','only' => ['index','edit','update']]);

    /*草稿列表*/
    Route::any('draft/index',['as'=>'admin.draft.index','uses'=>'DraftController@index']);
    /*草稿删除*/
    Route::post('draft/destroy',['as'=>'admin.draft.destroy','uses'=>'DraftController@destroy']);

    /*举报列表*/
    Route::any('report/index',['as'=>'admin.report.index','uses'=>'ReportController@index']);
    /*删除举报*/
    Route::post('report/destroy',['as'=>'admin.report.destroy','uses'=>'ReportController@destroy']);
    /*忽略、处理举报*/
    Route::post('report/ignore',['as'=>'admin.report.ignore','uses'=>'ReportController@ignore']);
    Route::post('report/dispose',['as'=>'admin.report.dispose','uses'=>'ReportController@dispose']);

    /*标签删除*/
    Route::post('tag/destroy',['as'=>'admin.tag.destroy','uses'=>'TagController@destroy']);
    /*修改分类核*/
    Route::post('tag/changeCategories',['as'=>'admin.tag.changeCategories','uses'=>'TagController@changeCategories','except'=>['destroy']]);

    /*标签审核*/
    Route::post('tag/verify',['as'=>'admin.tag.verify','uses'=>'TagController@verify']);
    /*标签管理*/
    Route::resource('tag', 'TagController',['as'=>'admin','except' => ['show','destroy']]);

    /*分类管理*/
    Route::post('category/destroy',['as'=>'admin.category.destroy','uses'=>'CategoryController@destroy']);
    Route::resource('category', 'CategoryController',['as'=>'admin','except' => ['show','destroy']]);

    /*公告管理*/
    Route::post('notice/destroy',['as'=>'admin.notice.destroy','uses'=>'NoticeController@destroy']);
    Route::resource('notice', 'NoticeController',['as'=>'admin','except' => ['show','destroy']]);

    /*首页推荐*/
    Route::post('recommendation/destroy',['as'=>'admin.recommendation.destroy','uses'=>'RecommendationController@destroy']);
    Route::resource('recommendation', 'RecommendationController',['as'=>'admin','except' => ['show','destroy']]);

    /*商品管理*/
    Route::post('goods/destroy',['as'=>'admin.goods.destroy','uses'=>'GoodsController@destroy']);
    Route::resource('goods', 'GoodsController',['as'=>'admin','except' => ['show','destroy']]);
    /*商品兑换*/
    Route::get('exchange/{id}/{status}',['as'=>'admin.exchange.changeStatus','uses'=>'ExchangeController@changeStatus'])->where(['id'=>'[0-9]+','status'=>'(success|failed)']);
    Route::resource('exchange', 'ExchangeController',['as'=>'admin','except' => ['show','destroy']]);

    /*友情链接*/
    Route::post('friendshipLink/destroy',['as'=>'admin.friendshipLink.destroy','uses'=>'FriendshipLinkController@destroy']);
    Route::resource('friendshipLink', 'FriendshipLinkController',['as'=>'admin','except' => ['show','destroy']]);

    /*工具管理*/
    Route::match(['get','post'],'tool/clearCache',['as'=>'admin.tool.clearCache','uses'=>'ToolController@clearCache']);
    Route::post('tool/sendTestEmail',['as'=>'admin.tool.sendTestEmail','uses'=>'ToolController@sendTestEmail']);

    /*XunSearch索引管理*/
    Route::get("xunSearch/clear",['as'=>'admin.xunSearch.clear','uses'=>'XunSearchController@clear']);
    Route::get("xunSearch/rebuild",['as'=>'admin.xunSearch.rebuild','uses'=>'XunSearchController@rebuild']);

    /*财务管理*/
    Route::resource('credit', 'CreditController',['as'=>'admin','except' => ['show']]);

    /*后台日志*/
    Route::any('operationLog',['as'=>'admin.operationLog.index','uses'=>'OperationController@index']);
    /*IP黑名单*/
    Route::post('banIp/destroy',['as'=>'admin.banIp.destroy','uses'=>'BanIpController@destroy']);
    Route::resource('banIp', 'BanIpController',['as'=>'admin','except' => ['show','destroy']]);

});
