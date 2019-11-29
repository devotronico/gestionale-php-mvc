<?php
return [
    'GET' => [
        '' => 'App\Controllers\HomeController@home',
        '/' => 'App\Controllers\HomeController@home',
        'auth/signup' => 'App\Controllers\SignupController@form',
        'auth/signup/verify'=> 'App\Controllers\SignupController@verify',
        'auth/signin' => 'App\Controllers\SigninController@signinForm',
        'doc/list' => 'App\Controllers\DocsController@getDocs',
        'doc/create' => 'App\Controllers\DocsController@createDoc',
        'auth/password/form'=> 'App\Controllers\PasswordController@passwordForm',
        'auth/password/new'=> 'App\Controllers\PasswordController@passwordNew',
        'auth/logout' => 'App\Controllers\SigninController@logout',

        'home/download' => 'App\Controllers\HomeController@download',
        'blog' => 'App\Controllers\BlogController@getPosts',
        '#blog/page/:id' => 'App\Controllers\BlogController@getPosts',
        '#blog/:m/:y' => 'App\Controllers\BlogController@getPostsByDate',
        'post/create' => 'App\Controllers\PostController@create',
        '#post/:id' => 'App\Controllers\PostController@postSingle',
        '#post/:id/edit' => 'App\Controllers\PostController@editPost',
        '#post/:id/delete' => 'App\Controllers\PostController@delete',
        '#comment/:id/delete' => 'App\Controllers\PostController@deleteComment',
        '#user/:id' => 'App\Controllers\UserController@user',
        '#user/:id/:usertype' => 'App\Controllers\UserController@setUsertype',
    ],
    'POST' => [
        'auth/signin/access' => 'App\Controllers\SigninController@signinAccess',
        'auth/signup/store' => 'App\Controllers\SignupController@store',
        'auth/password/check' =>'App\Controllers\PasswordController@passwordCheck',
        'auth/password/save' =>'App\Controllers\PasswordController@passwordSave',
        'home/contact' => 'App\Controllers\HomeController@contact',
        'post/save' => 'App\Controllers\PostController@savePost',
        '#post/:id/update' => 'App\Controllers\PostController@updatePost',
        '#post/:id/comment' => 'App\Controllers\PostController@saveComment',
        '#user/image/:id' =>'App\Controllers\UserController@setAvatar',
    ]
];

