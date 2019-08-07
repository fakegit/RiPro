<?php
/**
 * 支付成功异步回调接口
 *
 * 当用户支付成功后，支付平台会把订单支付信息异步请求到本接口(最多5次)
 *
 * @date 2017年3月13日
 * @copyright 重庆迅虎网络有限公司
 */

header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();
require_once get_stylesheet_directory() . '/inc/class/xunhupay.class.php';
/**
 * 回调数据
 * @var array(
 *       'trade_order_id'，商户网站订单ID
         'total_fee',订单支付金额
         'transaction_id',//支付平台订单ID
         'order_date',//支付时间
         'plugins',//自定义插件ID,与支付请求时一致
         'status'=>'OD'//订单状态，OD已支付，WP未支付
 *   )
 */
// 获取后台支付配置
$XHpayConfig = _cao('xunhupay');

$data = $_POST;
foreach ($data as $k=>$v){
    $data[$k] = stripslashes($v);
}
if(!isset($data['hash'])||!isset($data['trade_order_id'])){
   echo 'failed';exit;
}

//自定义插件ID,请与支付请求时一致
if(isset($data['plugins'])&&$data['plugins']!='ripro-xunhupay-v3'){
    echo 'failed';exit;
}

//APP SECRET
$appkey = $XHpayConfig['appsecret'];
$hash = XH_Payment_Api::generate_xh_hash($data,$appkey);
if($data['hash']!=$hash){
    //签名验证失败
    echo 'failed';exit;
}

if($data['status']=='OD'){
    //商户本地订单号
    $out_trade_no = $data['trade_order_id'];
    //交易号
    $trade_no = $data['transaction_id'];
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


}else{
    //处理未支付的情况
}

//以下是处理成功后输出，当支付平台接收到此消息后，将不再重复回调当前接口
echo 'success';
exit;
