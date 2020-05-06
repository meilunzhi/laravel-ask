<?php

/*前台显示部分*/
Route::Group(['namespace'=>'Ask'],function(){


    /*问题查看*/
    Route::get('question/{id}',['as'=>'ask.question.detail','uses'=>'QuestionController@detail'])->where(['id'=>'[0-9]+']);

    /*回答详情查看*/
    Route::get('question/{question_id}/answer/{id}',['as'=>'ask.answer.detail','uses'=>'AnswerController@detail'])->where(['id'=>'[0-9]+','question_id'=>'[0-9]+']);

    /*问题建议*/
    Route::post('question/suggest',['as'=>'ask.question.suggest','uses'=>'QuestionController@suggest']);


    /*需要登录的模块*/
    Route::Group(['middleware'=>['auth','ban.ip']],function(){

        /*问题创建*/
        Route::get('question/create',['as'=>'ask.question.create','uses'=>'QuestionController@create']);
        Route::post('question/store',['middleware' =>'ban.user','as'=>'ask.question.store','uses'=>'QuestionController@store']);

        /*问题修改*/
        Route::get('question/edit/{id}',['as'=>'ask.question.edit','uses'=>'QuestionController@edit'])->where(['id'=>'[0-9]+']);
        Route::post('question/update',['middleware' =>'ban.user','as'=>'ask.question.update','uses'=>'QuestionController@update']);

        /*追加悬赏*/
        Route::post('question/{id}/appendReward',['as'=>'ask.question.appendReward','uses'=>'QuestionController@appendReward'])->where(['id'=>'[0-9]+']);

        /*邀请回答*/
        Route::get('question/invite/{question_id}/{to_user_id}',['as'=>'ask.question.invite','uses'=>'QuestionController@invite'])->where(['question_id'=>'[0-9]+','to_user_id'=>'[0-9]+']);
        Route::any('question/inviteEmail/{question_id}',['as'=>'ask.question.inviteEmail','uses'=>'QuestionController@inviteEmail'])->where(['question_id'=>'[0-9]+']);
        Route::get('question/{question_id}/invitations/{type}',['as'=>'ask.question.invitations','uses'=>'QuestionController@invitations'])->where(['question_id'=>'[0-9]+','type'=>'(part|all)']);

        /*采纳回答*/
        Route::get('answer/adopt/{id}',['as'=>'ask.answer.adopt','uses'=>'AnswerController@adopt'])->where(['id'=>'[0-9]+']);

        /*回答保存*/
        Route::post('answer/store',['as'=>'ask.answer.store','uses'=>'AnswerController@store']);
        /*回答编辑页面显示*/
        Route::get('answer/edit/{id}',['as'=>'ask.answer.edit','uses'=>'AnswerController@edit'])->where(['id'=>'[0-9]+']);
        /*回答保存*/
        Route::post('answer/update/{id}',['as'=>'ask.answer.update','uses'=>'AnswerController@update'])->where(['id'=>'[0-9]+']);

        /*评论添加*/
        Route::post('comment/store',['middleware' =>'ban.user','as'=>'ask.comment.store','uses'=>'CommentController@store']);

    });

    /*标签首页*/
    Route::get('topic/{id}/{source_type?}',['as'=>'ask.tag.index','uses'=>'TagController@index'])->where(['id'=>'[0-9]+','source_type'=>'(questions|articles|courses|details)']);

    /*加载评论*/
    Route::get('{source_type}/{source_id}/comments',['as'=>'ask.comment.show','uses'=>'CommentController@show'])->where(['source_type'=>'(question|answer|article|video)','source_id'=>'[0-9]+']);

});

