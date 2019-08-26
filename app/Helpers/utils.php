<?php
if (!function_exists('week_day')){
    function week_day($date=FALSE, $simple=TRUE)
    {
        if(!$date){
            $date = date('Y-m-d');
        }
        $week_day = date('w',strtotime($date));
        switch ($week_day) {
            case 0 :
                return $simple ? '日' : '星期日';
            case 1 :
                return $simple ? '一' : '星期一';
            case 2 :
                return $simple ? '二' : '星期二';
            case 3 :
                return $simple ? '三' : '星期三';
            case 4 :
                return $simple ? '四' : '星期四';
            case 5 :
                return $simple ? '五' : '星期五';
            case 6 :
                return $simple ? '六' : '星期六';
        }
    }
}

if (!function_exists('ip_locate')) {
    function ip_locate($internetIp = '')
    {
        try {
            //内网IP
            //  A类10.0.0.0～10.255.255.255
            //  B类172.16.0.0～172.31.255.255
            //  C类192.168.0.0～192.168.255.255
            //  ......
            $bLocalIp = !filter_var($internetIp, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
            if ($bLocalIp)
                $internetIp = 'myip';//局域网IP

            $requestAPi = "http://ip.taobao.com/service/getIpInfo.php?ip=" . $internetIp;
            $opts = array(
                'http' => array(
                    'method' => 'GET',
                    'timeout' => 1, // 单位秒
                )
            );
            $jsonArr = json_decode(file_get_contents($requestAPi, false, stream_context_create($opts)),
                JSON_HEX_TAG | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_APOS);

            // 说明断网
            if (!isset($jsonArr) || !isset($jsonArr['code'])) {
                return false;
            }

            // 0 表示成功
            if ($jsonArr['code'] !== 0) {
                return false;
            }

            /**
             * array: [
             *   "ip" => "xxx.xxx.xxx.xxx"
             *   "country" => "中国"
             *   "area" => ""
             *   "region" => "福建"
             *   "city" => "厦门"
             *   "county" => "XX"
             *   "isp" => "移动"
             *   "country_id" => "CN"
             *   "area_id" => ""
             *   "region_id" => "350000"
             *   "city_id" => "350200"
             *   "county_id" => "xx"
             *   "isp_id" => "100025"
             *]
             */
            $data = (array)$jsonArr['data'];
            return $data;
        } catch (Exception $e) {

        }

        return false;
    }
}

if (!function_exists('ip_addr')) {
    function ip_addr($ip2long = false)
    {
        $ip = null;
        if (!$ip && getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        if (!$ip && getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $ips = explode(',', getenv('HTTP_X_FORWARDED_FOR'));
            if (count($ips) > 0) {
                $ip = trim($ips[0]);
            }
        }
        if (!$ip && getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $ip = getenv('REMOTE_ADDR');
        }
        if (!$ip && isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if (!$ip) {
            $ip = "0.0.0.0";
        }
        return $ip2long ? ip2long($ip) : $ip;
    }
}
if (!function_exists('zero_fill')) {

    function zero_fill($number_str, $length = 3, $fill = '0')
    {
        while (strlen(trim($number_str)) != $length) {
            $number_str = sprintf("%s%s", $fill, $number_str);
        }
        return $number_str;
    }
}

if (!function_exists('trait_type')) {
    function trait_type($trait,$info=FALSE){
        $subfix = '';
        $type_str = '';
        switch (strtolower($trait)){
            case 'special':
                $type_str = '特碼類';
                $subfix = $info ? '[ 第一球、第二球、冠軍 … ]' : '';
                break;
            case 'double':
                $type_str = '雙面類';
                $subfix = $info ? '[ 單雙、大小、龍虎 … ]' : '';
                break;
            case 'serial':
                $type_str = '連碼類';
                $subfix = $info ? '[ 任選二、任選三 … ]' : '';
                break;
            case 'other':
            default:
                $type_str = '其他類';
        }
        return $type_str.' '.$subfix;
    }
}

if (!function_exists('merchant_role')) {
    function merchant_role($code){
        switch (strtolower($code)){
            case 'company':
                return '分公司';
            case 'shareholder':
                return '股东';
            case 'agent':
                return '总代理';
            case 'proxy':
                return '代理';
            case 'child':
                return '子帐号';
            default:
                return '其他';
        }
    }
}

if(!function_exists('http_curl')) {
    function http_curl($url, $type = 'get', $res = 'json', $arr = '')
    {
        //1，初始化curl
        $ch = curl_init();
        //2,设置 curl的参数
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("content-type:text/html; charset=UTF-8"));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //一定要注意加这个  https 不验证
        if ($type == 'post') {
            curl_setopt($ch, CURLOPT_POST, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
        }
        //3，采集
        $output = curl_exec($ch);
        if ($res == 'json') {
            if ($no = curl_errno($ch)) {
                $msg = curl_error($ch);
                //4,关闭
                curl_close($ch);
                return 'Curl error: [ ' .$no.' ] -> '.$msg;
            } else {
                //4,关闭
                curl_close($ch);
                return json_decode($output, true);
            }
        }
    }
}

if(!function_exists('ajax_return')) {
    function ajax_return($ret=1,$msg_data='',$msg_title='')
    {
        $data = $msg = FALSE;
        if(is_string($msg_data)){
            $msg = $msg_data;
        }else if(is_array($msg_data)){
            $data = $msg_data;
        }
        $return = [
            'error_code' => boolval($ret) ? 0 : 1,
            'title' => $msg_title ? $msg_title : (boolval($ret) ? '操作成功' : '操作失败'),
            'msg' => $msg ? $msg : (boolval($ret) ? '操作成功' : '操作失败')
        ];
        if($data){
            $return['data'] = $data;
        }
        return $return;
    }
}