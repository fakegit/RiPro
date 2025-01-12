<?php
/**
 * caozhuti functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package caozhuti
 */
/**
 * check order OR coipon
 */
global $wpdb, $order_table_name, $paylog_table_name, $coupon_table_name, $balance_log_table_name;
$order_table_name       = isset($table_prefix) ? ($table_prefix . 'cao_order') : ($wpdb->prefix . 'cao_order');
$paylog_table_name      = isset($table_prefix) ? ($table_prefix . 'cao_paylog') : ($wpdb->prefix . 'cao_paylog');
$coupon_table_name      = isset($table_prefix) ? ($table_prefix . 'cao_coupon') : ($wpdb->prefix . 'cao_coupon');
$balance_log_table_name = isset($table_prefix) ? ($table_prefix . 'cao_balance_log') : ($wpdb->prefix . 'cao_balance_log');
$ref_log_table_name = isset($table_prefix) ? ($table_prefix . 'cao_ref_log') : ($wpdb->prefix . 'cao_ref_log');

if (!function_exists('caozhuti_setup')):
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function caozhuti_setup()
    {
        $setupDb = new setupDb();
        $setupDb->install();

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');
        // add_image_size( 'cao_full_400', 400 );
        // add_image_size( 'cao_full_800', 800 );
        // add_image_size( 'cao_full_1160', 1160 );
        // add_image_size( 'cao_rect_300', 300, 200, true );

        register_nav_menus(array(
            'menu-1' => '顶部菜单',
            'menu-2' => '底部菜单',
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Load regular editor styles into the new block-based editor.
        add_theme_support('editor-styles');

        // Load default block styles.
        add_theme_support('wp-block-styles');

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        //添加自定义文章类型代码(弃用)
        // new Ws_Post_Type('shop','shop_cat','商品');
        add_theme_support( 'post-formats', array( 'video','image') );
        // CREATE PAGES
        $init_pages = array(
            'pages/user.php' => array('用户中心', 'user'),
            'pages/zhuanti.php' => array('专题', 'zhuanti'),
            'pages/archives.php' => array('存档', 'archives'),
            'pages/tags.php' => array('标签云', 'tags'),
        );

        foreach ($init_pages as $template => $item) {

            $one_page = array(
                'post_title'  => $item[0],
                'post_name'   => $item[1],
                'post_status' => 'publish',
                'post_type'   => 'page',
                'post_author' => 1,
            );

            $one_page_check = get_page_by_title($item[0]);

            if (!isset($one_page_check->ID)) {
                $one_page_id = wp_insert_post($one_page);
                update_post_meta($one_page_id, '_wp_page_template', $template);
            }
        }
        //更新伪静态规则
        flush_rewrite_rules();

    }
endif;
add_action('after_setup_theme', 'caozhuti_setup');


/**
 * [caozhuti_widgets_init Register widget area.]
 * @Author   Dadong2g
 * @DateTime 2019-05-28T23:47:36+0800
 * @return   [type]                   [description]
 */
function caozhuti_widgets_init()
{
    $sidebars = array(
        'sidebar' => '文章页侧栏',
        'off_canvas'   => '全站侧栏菜单',
        // 'footer'   => '网站屁股小工具'
    );
    foreach ($sidebars as $key => $value) {
        register_sidebar(array(
            'name'          => $value,
            'id'            => $key,
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<h5 class="widget-title">',
            'after_title' => '</h5>',
        ));
    }

}
add_action('widgets_init', 'caozhuti_widgets_init');

/**
 * [caozhuti_scripts 加载主题JS和CSS资源]
 * @Author   Dadong2g
 * @DateTime 2019-05-28T23:46:28+0800
 * @return   [type]                   [description]
 */
function caozhuti_scripts()
{
    $theme_assets = get_stylesheet_directory_uri() . '/assets';
    if (!is_admin()) {

        // 禁用jquery和110n翻译
        wp_deregister_script('jquery');
        wp_deregister_script('l10n');

        //引入CSS
        wp_enqueue_style('caozhuti-style', get_stylesheet_uri());
        // wp_enqueue_style('dosis_fonts', 'https://fonts.googleapis.com/css?family=Dosis:200,300,400,500,600,700,800|Open+Sans:300,400,600,700,800', array(), '', 'all');
        wp_enqueue_style('external', $theme_assets . '/css/external.css', array(), '', 'all');
        wp_enqueue_style('sweetalert2', $theme_assets . '/css/sweetalert2.min.css', array(), '', 'all');
        wp_enqueue_style('app', $theme_assets . '/css/app.css', array(), '', 'all');
        wp_enqueue_style('diy', $theme_assets . '/css/diy.css', array(), '', 'all');

        // 引入JS
        wp_enqueue_script('jquery', $theme_assets . '/js/jquery-2.2.4.min.js', '', '2.2.4', false);
        wp_enqueue_script('sweetalert2', $theme_assets . '/js/plugins/sweetalert2.min.js', array(), '', false);
        wp_enqueue_script('plugins', $theme_assets . '/js/plugins.js', array(), '', true);
        if (_cao('is_captcha_qq')) {
            wp_enqueue_script('captcha','https://ssl.captcha.qq.com/TCaptcha.js', array(), '', true);
        }
        wp_enqueue_script('app', $theme_assets . '/js/app.js', array('jquery'), '', true);
        
        // llqrcode
        if (is_page_template('pages/user.php')) {
            wp_enqueue_script('llqrcode', $theme_assets . '/js/plugins/llqrcode.js', array('jquery'), '2.0.1', true);
        }
        //jquery.fancybox.min.js
        if (is_singular() && _cao('is_fancybox_img',true)) {
            wp_enqueue_style('fancybox', $theme_assets . '/css/jquery.fancybox.min.css', array(), '', 'all');
            wp_enqueue_script('fancybox', $theme_assets . '/js/plugins/jquery.fancybox.min.js', array('jquery'), '', true);
        }
        if (is_singular() && comments_open() && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply');
        }
        //脚本本地化
        wp_localize_script('app', 'caozhuti',
            array(
                'site_name' => get_bloginfo('name'),
                'home_url' => esc_url( home_url() ),
                'ajaxurl'    => esc_url(admin_url('admin-ajax.php')),
                'is_singular'    => is_singular() ? 1 : 0,
                'tencent_captcha'    => array('is' => _cao('is_captcha_qq','0'),'appid' => _cao('captcha_qq_appid','')),
                'infinite_load' => '加载更多',
                'infinite_loading' => '<i class="fa fa-spinner fa-spin"></i> 加载中...',
                'site_notice' => array('is' => _cao('is_site_notify','0'),'color' => _cao('site_notify_color','rgb(33, 150, 243)'), 'html' => '<div class="notify-content"><h3>'._cao('site_notify_title','').'</h3><div>'._cao('site_notify_desc','').'</div></div>'),
            )
        );

    }
}
add_action('wp_enqueue_scripts', 'caozhuti_scripts');

// 管理页面CSS
function caoAdminScripts() {   
    wp_enqueue_style('caoadmin', get_stylesheet_directory_uri() . '/assets/css/admin.css', array(), '', 'all');
}
add_action( 'admin_enqueue_scripts', 'caoAdminScripts' );



/**
 *
 * Codestar Framework
 * A Simple and Lightweight WordPress Option Framework for Themes and Plugins
 *
 */
require_once get_stylesheet_directory() . '/inc/codestar-framework/codestar-framework.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require_once get_stylesheet_directory() . '/inc/core-functions.php';

/**
 * Custom template tags for this theme.
 */
require_once get_stylesheet_directory() . '/inc/theme-functions.php';
require_once get_stylesheet_directory() . '/inc/core-ajax.php';

/**
 * core Class.
 */
if (function_exists('sg_load')) {
    require_once get_stylesheet_directory() . '/inc/class/core.class.php';
}else{
    wp_die('<h3 style="text-align: center;">请在您的php环境中安装SG11扩展组件得以开始使用本主题</h3><br/>推荐使用php版本-PHP7.2，性能起飞奔放。<a target="_blank" href="https://vip.ylit.cc/112.html">SG11安装教程</a>', 'SG11扩展组件提示');
}

/**
 * walker.class.php Class.
 */
require_once get_stylesheet_directory() . '/inc/class/walker.class.php';


/**
 * composer autoload.
 */
require_once get_stylesheet_directory() . '/vendor/autoload.php';


/**
 * admin
 */
require_once get_stylesheet_directory() . '/inc/admin/init.php';
