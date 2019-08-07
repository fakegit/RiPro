<?php
/**
 * 支付宝同步回调
 */

header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();

if (empty($_GET)) {
    echo '非法请求';exit();
}

// 获取后台支付宝配置
$aliPayConfig = _cao('alipay');

// 公共配置
$params         = new \Yurun\PaySDK\Alipay\Params\PublicParams;
$params->md5Key = $aliPayConfig['md5Key'];

// SDK实例化，传入公共配置
$pay = new \Yurun\PaySDK\Alipay\SDK($params);

if ($pay->verifyCallback($_GET)) {
    wp_safe_redirect(home_url('/user'));
} else {
    wp_safe_redirect(home_url('/user'));
}
