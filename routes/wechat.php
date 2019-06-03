<?php
/**
 * @var Laravel\Lumen\Routing\Router $router
 */

$router->group([
    'prefix' => 'wechat',
    'namespace' => 'Wechat'
], function () use ($router) {

    //个人的小程序,通过appid，appsecret方式
    $router->group([
        'prefix' => 'miniprogram',
        'namespace' => 'MiniProgram'
    ], function () use ($router) {
        //登录功能
        $router->group([
            'prefix' => 'login',
            'namespace' => 'Login'
        ], function () use ($router) {
            //小程序登录
            $router->post('jscode2session', 'LoginController@jscode2session');
        });
    });
});