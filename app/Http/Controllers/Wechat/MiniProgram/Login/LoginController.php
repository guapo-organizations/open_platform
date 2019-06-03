<?php

namespace App\Http\Controllers\Wechat\MiniProgram\Login;

use EasyWeChat\Factory;
use Laravel\Lumen\Routing\Controller as BaseController;

class LoginController extends BaseController
{
    /**
     * 登录
     */
    public function jscode2session()
    {
        $code = request('code', '');

        //调用微信接口
        $config = config('wechat.miniprogram');
        $mini_program_app = Factory::miniProgram($config);
        $auth = $mini_program_app->auth;
        $result = $auth->session($code);
        if ($result['errcode'] != 0) {
            return apiJsonError($result['errmsg']);
        }

        return apiJson($result);
    }
}
