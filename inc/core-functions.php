<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 * 功能函数
 * @package caozhuti
 */


/**
 * no category
 */
if (_cao('no_categoty') && !function_exists('no_category_base_refresh_rules')) {

    /* hooks */
    register_activation_hook(__FILE__, 'no_category_base_refresh_rules');
    register_deactivation_hook(__FILE__, 'no_category_base_deactivate');

    /* actions */
    add_action('created_category', 'no_category_base_refresh_rules');
    add_action('delete_category', 'no_category_base_refresh_rules');
    add_action('edited_category', 'no_category_base_refresh_rules');
    add_action('init', 'no_category_base_permastruct');

    /* filters */
    add_filter('category_rewrite_rules', 'no_category_base_rewrite_rules');
    add_filter('query_vars', 'no_category_base_query_vars'); // Adds 'category_redirect' query variable
    add_filter('request', 'no_category_base_request'); // Redirects if 'category_redirect' is set

    function no_category_base_refresh_rules()
    {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

    function no_category_base_deactivate()
    {
        remove_filter('category_rewrite_rules', 'no_category_base_rewrite_rules'); // We don't want to insert our custom rules again
        no_category_base_refresh_rules();
    }

    /**
     * Removes category base.
     *
     * @return void
     */
    function no_category_base_permastruct()
    {
        global $wp_rewrite;
        global $wp_version;

        if ($wp_version >= 3.4) {
            $wp_rewrite->extra_permastructs['category']['struct'] = '%category%';
        } else {
            $wp_rewrite->extra_permastructs['category'][0] = '%category%';
        }
    }

    /**
     * Adds our custom category rewrite rules.
     *
     * @param  array $category_rewrite Category rewrite rules.
     *
     * @return array
     */
    function no_category_base_rewrite_rules($category_rewrite)
    {
        global $wp_rewrite;
        $category_rewrite = array();

        /* WPML is present: temporary disable terms_clauses filter to get all categories for rewrite */
        if (class_exists('Sitepress')) {
            global $sitepress;

            remove_filter('terms_clauses', array($sitepress, 'terms_clauses'));
            $categories = get_categories(array('hide_empty' => false));
            add_filter('terms_clauses', array($sitepress, 'terms_clauses'));
        } else {
            $categories = get_categories(array('hide_empty' => false));
        }

        foreach ($categories as $category) {
            $category_nicename = $category->slug;

            if ($category->parent == $category->cat_ID) {
                $category->parent = 0;
            } elseif ($category->parent != 0) {
                $category_nicename = get_category_parents($category->parent, false, '/', true) . $category_nicename;
            }

            $category_rewrite['(' . $category_nicename . ')/(?:feed/)?(feed|rdf|rss|rss2|atom)/?$']    = 'index.php?category_name=$matches[1]&feed=$matches[2]';
            $category_rewrite["({$category_nicename})/{$wp_rewrite->pagination_base}/?([0-9]{1,})/?$"] = 'index.php?category_name=$matches[1]&paged=$matches[2]';
            $category_rewrite['(' . $category_nicename . ')/?$']                                       = 'index.php?category_name=$matches[1]';
        }

        // Redirect support from Old Category Base
        $old_category_base                               = get_option('category_base') ? get_option('category_base') : 'category';
        $old_category_base                               = trim($old_category_base, '/');
        $category_rewrite[$old_category_base . '/(.*)$'] = 'index.php?category_redirect=$matches[1]';

        return $category_rewrite;
    }

    function no_category_base_query_vars($public_query_vars)
    {
        $public_query_vars[] = 'category_redirect';
        return $public_query_vars;
    }

    /**
     * Handles category redirects.
     *
     * @param $query_vars Current query vars.
     *
     * @return array $query_vars, or void if category_redirect is present.
     */
    function no_category_base_request($query_vars)
    {
        if (isset($query_vars['category_redirect'])) {
            $catlink = trailingslashit(get_option('home')) . user_trailingslashit($query_vars['category_redirect'], 'category');
            status_header(301);
            header("Location: $catlink");
            exit();
        }

        return $query_vars;
    }

}


//搜索页面排除
function cao_exclude_page_from_search($query)
{
  if ($query->is_search) {
    $query->set('post_type', 'post');
  }
  return $query;
}
add_filter('pre_get_posts', 'cao_exclude_page_from_search');

// MD5 上传文件重命名
function _new_filename($filename)
{
    $info = pathinfo($filename);
    $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
    $name = basename($filename, $ext);
    return substr(md5($name), 0, 15) . $ext;
}
add_filter('sanitize_file_name', '_new_filename', 10);

// 禁用难用的Gutenberg（古腾堡） 编辑器
if (_cao('disabled_block_editor',true)) {
    add_filter('use_block_editor_for_post', '__return_false');
    remove_action('wp_enqueue_scripts', 'wp_common_block_scripts_and_styles');
}

/**
 * [mail_smtp SMTP集成]
 * @Author   Dadong2g
 * @DateTime 2019-05-28T12:30:03+0800
 * @param    [type]                   $phpmailer [description]
 * @return   [type]                              [description]
 */
function mail_smtp($phpmailer)
{
    if (_cao('mail_smtps',true)) {
        $phpmailer->IsSMTP();
        $mail_name             = _cao('mail_name');
        $mail_host             = _cao('mail_host');
        $mail_port             = _cao('mail_port');
        $mail_username         = _cao('mail_name');
        $mail_passwd           = _cao('mail_passwd');
        $mail_smtpsecure       = _cao('mail_smtpsecure');
        $phpmailer->FromName   = $mail_name ? $mail_name : 'caozhuti';
        $phpmailer->Host       = $mail_host ? $mail_host : 'smtp.qq.com';
        $phpmailer->Port       = $mail_port ? $mail_port : '465';
        $phpmailer->Username   = $mail_username ? $mail_username : '88888888@qq.com';
        $phpmailer->Password   = $mail_passwd ? $mail_passwd : '123456789';
        $phpmailer->From       = $mail_username ? $mail_username : '88888888@qq.com';
        $phpmailer->SMTPAuth   = _cao('mail_smtpauth') == 1 ? true : false;
        $phpmailer->SMTPSecure = $mail_smtpsecure ? $mail_smtpsecure : 'ssl';

    }
}
add_action('phpmailer_init', 'mail_smtp');



/**
 * [cao_redirect_wp_admin 拒绝普通用户访问后台 ]
 * @Author   Dadong2g
 * @DateTime 2019-05-31T16:45:00+0800
 * @return   [type]                   [description]
 */
function cao_redirect_wp_admin()
{   
    if ( is_admin() && !current_user_can('editor') && ( !defined( 'DOING_AJAX' ) || !DOING_AJAX ) ) {
      $current_user = wp_get_current_user();
      if($current_user->roles[0] == get_option('default_role')) {
        wp_safe_redirect( home_url('/user') );
        exit();
      }
    }
}
add_action('init', 'cao_redirect_wp_admin');


// ===== remove edit profile link from admin bar and side menu and kill profile page if not an admin
if( !current_user_can('manage_options') ) {
function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu('edit-profile', 'user-actions');
}
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );
 
function stop_access_profile() {
    if(@IS_PROFILE_PAGE === true) {
        wp_die( '此页面权限不足，请使用网站管理员账号登录管理' );
    }
    remove_menu_page( 'profile.php' );
    remove_submenu_page( 'users.php', 'profile.php' );
}
add_action( 'admin_init', 'stop_access_profile' );
}


if (_cao('is_close_wpreg') || _cao('is_close_wplogin')) {
    
}



/**
 * [cao_handle_banned_user 对封禁账户处理]
 * @Author   Dadong2g
 * @DateTime 2019-05-31T16:49:17+0800
 * @return   [type]                   [description]
 */
function cao_handle_banned_user()
{
    if ($user_id = get_current_user_id()) {
        if (current_user_can('administrator')) {
            return;
        }
        $CaoUser = new CaoUser($user_id);
        $ban     = $CaoUser->user_status();
        if ($ban['banned']) {
            wp_die(sprintf('您的账号出现问题已被管管理员冻结。冻结原因： %s', $ban['banned_reason']), '账号冻结', 404); //TODO add banned time
        }

    }
}
add_action('template_redirect', 'cao_handle_banned_user');
add_action('admin_menu', 'cao_handle_banned_user');

/**
 * [cao_update_credit_by_user_register 用户注册时初始化]
 * @Author   Dadong2g
 * @DateTime 2019-05-31T19:31:57+0800
 * @param    [type]                   $user_id [description]
 * @return   [type]                            [description]
 */
function cao_update_credit_by_user_register($user_id)
{   
    //链接推广人与新注册用户(注册人meta)
    $ref_from = ($_SESSION['cao_from_user_id']) ? $_SESSION['cao_from_user_id'] : 0 ;
    update_user_meta($user_id, 'cao_ref_from', absint($ref_from));
    // 会员组
    update_user_meta($user_id, 'cao_user_type', 'no');
    update_user_meta($user_id, 'cao_vip_end_time', date("Y-m-d", time()));
    // 余额
    update_user_meta($user_id, 'cao_balance', '0.00');
    update_user_meta($user_id, 'cao_consumed_balance', '0.00');
    // 佣金
    update_user_meta($user_id, 'cao_total_bonus', '0.00');
    //社交登录
    // update_user_meta($user_id, 'open_qq_token', '');
    update_user_meta($user_id, 'open_qq_bind', '0');
    update_user_meta($user_id, 'open_qq_name', '未绑定');
    // update_user_meta($user_id, 'cao_banned', '0');
}
add_action('user_register', 'cao_update_credit_by_user_register');

/**
 * [wp_remove_open_sans_from_wp_core 禁止后台加载谷歌字体]
 * @Author   Dadong2g
 * @DateTime 2019-05-21T23:45:22+0800
 * @return   [type]                   [description]
 */
function wp_remove_open_sans_from_wp_core()
{
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
    wp_enqueue_style('open-sans', '');
}
add_action('init', 'wp_remove_open_sans_from_wp_core');

/**
 * [ashuwp_clean_theme_meta 清除wordpress自带的meta标签]
 * @Author   Dadong2g
 * @DateTime 2019-05-21T23:46:13+0800
 * @return   [type]                   [description]
 */
function ashuwp_clean_theme_meta()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7, 1);
    remove_action('wp_print_styles', 'print_emoji_styles', 10, 1);
    remove_action('wp_head', 'rsd_link', 10, 1);
    remove_action('wp_head', 'wp_generator', 10, 1);
    remove_action('wp_head', 'feed_links', 2, 1);
    remove_action('wp_head', 'feed_links_extra', 3, 1);
    remove_action('wp_head', 'index_rel_link', 10, 1);
    remove_action('wp_head', 'wlwmanifest_link', 10, 1);
    remove_action('wp_head', 'start_post_rel_link', 10, 1);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'rest_output_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_oembed_add_discovery_links', 10, 1);
    remove_action('wp_head', 'rel_canonical', 10, 0);
}
add_action('after_setup_theme', 'ashuwp_clean_theme_meta'); //清除wp_head带入的meta标签

/**
 * [remove_xmlrpc_pingback_ping 防pingback攻击]
 * @Author   Dadong2g
 * @DateTime 2019-05-21T23:46:55+0800
 * @param    [type]                   $methods [description]
 * @return   [type]                            [description]
 */
function remove_xmlrpc_pingback_ping($methods)
{
    unset($methods['pingback.ping']);
    return $methods;
};
add_filter('xmlrpc_methods', 'remove_xmlrpc_pingback_ping');


/**
 * WordPress Emoji Delete
 */
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

/**
 * [_jpeg_quality JPEG QUALITY]
 * @Author   Dadong2g
 * @DateTime 2019-05-21T23:48:34+0800
 * @param    [type]                   $arg [description]
 * @return   [type]                        [description]
 */
function _jpeg_quality($arg)
{
    return 100;
}
add_filter('jpeg_quality', '_jpeg_quality', 10);

/**
 * [hide_admin_bar Hide Admin Bar]
 * @Author   Dadong2g
 * @DateTime 2019-05-21T23:49:17+0800
 * @param    [type]                   $flag [description]
 * @return   [type]                         [description]
 */
function hide_admin_bar($flag)
{
    return false;
}
add_filter('show_admin_bar', 'hide_admin_bar');

/**
 * [disable_embeds_init start]
 * @Author   Dadong2g
 * @DateTime 2019-05-21T23:52:24+0800
 * @return   [type]                   [description]
 */
function disable_embeds_init()
{
    /* @var WP $wp */
    global $wp;

    // Remove the embed query var.
    $wp->public_query_vars = array_diff($wp->public_query_vars, array(
        'embed',
    ));

    // Remove the REST API endpoint.
    remove_action('rest_api_init', 'wp_oembed_register_route');

    // Turn off
    add_filter('embed_oembed_discover', '__return_false');

    // Don't filter oEmbed results.
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);

    // Remove oEmbed discovery links.
    remove_action('wp_head', 'wp_oembed_add_discovery_links');

    // Remove oEmbed-specific JavaScript from the front-end and back-end.
    remove_action('wp_head', 'wp_oembed_add_host_js');
    add_filter('tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin');

    // Remove all embeds rewrite rules.
    add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
}

add_action('init', 'disable_embeds_init', 9999);

/**
 * Removes the 'wpembed' TinyMCE plugin.
 *
 * @since 1.0.0
 *
 * @param array $plugins List of TinyMCE plugins.
 * @return array The modified list.
 */
function disable_embeds_tiny_mce_plugin($plugins)
{
    return array_diff($plugins, array('wpembed'));
}

/**
 * Remove all rewrite rules related to embeds.
 *
 * @since 1.2.0
 *
 * @param array $rules WordPress rewrite rules.
 * @return array Rewrite rules without embeds rules.
 */
function disable_embeds_rewrites($rules)
{
    foreach ($rules as $rule => $rewrite) {
        if (false !== strpos($rewrite, 'embed=true')) {
            unset($rules[$rule]);
        }
    }

    return $rules;
}

/**
 * Remove embeds rewrite rules on plugin activation.
 *
 * @since 1.2.0
 */
function disable_embeds_remove_rewrite_rules()
{
    add_filter('rewrite_rules_array', 'disable_embeds_rewrites');
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'disable_embeds_remove_rewrite_rules');

/**
 * Flush rewrite rules on plugin deactivation.
 *
 * @since 1.2.0
 */
function disable_embeds_flush_rewrite_rules()
{
    remove_filter('rewrite_rules_array', 'disable_embeds_rewrites');
    flush_rewrite_rules();
}

register_deactivation_hook(__FILE__, 'disable_embeds_flush_rewrite_rules');

/**
 * Caozhuti Custom function for get an option
 */
if (!function_exists('_cao')) {
    function _cao($option = '', $default = null)
    {
        $options = get_option('_caozhuti_options'); // Attention: Set your unique id of the framework
        return (isset($options[$option])) ? $options[$option] : $default;
    }
}

function curlPost($url = '', $postData = '', $options = array())
{
    if (is_array($postData)) {
        $postData = http_build_query($postData);
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); //设置cURL允许执行的最长秒数
    if (!empty($options)) {
        curl_setopt_array($ch, $options);
    }
    //https请求 不验证证书和host
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}