<?php
/**
 * weixin异步通知
 */

header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();

// 获取后台支付配置
$wxPayConfig = _cao('weixinpay');

// 公共配置
$params         = new \Yurun\PaySDK\Weixin\Params\PublicParams;
$params->appID  = $wxPayConfig['appid'];
$params->mch_id = $wxPayConfig['mch_id'];
$params->key    = $wxPayConfig['key'];
// SDK实例化，传入公共配置
$sdk = new \Yurun\PaySDK\Weixin\SDK($params);

class PayNotify extends \Yurun\PaySDK\Weixin\Notify\Pay
{
    /**
     * 后续执行操作
     * @return void
     */
    protected function __exec()
    {
        // 支付成功处理，一般做订单处理，$this->data 是从微信发送来的数据
        // file_put_contents(__DIR__ . '/notify_result.txt', date('Y-m-d H:i:s') . ':' . var_export($this->data, true));

        //商户本地订单号
        $out_trade_no = $this->data['out_trade_no'];
        //支付宝交易号
        $trade_no = $this->data['transaction_id'];

        // 处理本地业务逻辑
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
                $note      = '微信-在线充值 [￥' . $order->order_price . '] +' . $charge_money;
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

        // 告诉微信我处理过了，不要再通过了
        $this->reply(true, 'OK');
    }
}

$payNotify = new PayNotify;

try {
    $sdk->notify($payNotify);
} catch (Exception $e) {
    file_put_contents(__DIR__ . '/notify_result.txt', $e->getMessage() . ':' . var_export($payNotify->data, true));
}
