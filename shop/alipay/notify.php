<?php
/**
 * 支付宝异步通知Mapi
 */

header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();

if (empty($_POST)) {
    wp_die('<meta charset="UTF-8" />非法请求');
}

// 获取后台支付宝配置
$aliPayConfig = _cao('alipay');

// 初始化变量 $this_verify
$this_verify = false;

// mapi模式公共配置
$params         = new \Yurun\PaySDK\Alipay\Params\PublicParams;
$params->md5Key = $aliPayConfig['md5Key'];
// SDK实例化，传入公共配置
$pay = new \Yurun\PaySDK\Alipay\SDK($params);
if ($pay->verifyCallback($_POST)) {
    // 模式2通知验证成功，可以通过POST参数来获取支付宝回传的参数
    $this_verify = true;
} else {
    $this_verify = false;
}
//商户本地订单号
$out_trade_no = $_POST['out_trade_no'];
//支付宝交易号
$trade_no = $_POST['trade_no'];

// 处理本地业务逻辑
if ($this_verify && $_POST['trade_status'] == 'TRADE_SUCCESS') {

    // 验证通过 获取基本信息
    $ShopOrder = new ShopOrder();
    $order     = $ShopOrder->get($out_trade_no);
    // 是否有效订单 && 订单类型为充值
    if ($order && $order->order_type == 'charge') {
        // 实例化用户信息
        $CaoUser = new CaoUser($order->user_id);
        // 计算充值数量
        $charge_rate  = (int) _cao('site_change_rate'); //充值比例
        $old_money    = $CaoUser->get_balance(); //用户原来余额
        $charge_money = sprintf('%0.2f', $order->order_price * $charge_rate); // 实际充值数量

        //更新用户余额信息
        if ($CaoUser->update_balance($charge_money)) {
            // 写入记录
            $Caolog    = new Caolog();
            $new_money = $old_money + $charge_money; //充值后金额
            $note      = '支付宝-在线充值 [￥' . $order->order_price . '] +' . $charge_money;
            $Caolog->addlog($order->user_id, $old_money, $charge_money, $new_money, 'charge', $note);
            //更新订单状态
            $ShopOrder->update($out_trade_no, $trade_no);
            //发放佣金 查找推荐人
            add_to_user_bonus($order->user_id,$charge_money);
            //发送邮件
            $obj_user = get_user_by('ID', $order->user_id);
            _sendMail($obj_user->user_email, '支付成功', $note);
        }
    }
    echo 'success';exit();
} else {
    // 输出错误日志 可以在生产环境关闭 注释即可
    echo "error";exit();
}
exit();
