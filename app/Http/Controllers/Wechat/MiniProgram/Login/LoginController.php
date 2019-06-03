<?php

namespace App\Http\Controllers\Wechat\MiniProgram\Login;

use EasyWeChat\Factory;
use Laravel\Lumen\Routing\Controller as BaseController;

class LoginController extends BaseController
{
    /**
     * 登录
     * @return \Illuminate\Http\JsonResponse
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function jscode2session()
    {
        $code = request('code', '');

        //调用微信接口
        $config = config('wechat.miniprogram');
        $mini_program_app = Factory::miniProgram($config);
        $auth = $mini_program_app->auth;
        $result = $auth->session($code);

        if (isset($result['errcode']) && $result['errcode'] != 0) {
            return apiJsonError($result['errmsg']);
        }
        /**
         * @var \Illuminate\Cache\CacheManager $cache
         */
        $cache = app('cache');
        $cache->put('wechat:miniprogram:jscode:' . $result['openid'], $result['session_key']);
        return apiJson($result);
    }

    /**
     * 消息解密
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     */
    public function decryptData()
    {
        $iv = request('iv', '');
        $encryptData = request('encryptData', '');
        $open_id = request('open_id', '');

        /**
         * @var \Illuminate\Cache\CacheManager $cache
         */
        $cache = app('cache');
        $session_key = $cache->get('wechat:miniprogram:jscode:' . $open_id);

        //调用微信接口
        $config = config('wechat.miniprogram');
        $mini_program_app = Factory::miniProgram($config);
        $result = $mini_program_app->encryptor->decryptData($session_key, $iv, $encryptData);

        return apiJson($result);
    }
}
