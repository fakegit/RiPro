<?php
/**
 * 支付宝异步通知 openapp
 */

header('Content-type:text/html; Charset=utf-8');
date_default_timezone_set('Asia/Shanghai');
ob_start();
require_once dirname(__FILE__) . "../../../../../../wp-load.php";
ob_end_clean();

if (empty($_POST)) {
    echo '非法请求';exit();
}

// 获取后台支付宝配置
$aliPayConfig = _cao('alipay');

$aliPay = new AlipayServiceCheck($aliPayConfig['publicKey']);
//验证签名
$_verify = $aliPay->rsaCheck($_POST, $_POST['sign_type']);
if ($_verify === true) {
    // 通知验证成功，可以通过POST参数来获取支付宝回传的参数
    $this_verify = true;
} else {
    $this_verify = false;
 	echo 'success';exit();
}

// $content = var_export($_POST, true) . PHP_EOL . 'verify:' . var_export($_verify, true);
// file_put_contents(__DIR__ . '/notify_result.txt', $content);


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


// 调用其他类 AlipayServiceCheck
class AlipayServiceCheck
{
    //支付宝公钥
    protected $alipayPublicKey;
    protected $charset;

    public function __construct($alipayPublicKey)
    {
        $this->charset         = 'utf8';
        $this->alipayPublicKey = $alipayPublicKey;
    }

    public function rsaCheck($params)
    {
        $sign     = $params['sign'];
        $signType = $params['sign_type'];
        unset($params['sign_type']);
        unset($params['sign']);
        return $this->verify($this->getSignContent($params), $sign, $signType);
    }

    public function verify($data, $sign, $signType = 'RSA')
    {
        $pubKey = $this->alipayPublicKey;
        $res    = "-----BEGIN PUBLIC KEY-----\n" .
        wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');

        //调用openssl内置方法验签，返回bool值
        if ("RSA2" == $signType) {
            $result = (bool) openssl_verify($data, base64_decode($sign), $res, version_compare(PHP_VERSION, '5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256);
        } else {
            $result = (bool) openssl_verify($data, base64_decode($sign), $res);
        }
        return $result;
    }

    protected function checkEmpty($value)
    {
        if (!isset($value)) {
            return true;
        }

        if ($value === null) {
            return true;
        }

        if (trim($value) === "") {
            return true;
        }

        return false;
    }

    public function getSignContent($params)
    {
        ksort($params);
        $stringToBeSigned = "";
        $i                = 0;
        foreach ($params as $k => $v) {

            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {

                // 修复转义导致签名失败
                $v = stripslashes($v);

                // 转换成目标字符集
                $v = $this->characet($v, $this->charset);

                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {

                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }

                $i++;

            }
        }

        unset($k, $v);
        return $stringToBeSigned;
    }
    public function characet($data, $targetCharset)
    {
        if (!empty($data)) {
            $fileType = $this->charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }
}
