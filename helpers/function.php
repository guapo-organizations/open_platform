<?php
if (!function_exists('apiJson')) {
    /**
     * 返回JSON
     * @param mixed $data 主数据
     * @param string $msg 描述
     * @param array $extra 扩展信息
     * @param int $code 状态码（非0为异常状态）
     * @return \Illuminate\Http\JsonResponse
     */
    function apiJson($data, $msg = '', array $extra = [], $code = 0)
    {
        $json = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data,
        ];

        if ($extra) {
            $json = array_merge($json, $extra);
        }

        return response()->json($json);
    }
}


if (!function_exists('apiJsonError')) {
    /**
     * 返回JSON
     * @param string $msg 错误描述
     * @param int $code 状态码（非0为异常状态）
     * @param string $data 主数据
     * @param array $extra 扩展信息
     * @return \Illuminate\Http\JsonResponse
     */
    function apiJsonError($msg, $code = 10001, $data = null, array $extra = [])
    {
        return apiJson($data, $msg, $extra, $code);
    }
}

if (!function_exists('request')) {
    /**
     * 从ioc容器（服务容器）中获取request对象，你懂得,
     * 或者直接从请求中获取值
     * @param null $key
     * @param null $default
     * @return \Illuminate\Http\Request|string|array
     */
    function request($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('request');
        }

        return app('request')->input($key, $default);
    }
}

if (!function_exists('isTestDebug')) {
    /**
     * 一些程序员调试用的后门判断
     * @return bool
     */
    function isTestDebug()
    {
        return env('APP_DEBUG') && request('t');
    }
}
