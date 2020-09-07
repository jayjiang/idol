<?php
// 应用公共文件
use think\Request;
if (!function_exists("dev")){
    function dev($key){
        $dev = config("dev");
        if (isset($dev[$key]) && $dev[$key]){
            return $dev[$key];
        }
        return '';
    }
}
/**
 * 获取当前域名及根路径
 * @return string
 */
if (!function_exists("base_url")){
    function base_url()
    {
        $request = \request();
        $subDir = str_replace('\\', '/', dirname($request->server('PHP_SELF')));
        return $request->scheme() . '://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
    }
}

/**
 * 返回封装后的 API 数据到客户端
 * @param int $code
 * @param string $msg
 * @param string $url
 * @param array $data
 * @return array
 */
if (!function_exists("renderJson")){
    function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }
}
/**
 * PHP生成随机字符串
 * @param	Int		$length			字符串长度
 * @weburl	url						学习地址：http://www.ijquery.cn/?p=1027
 */
if (!function_exists("generateRandomString")){
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }
}
/**
 * PHP加密解密
 * @param String $key 关键字
 * @param String $string 加密的字符串
 * @param String $decrypt 0表示加密，1表示解密
 * @author    hongwei                    由子弹兄整理，非原创
 * @weburl    url                        学习地址：http://www.ijquery.cn/?p=1022
 */
if (!function_exists("encryptDecrypt")){
    function encryptDecrypt($key, $string, $decrypt)
    {
        if ($decrypt) {
            $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode
            ($string), MCRYPT_MODE_CBC, md5(md5($key))), "12");
            return $decrypted;
        } else {
            $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key),
                $string, MCRYPT_MODE_CBC, md5(md5($key))));
            return $encrypted;
        }
    }
}


/**
 * 订单号函数 get_order_sn
 * @author     hongweizhiyuan 2015-1-6
 */
if (!function_exists("get_order_sn")){
    function get_order_sn()
    {
        return date('Ymdhis') . str_pad(mt_rand(1, 9999999), 7, '0', STR_PAD_LEFT);
    }
}

/**
 * 返回操作成功json
 * @param string $msg
 * @param string $url
 * @param array $data
 * @return array
 */
if (!function_exists("renderSuccess")){
    function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return renderJson(1, $msg, $url, $data);
    }
}


/**
 * 返回操作失败json
 * @param string $msg
 * @param string $url
 * @param array $data
 * @return array
 */
if (!function_exists("renderError")){
    function renderError($msg = 'error', $url = '', $data = [])
    {
        return renderJson(0, $msg, $url, $data);
    }
}
/**
 * 写入配置文件
 * @param string $file 文件路径
 * @param array $object 写入的配置内容
 * @return false|int
 */
if (!function_exists("setConfigFile")){
    function setConfigFile($object = [], $file = DEV_PATH)
    {
        $res = file_put_contents($file, "<?php \r\n return " . var_export($object, true) . ";");
        return $res;
    }
}


/**
 * 截取指定字符串
 * @param $str 所需截取的字符串
 * @param $start 开始字符串
 * @param $end 结束字符串
 * @return mixed|string
 */
if (!function_exists("str_between")){
    function str_between($str, $start, $end)
    {
        //按照开始字符串拆分
        $content = explode($start, $str);
        //判断如果后面有字符串
        if (isset($content[1])) {
            //再次拆分后面
            $content = explode($end, $content[1]);
            return $content[0];//得到最后一个和之前的后面一个的中间字符串
        }
        return '';
    }
}


/**
 * @param $url 请求的Url地址
 * @param string $user_agent 请求的代理头
 * @return bool|string
 */
if (!function_exists("curl_request_get")){
    function curl_request_get($url, $user_agent = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不校验ssl
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不校验ssl
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//获取到内容、不直接输出到页面
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);//设置请求头信息
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);//获取到重定向内容
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}


/**
 * POST
 */
if (!function_exists("curl_request_post")){
    function curl_request_post($url, $params = [], $headers = [])
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}


/**
 * 替换字符串中间位置字符为星号
 * @param  [type] $str [description]
 * @return [type] [description]
 */
if (!function_exists("replaceToStar")){
    function replaceToStar($str)
    {
        $len = strlen($str) / 2;

        return substr_replace($str, str_repeat('*', $len), floor(($len) / 2), $len);
    }
}


/**
 * 接口JSON数据格式返回
 * @param $msg 错误提示
 * @param int $code 状态码
 * @param array $data
 */
if (!function_exists("toJson")){
    function toJson($msg, $code = 400, $data = [], $is_data = false)
    {
        header('Content-Type:application/json');  //此声明非常重要
        $array['code'] = $code;
        $array['msg'] = $msg;
        $array['data'] = $data;
        if ($is_data) {
            exit(json_encode($data));
        } else {
            exit(json_encode($array));
        }
    }
}

if (!function_exists("json")){
    function json($data)
    {
        header('Content-Type:application/json');
        exit($data);
    }
}


/**
 * 无限级分类 格式化输出
 * @param $data
 * @param int $pid
 * @param int $level
 * @return array
 */
if (!function_exists("sort_tree")){
    function sort_tree($data, $pid = 0, $level = 0)
    {
        static $ret = array();
        foreach ($data as $k => $v) {
            if ($v['pid'] == $pid) {
                // 把level值放到这个分类里，这样就可以知道这个分类是第几级的
                $v['level'] = $level;
                $ret[] = $v;
                // 再找这个分类的子分类
                sort_tree($data, $v['id'], $level + 1);
            }
        }
        return $ret;
    }
}



/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key 加密密钥
 * @param int $expire 过期时间 单位 秒
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
if (!function_exists("think_encrypt")){
    function think_encrypt($data, $key = '', $expire = 0)
    {
        $key = md5(empty($key) ? config("app.AUTH_KEY") : $key);
        $data = base64_encode($data);
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        $char = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        $str = sprintf('%010d', $expire ? $expire + time() : 0);

        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
        }
        return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($str));
    }
}


/**
 * 系统解密方法
 * @param string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key 加密密钥
 * @return string
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
if (!function_exists("think_decrypt")){
    function think_decrypt($data, $key = '')
    {
        $key = md5(empty($key) ? config("app.AUTH_KEY") : $key);
        $data = str_replace(array('-', '_'), array('+', '/'), $data);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        $data = base64_decode($data);
        $expire = substr($data, 0, 10);
        $data = substr($data, 10);

        if ($expire > 0 && $expire < time()) {
            return '';
        }
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        $char = $str = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        for ($i = 0; $i < $len; $i++) {
            if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
                $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
            } else {
                $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
            }
        }
        return base64_decode($str);
    }
}