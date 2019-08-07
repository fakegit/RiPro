<?php
/**
 * 下载地址加密flush shangche
 *
 */
header("Content-type:text/html;character=utf-8");
global $current_user;


$downid = !empty($_GET['downid']) ? (int)$_GET['downid'] : 0;
$ref = !empty($_GET['ref']) ? (int)$_GET['ref'] : 0;

if (!$downid && !$ref) {
    wp_die('地址错误或者URL参数错误','URL参数错误');
}

// 开始下载处理
if (isset($downid) && empty($ref)):

    if (!is_user_logged_in()) {
        wp_die('请登录后下载资源包','请登录下载');
    }else{
    	$uid = $current_user->ID;
    }
    
// 判断是否有权限下载
    $CaoUser = new CaoUser($uid);
    $PostPay = new PostPay($uid, $downid);
    $_downurl     = get_post_meta($downid, 'cao_downurl', true);
    $home_url=esc_url(home_url());
    // 本地文件做处理
    if(strpos($_downurl,$home_url) !== false){ 
    	$parse_url = parse_url($_downurl);
    	$_downurl  =$parse_url['path'];
	}

    if ($PostPay->isPayPost()) {
        // 判断会员类型 判断下载次数
        $vip_status = $CaoUser->vip_status();
        $this_vip_downum = cao_vip_downum($uid,$vip_status);
        if ($this_vip_downum['is_down']) {
            update_user_meta($uid, 'cao_vip_downum', $this_vip_downum['today_down_num'] + 1); //更新+1
            # // 开始下载缓冲...
            $flush = _download_file($_downurl);
            exit();
        } else {
            wp_die('今日下载次数已用：'.$this_vip_downum['today_down_num'].'次,剩余下载次数：'.$this_vip_downum['over_down_num'],'下载次数超出限制');exit();
        }
    	
    }else{
    	wp_die('您没有购买此资源或下载权限错误','非法下载');
    }
endif;

// 开始推广地址处理
if (isset($ref) && empty($downid)):
    session_start();
    $from_user_id = $ref;
    // empty($_SESSION['WPAY_code_captcha']);
    $_SESSION['cao_from_user_id'] = $from_user_id;
    header("Location:" . home_url());
    exit();
endif;
// 结束推广地址处理

wp_die('地址错误或者URL参数错误');
