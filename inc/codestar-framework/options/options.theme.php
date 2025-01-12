<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly.

//
// Set a unique slug-like ID
//
$prefix = '_caozhuti_options';

//
// Create options
//
CSF::createOptions( $prefix, array(
  'menu_title' => 'RiPro主题设置',
  'menu_slug'  => 'csf-caozhuti',
) );


//
// 基本设置
//
CSF::createSection( $prefix, array(
  'title'  => '基本设置',
  'icon'   => 'fa fa-rocket',
  'fields' => array(

    array(
      'id'    => 'site_logo',
      'type'  => 'upload',
      'title' => '亮色LOGO',
      'default'     => get_stylesheet_directory_uri() . '/assets/images/logo/logo-light.png',
    ),
    // array(
    //   'id'    => 'site_dark_logo',
    //   'type'  => 'upload',
    //   'title' => '暗黑LOGO',
    //   'default'     => get_stylesheet_directory_uri() . '/assets/images/logo/logo-dark.png',
    // ),

    array(
      'id'    => 'site_favicon',
      'type'  => 'upload',
      'title' => 'favicon',
      'default'     => get_stylesheet_directory_uri() . '/assets/images/favicon/favicon.png',
    ),
    array(
        'id'      => 'is_ripro_dark_btn',
        'type'    => 'switcher',
        'title'   => '是否在网站显示切换暗黑模式的按钮',
        'label'   => '',
        'default' => true,
    ),

    array(
        'id'      => 'is_ripro_dark',
        'type'    => 'switcher',
        'title'   => '网站默认使用暗黑风格',
        'label'   => '',
        'default' => false,
        'dependency' => array( 'is_ripro_btn', '==', 'true' ),
    ),
	
    array(
        'id'      => 'is_site_comments',
        'type'    => 'switcher',
        'title'   => '关闭全站评论',
        'label'   => '评论很多时候没什么用，直接干掉',
        'default' => true,
    ),
    
    array(
        'id'      => 'is_all_publish_posts',
        'type'    => 'switcher',
        'title'   => '所有人都可投稿',
        'label'   => '关闭后网站仅限有作者权限的用户投稿发布文章',
        'default' => true,
    ),

    
    array(
        'id'      => 'is_filter_bar',
        'type'    => 'switcher',
        'title'   => '分类内页禁用筛选',
        'label'   => '全站，如需个别分类关闭请到分类编辑单独定制即可',
        'default' => false,
    ),

    array(
        'id'      => 'is_site_notify',
        'type'    => 'switcher',
        'title'   => '全站弹窗公告',
        'label'   => '开启后用户首次打开网站弹出',
        'default' => true,
    ),
    array(
        'id'         => 'site_notify_title',
        'type'       => 'text',
        'title'      => '全站弹窗公告-标题',
        'desc'       => '例如：RiPro最新版本更新日志',
        'attributes' => array(
            'style' => 'width: 100%;',
        ),
        'default'    => 'RiPro最新版本更新日志',
        'dependency' => array( 'is_site_notify', '==', 'true' ),
    ),
    array(
        'id'         => 'site_notify_desc',
        'type'       => 'textarea',
        'title'      => '全站弹窗公告-内容',
        'desc'       => '全站弹窗公告，通知，纯文本通知弹窗',
        'attributes' => array(
                  'style' => 'width: 100%;',
              ),
        'default'    => 'https://github.com/AdFate/RiPro  花式激活正版RiPro 主题',
        'dependency' => array( 'is_site_notify', '==', 'true' ),
    ),
    array(
      'id'        => 'site_notify_color',
      'type'      => 'color',
      'title'     => '全站弹窗公告-背景颜色',
      'default'    => 'rgb(33, 150, 243)',
      'dependency' => array( 'is_site_notify', '==', 'true' ),
    ),
  )
) );



//
// SEO设置
//
CSF::createSection( $prefix, array(
  'title' => 'SEO设置',
  'icon'  => 'fa fa-circle',
  'fields'      => array(
    array(
      'id'     => 'seo',
      'type'   => 'fieldset',
      'title'  => 'SEO相关',
      'fields' => array(

          array(
              'id'         => 'web_keywords',
              'type'       => 'text',
              'title'      => '网站关键词',
              'desc'       => '3-5个关键词，用英文逗号隔开',
              'attributes' => array(
                  'style' => 'width: 100%;',
              ),
              'default'    => 'RiPro主题,RiPro破解版在线激活,AdFate',
          ),
          array(
              'id'      => 'web_description',
              'type'    => 'textarea',
              'title'   => '网站描述',
              'default' => 'https://github.com/AdFate/RiPro 激情正版激活',
          ),

      ),
  ),

  array(
      'id'      => 'connector',
      'type'    => 'text',
      'title'   => '全站链接符',
      'desc'    => '一经选择，切勿更改，对SEO不友好，一般为“-”或“_”',
      'default' => '-',
  ),
    array(
      'id'      => 'no_categoty',
      'type'    => 'switcher',
      'title'   => '分类去除category/前缀',
      'label'   => '',
      'default' => true,
    ),
    
     array(
        'id'    => 'is_archive_crumbs',
        'type'  => 'switcher',
        'title' => '禁用文章内页是否显示面包屑导航',
        'label' => '',
        'default' => false,
      ),

    
  )
) );



//
// Field: 顶部设置
//
CSF::createSection($prefix, array(
    'title'  => '顶部设置',
    'icon'   => 'fa fa-long-arrow-up',
    'fields' => array(

       
        
        array(
            'id'      => 'navbar_style',
            'type'    => 'radio',
            'title'   => '导航风格',
            'inline'  => true,
            'options' => array(
                'sticky' => esc_html__( '跟随', 'cao' ),
                'transparent' => esc_html__( '透明', 'cao' ),
                'sticky_transparent' => esc_html__( '跟随+透明', 'cao' ),
                'regular' => esc_html__( '常规', 'cao' ),
            ),
            'default' => 'sticky',
        ),


        array(
            'id'      => 'navbar_full',
            'type'    => 'switcher',
            'title'   => '全宽导航',
            'label'   => '',
            'default' => false,
        ),


        array(
            'id'      => 'navbar_slide',
            'type'    => 'switcher',
            'title'   => '滚动时隐藏导航栏',
            'label'   => '',
            'default' => false,
        ),

        array(
            'id'      => 'navbar_hidden',
            'type'    => 'switcher',
            'title'   => '隐藏主菜单',
            'label'   => '',
            'default' => false,
        ),

        array(
            'id'      => 'disable_search',
            'type'    => 'switcher',
            'title'   => '关闭搜索',
            'label'   => '',
            'default' => false,
        ),

    ),
));


//
// 首页设置: 首页设置
//
CSF::createSection( $prefix, array(
  'id' => 'home_fields',
  'title' => '首页设置',
  'icon'  => 'fa fa-home',
  'description' => '首页设置',
));



//
// 首页设置: 布局设置
//
CSF::createSection( $prefix, array(
  'parent'      => 'home_fields',
  'title' => '首页布局',
  'icon'  => 'fa fa-circle',
  'description' => '拖拽要启用的模块和排序',
  'fields'      => array(
    array(
          'id'             => 'home_mode',
          'type'           => 'sorter',
          'title'          => '首页模块排序和启用',
          'enabled_title'  => '显示的模块',
          'disabled_title' => '隐藏',
          'default'        => array(
              'enabled'  => array(
                  'lastpost'   => '最新文章展示',
              ),
              'disabled' => array(
                  'slider'   => '幻灯片',
                  'catbox' => '分类块展示',
                  'catbox2' => '分类块展示-风格2',
                  'catpost'   => '分类文章展示',
                  'ulist'    => '纯标题文章展示',
				  'search'    => '搜索条',
              ),
          ),
      ),
    
  )
));




//
// 首页模块参数
//
CSF::createSection( $prefix, array(
  'parent'      => 'home_fields',
  'title' => '首页模块参数',
  'icon'  => 'fa fa-circle',
  'fields'      => array(



    // 幻灯片
    array(
      'id'     => 'mode_slider',
      'type'   => 'fieldset',
      'title'  => '幻灯片-1',
      'fields' => array(
        
        array(
          'id'    => 'autoplay',
          'type'  => 'switcher',
          'title' => '自动播放',
          'label' => '',
          'default' => true,
        ),

        array(
          'id'    => 'diy_slider',
          'type'  => 'switcher',
          'title' => '自定义全屏幻灯片图片和链接',
          'label' => '关闭后可以以文章内容获自动取幻灯片',
          'default' => true,
        ),

        array(
          'id'     => 'diy_data',
          'type'   => 'repeater',
          'title'  => '新建自定义幻灯片',
          'fields' => array(

            array(
                'id'      => '_title',
                'type'    => 'text',
                'title'   => '标题（new）',
                'default' => 'RiPro主题',
            ),
            array(
                'id'      => '_desc',
                'type'    => 'text',
                'title'   => '描述',
                'default' => 'RiPro是一个优秀的主题，你喜欢的样子我都有！',
            ),
            array(
                'id'          => '_img',
                'type'        => 'upload',
                'title'       => '上传幻灯片',
                'library'     => 'image',
                'placeholder' => 'http://',
                'default'     => get_stylesheet_directory_uri() . '/assets/images/thumb/full.jpg',
            ),
            array(
                'id'      => '_blank',
                'type'    => 'switcher',
                'title'   => '新窗口打开链接',
                'label'   => '',
                'default' => true,
            ),
            array(
                'id'      => '_href',
                'type'    => 'text',
                'title'   => '链接地址',
                'default' => '#',
            ),
          ),
          'dependency' => array( 'diy_slider', '==', 'true' ),
        ),

        array(
            'id'      => 'count',
            'type'    => 'text',
            'title'   => '显示数量',
            'default' => '3',
            'dependency' => array( 'diy_slider', '==', 'false' ),
        ),
        array(
            'id'      => 'offset',
            'type'    => 'text',
            'title'   => '第几页',
            'default' => '0',
            'dependency' => array( 'diy_slider', '==', 'false' ),
        ),
        array(
            'id'          => 'category',
            'type'        => 'select',
            'title'       => '推荐的推荐的分类',
            'placeholder' => '选择一个分类',
            'options'     => 'categories',
            'dependency' => array( 'diy_slider', '==', 'false' ),
        ),

        array(
            'id'      => 'orderby',
            'type'    => 'radio',
            'title'   => '排序',
            'inline'  => true,
            'options' => array(
                'date' => esc_html__( '日期', 'cao' ),
                'rand' => esc_html__( '随机', 'cao' ),
                'comment_count' => esc_html__( '评论数量', 'cao' ),
                'id' => esc_html__( '文章ID', 'cao' ),
            ),
            'default' => 'date',
            'dependency' => array( 'diy_slider', '==', 'false' ),
        ),


        array(
          'id'    => 'is_styles_rand',
          'type'  => 'switcher',
          'title' => '随机切换幻灯片风格',
          'label' => '',
          'default' => false,
          'dependency' => array( 'diy_slider', '==', 'false' ),
        ),
        // 幻灯片风格化
        array(
          'id'      => 'styles',
          'type'    => 'image_select',
          'title'   => '幻灯片风格',
          'options' => array(
            '1' => get_stylesheet_directory_uri() . '/assets/images/option/op-slider1.jpg',
            '2' => get_stylesheet_directory_uri() . '/assets/images/option/op-slider2.jpg',
          ),
          'default' => '1',
          'dependency' => array( 'diy_slider', '==', 'false' ),
        ),


      ),
    ),
    // 分类快
    array(
      'id'     => 'mode_catbox',
      'type'   => 'fieldset',
      'title'  => '分类块展示',
      'fields' => array(
        
        array(
            'id'          => 'cat_id',
            'type'        => 'select',
            'title'       => '要展示的分类',
            'placeholder' => '选择4个分类',
            'chosen'      => true,
            'multiple'    => true,
            'options'     => 'categories',
        ),
      ),
    ),

    // 分类快2
    array(
      'id'     => 'mode_catbox2',
      'type'   => 'fieldset',
      'title'  => '分类块展示-风格2',
      'fields' => array(
        
        array(
            'id'          => 'cat_id',
            'type'        => 'select',
            'title'       => '要展示的分类',
            'placeholder' => '感谢会员@小up设计(描述会自动获取当前分类的的描述)',
            'chosen'      => true,
            'multiple'    => true,
            'options'     => 'categories',
        ),

      ),
    ),


    // 首页最新文章模块
    array(
      'id'     => 'home_last_post',
      'type'   => 'fieldset',
      'title'  => '首页最新文章模块',
      'fields' => array(
        array(
            'id'          => 'home_postlist_no_cat',
            'type'        => 'select',
            'title'       => '首页要排除的分类',
            'placeholder' => '选择要排除的分类',
            'chosen'      => true,
            'multiple'    => true,
            'options'     => 'categories',
        ),
      ),
    ),


    // 分类CMS
    array(
      'id'     => 'mode_catpost',
      'type'   => 'fieldset',
      'title'  => '分类CMS',
      'fields' => array(
        array(
          'id'     => 'catcms',
          'type'   => 'repeater',
          'title'  => '无限分类CMS',
          'fields' => array(
             
             
              array(
                  'id'      => 'count',
                  'type'    => 'text',
                  'title'   => '显示数量',
                  'default' => '8',
              ),
              array(
                  'id'          => 'category',
                  'type'        => 'select',
                  'title'       => '推荐的推荐的分类',
                  'placeholder' => '选择一个分类',
                  'options'     => 'categories',
              ),

              array(
                  'id'      => 'orderby',
                  'type'    => 'radio',
                  'title'   => '排序',
                  'inline'  => true,
                  'options' => array(
                      'date' => esc_html__( '日期', 'cao' ),
                      'rand' => esc_html__( '随机', 'cao' ),
                      // 'view' => esc_html__( '查看次数', 'cao' ),
                      'comment_count' => esc_html__( '评论数量', 'cao' ),
                      'id' => esc_html__( '文章ID', 'cao' ),
                  ),
                  'default' => 'date',
              ),
             
              array(
                'id'      => 'latest_layout',
                'type'    => 'image_select',
                'title'   => '文章布局',
                'options' => array(
                  'grid' => get_stylesheet_directory_uri() . '/assets/images/option/grid.jpg',
                  'list' => get_stylesheet_directory_uri() . '/assets/images/option/list.jpg',
                ),
                'default' => 'grid',
              ),

          ),
        ),
      ),
    ),
    
    // 标题文章ulist
     array(
      'id'     => 'mode_ulistpost',
      'type'   => 'fieldset',
      'title'  => '分类ulist',
      'fields' => array(
        array(
          'id'     => 'catulist',
          'type'   => 'repeater',
          'title'  => '分类ulist',
          'fields' => array(
            array(
                'id'      => 'count',
                'type'    => 'text',
                'title'   => '显示数量',
                'default' => '8',
            ),
            array(
                'id'          => 'category',
                'type'        => 'select',
                'title'       => '推荐的推荐的分类',
                'placeholder' => '选择一个分类',
                'options'     => 'categories',
            ),

            array(
                'id'      => 'orderby',
                'type'    => 'radio',
                'title'   => '排序',
                'inline'  => true,
                'options' => array(
                    'date' => esc_html__( '日期', 'cao' ),
                    'rand' => esc_html__( '随机', 'cao' ),
                    // 'view' => esc_html__( '查看次数', 'cao' ),
                    'comment_count' => esc_html__( '评论数量', 'cao' ),
                    'id' => esc_html__( '文章ID', 'cao' ),
                ),
                'default' => 'date',
            ),

            array(
                'id'      => 'desc',
                'type'    => 'text',
                'title'   => '描述内容',
                'default' => '好的东西值得描述内容',
            ),
            array(
                'id'      => 'bgimg',
                'type'    => 'upload',
                'title'   => '背景图像',
                'default' => '',
            ),


          ),
        ),
      ),
    ),


  )
) );



//
// 列表设置
//
CSF::createSection( $prefix, array(
  'title' => '列表设置',
  'icon'  => 'fa fa-th-list',
  'fields'      => array(
    
    array(
      'id'    => 'target_blank',
      'type'  => 'switcher',
      'title' => '新窗口打开文章',
      'label' => '',
      'default' => false,
    ),

    array(
      'id'      => 'latest_layout',
      'type'    => 'image_select',
      'title'   => '文章布局',
      'options' => array(
        'grid' => get_stylesheet_directory_uri() . '/assets/images/option/grid.jpg',
        'list' => get_stylesheet_directory_uri() . '/assets/images/option/list.jpg',
      ),
      'default' => 'grid',
    ),
    
    array(
      'id'    => 'is_mobele_list',
      'type'  => 'switcher',
      'title' => '手机端使用列表模式（全部）',
      'label' => '',
      'default' => true,
    ),

    // 是否显示摘要文字
    array(
      'id'    => 'grid_is_excerpt',
      'type'  => 'switcher',
      'title' => '是否显示摘要[grid模式]',
      'label' => '',
      'default' => false,
    ),
    array(
      'id'    => 'grid_is_author',
      'type'  => 'switcher',
      'title' => '是否显示作者头像',
      'label' => '',
      'default' => true,
    ),

    array(
      'id'    => 'grid_is_time',
      'type'  => 'switcher',
      'title' => '是否显示日期',
      'label' => '',
      'default' => true,
    ),
    array(
      'id'    => 'grid_is_views',
      'type'  => 'switcher',
      'title' => '是否显示阅读数量',
      'label' => '',
      'default' => true,
    ),
    array(
      'id'    => 'grid_is_coments',
      'type'  => 'switcher',
      'title' => '是否显示评论数',
      'label' => '',
      'default' => false,
    ),
    array(
      'id'    => 'grid_is_price',
      'type'  => 'switcher',
      'title' => '是否显示价格',
      'label' => '',
      'default' => true,
    ),
    array(
        'id'      => 'pagination',
        'type'    => 'radio',
        'title'   => '翻页按钮',
        'inline'  => true,
        'options' => array(
            'navigation' => esc_html__( '上下页', 'cao' ),
            'numeric' => esc_html__( '数字分页', 'cao' ),
            'infinite_button' => esc_html__( 'AJAX + 按钮', 'cao' ),
            'infinite_scroll' => esc_html__( 'AJAX + 自动', 'cao' ),
        ),
        'default' => 'infinite_button',
    ),


    // array(
    //     'id'      => 'sidebar_home',
    //     'type'    => 'radio',
    //     'title'   => '最新文章侧边栏',
    //     'inline'  => true,
    //     'options' => array(
    //         'none' => esc_html__( '无', 'cao' ),
    //         'right' => esc_html__( '右侧', 'cao' ),
    //         'left' => esc_html__( '左侧', 'cao' ),
    //     ),
    //     'default' => 'none',
    // ),

    // array(
    //     'id'      => 'sidebar_single',
    //     'type'    => 'radio',
    //     'title'   => '文章/页面侧边栏',
    //     'inline'  => true,
    //     'options' => array(
    //         'none' => esc_html__( '无', 'cao' ),
    //         'right' => esc_html__( '右侧', 'cao' ),
    //         'left' => esc_html__( '左侧', 'cao' ),
    //     ),
    //     'default' => 'none',
    // ),

    // array(
    //     'id'      => 'sidebar_archive',
    //     'type'    => 'radio',
    //     'title'   => '分类/侧边栏',
    //     'inline'  => true,
    //     'options' => array(
    //         'none' => esc_html__( '无', 'cao' ),
    //         'right' => esc_html__( '右侧', 'cao' ),
    //         'left' => esc_html__( '左侧', 'cao' ),
    //     ),
    //     'default' => 'none',
    // ),



 
    
    
    array(
        'id'        => 'post_default_thumb',
        'type'      => 'media',
        'title'     => '文章默认缩略图',
        'add_title' => '上传图片',
        'desc'      => '设置文章默认缩略图（建议和自定义文章缩略图宽高保持一致）',
        'default'   => array('url' => get_stylesheet_directory_uri() . '/assets/images/thumb/1.jpg'),
    ),

    array(
        'id'      => 'thumbnail_handle',
        'type'    => 'radio',
        'title'   => '缩略图裁剪模式',
        'desc'    => '默认为timthumb.php模式',
        'options' => array(
            'timthumb_php' => 'timthumb.php裁剪（可保持缩略图大小一致）',
            'timthumb_mi'  => 'WP自带裁剪',
        ),
        'default' => 'timthumb_php',
    ),
    array(
        'id'      => 'thumbnail-px',
        'type'    => 'dimensions',
        'title'   => '自定义文章缩略图宽高',
        'default' => array(
            'width'  => '300',
            'height' => '200',
            'unit'   => 'px',
        ),
    ),

    array(
        'id'      => 'thumb_postfirstimg_s',
        'type'    => 'switcher',
        'title'   => '自动抓取缩略图',
        'label'   => '文章没有缩略图的情况下搜多第一张站内图片作为缩略图,可能会导致文章缩略图不整齐！',
        'default' => true,
    ),


    array(
        'id'      => 'set_postthumbnail',
        'type'    => 'switcher',
        'title'   => '自动保存文章第一张图片为缩略图',
        'label'   => '设置本地发布时候上传的第一张图片为缩略图',
        'default' => true,
    ),
    
  )
) );


//
// Field: 文章内页设置
//
CSF::createSection($prefix, array(
    'title'  => '内页设置',
    'icon'   => 'fa fa-circle',
    'fields' => array(

        
       


        array(
            'id'      => 'is_fancybox_img',
            'type'    => 'switcher',
            'title'   => '点击文章内图片自动灯箱',
            'label'   => '将插入的图片指向链接为媒体文件即可实现',
            'default' => true,
        ),

        array(
            'id'      => 'post_copyright_s',
            'type'    => 'switcher',
            'title'   => '文章底部版权',
            'label'   => '',
            'default' => true,
        ),

        array(
            'id'         => 'post_copyright',
            'type'       => 'textarea',
            'title'      => '文章底部版权内容',
            'desc'       => '',
            'default'    => 'RIPRO主题是一个优秀的主题，极致后台体验，无插件，集成会员系统',
        ),
        
        array(
            'id'      => 'single_disable_author_box',
            'type'    => 'switcher',
            'title'   => '显示作者信息',
            'label'   => '',
            'default' => true,
        ),

        array(
            'id'      => 'disable_related_posts',
            'type'    => 'switcher',
            'title'   => '相关文章推荐',
            'label'   => '',
            'default' => true,
        ),


        // 分享设置
        array(
            'id'      => 'poster_share_open',
            'type'    => 'switcher',
            'title'   => '海报功能开启(new)',
            'label'   => '海报功能需要下载海报字体： https://share.weiyun.com/5MYeGA1 然后解压放到主题目录：ripro/assets/fonts即可',
            'default' => true,
        ),

        array(
            'id'      => 'poster_default_img',
            'type'    => 'upload',
            'title'   => '默认头部大图',
            'dsec'   => '上传一张显示在封面顶部的大图',
            'default' => get_stylesheet_directory_uri() . '/assets/images/thumb/1.jpg',
            'dependency' => array( 'poster_share_open', '==', 'true' ),
        ),

        array(
            'id'      => 'poster_logo',
            'type'    => 'upload',
            'title'   => '左下角LOGO',
            'dsec'   => '上传一张显示在封面底部的LOGO',
            'default' => get_stylesheet_directory_uri() . '/assets/images/logo/logo-dark.png',
            'dependency' => array( 'poster_share_open', '==', 'true' ),
        ),

        array(
            'id'      => 'poster_desc',
            'type'    => 'text',
            'title'   => '网站宣传语',
            'dsec'   => '显示在LOGO下方的一句宣传语',
            'default' => 'RIPRO是一个垃圾的主题  我很赞同 Bug真尼玛多',
            'dependency' => array( 'poster_share_open', '==', 'true' ),
        ),

        array(
            'id'      => 'share_poster_img_qrcode',
            'type'    => 'switcher',
            'title'   => '右下角二维码',
            'label'   => '开启后将再封面图的右下角现在当前文章的二维码',
            'default' => true,
            'dependency' => array( 'poster_share_open', '==', 'true' ),
        ),



        

    ),
));



//
// Basic 商城设置
//
CSF::createSection( $prefix, array(
  'id'    => 'shop_fields',
  'title' => '商城设置',
  'icon'  => 'fa fa-plus-circle',
) );


//
// 商城-核心设置
//
CSF::createSection( $prefix, array(
  'parent'      => 'shop_fields',
  'title' => '初始设置',
  'icon'  => 'fa fa-circle',
  'fields'      => array(
    
    array(
      'id'    => 'site_money_ua',
      'type'  => 'text',
      'title' => '网站货币名称',
      'default' => '积分',
      'desc' => '例如：积分，CB',
    ),
    array(
      'id'      => 'site_money_icon',
      'type'    => 'icon',
      'title'   => '网站货币图标',
      'default' => 'fa fa-paypal'
    ),
    array(
      'id'    => 'site_change_rate',
      'type'  => 'text',
      'title' => '网站充值比例（必须是正整数1~10000）',
      'default' => '10',
      'desc' => '默认：1元等于10个货币(建议一次设置好，后续谨慎更改，会影响后台订单的汇率)',
    ),

    array(
      'id'    => 'site_no_vip_name',
      'type'  => 'text',
      'title' => '网站普通用户标识',
      'default' => 'NIP',
      'desc' => '例如：VIP，普通，平民',
    ),

    array(
      'id'    => 'site_vip_name',
      'type'  => 'text',
      'title' => '网站付费用户标识',
      'default' => 'VIP',
      'desc' => '例如：SVIP，会员，皇帝',
    ),
    
  )
));
//
// 商城-支付配置
//
CSF::createSection( $prefix, array(
  'parent'      => 'shop_fields',
  'title' => '支付配置（NEW）',
  'icon'  => 'fa fa-circle',
  'fields'      => array(
    array(
      'type'       => 'notice',
      'style'      => 'success',
      'content'    => '支付宝配置教程在会员群有文档!<br/>本支付会自动判断，如果是PC则是扫码支付，如果是手机，则自动跳转手机H5支付',
      'dependency' => array( 'alpay', '==', 'true' ),
    ),
    // 卡密开关
    array(
      'id'         => 'is_cdk_charge',
      'type'       => 'switcher',
      'title'      => '卡密充值开关',
      'label'       => '关闭后则不显示卡密充值方式',
      'default'      => true,
    ),

    array(
      'id'    => 'cdk_charge_href',
      'type'  => 'text',
      'title' => '卡密购买地址（可以填写发卡平台的购买地址）',
      'desc'      => '不填写则不开启该按钮',
      'dependency' => array( 'is_cdk_charge', '==', 'true' ),
    ),

    // 支付宝配置
    array(
      'id'         => 'is_alipay',
      'type'       => 'switcher',
      'title'      => '支付宝（企业支付）',
      'label'       => '',
      'default'      => true,
    ),
    array(
      'id'     => 'alipay',
      'type'   => 'fieldset',
      'title'  => '配置详情',
      'fields' => array(

        
        array(
          'id'    => 'pid',
          'type'  => 'text',
          'title' => '(mapi网关)-合作伙伴身份PID',
        ),
        array(
          'id'    => 'md5Key',
          'type'  => 'text',
          'title' => '(mapi网关)-MD5密钥',
        ),
        // array(
        //   'id'    => 'acc',
        //   'type'  => 'text',
        //   'title' => '(mapi网关)-卖家支付宝账号',
        // ),
        array(
          'id'         => 'is_mobile',
          'type'       => 'switcher',
          'title'      => '手机端自动跳转支付',
          'label'       => '(需签约手机网站支付)',
          'default'      => false,
        ),

        // 开放平台-当面付
        array(
          'id'         => 'is_pcqr',
          'type'       => 'switcher',
          'title'      => '当面付-扫码支付',
          'label'       => '扫码支付体验就是好（需签约当面付）',
          'default'      => false,
        ),
        array(
          'id'    => 'appid',
          'type'  => 'text',
          'title' => '开放平台-应用appid',
          'dependency' => array( 'is_pcqr', '==', 'true' ),
        ),
        array(
          'id'    => 'privateKey',
          'type'  => 'textarea',
          'title' => '开放平台-应用私钥',
          'dependency' => array( 'is_pcqr', '==', 'true' ),
        ),
        array(
          'id'    => 'publicKey',
          'type'  => 'textarea',
          'title' => '开放平台-支付宝公钥',
          'dependency' => array( 'is_pcqr', '==', 'true' ),
        ),

      ),
      'dependency' => array( 'is_alipay', '==', 'true' ),
    ),

    // 微信支付配置
    array(
      'id'         => 'is_weixinpay',
      'type'       => 'switcher',
      'title'      => '微信支付（企业支付）',
      'label'       => '',
      'default'      => false,
    ),
    array(
      'id'     => 'weixinpay',
      'type'   => 'fieldset',
      'title'  => '配置详情',
      'fields' => array(
        array(
          'id'         => 'mch_id',
          'type'       => 'text',
          'title'      => '微信支付商户号',
          'desc'      => '微信支付商户号 PartnerID 通过微信支付商户资料审核后邮件发送',
          'default'      => '',
        ),
        array(
          'id'         => 'appid',
          'type'       => 'text',
          'title'      => '公众号或小程序APPID',
          'desc'      => '公众号APPID 通过微信支付商户资料审核后邮件发送',
          'default'      => '',
        ),
        array(
          'id'         => 'key',
          'type'       => 'text',
          'title'      => '微信支付API密钥',
          'desc'      => '帐户设置-安全设置-API安全-API密钥-设置API密钥',
          'default'      => '',
        ),
        array(
          'id'         => 'is_mobile',
          'type'       => 'switcher',
          'title'      => '手机跳转H5支付',
          'label'       => '移动端自动自动切换为跳转支付（需开通H5支付）',
          'default'      => false,
        ),
      ),
      'dependency' => array( 'is_weixinpay', '==', 'true' ),
    ),

    // PAYJS支付配置
    array(
      'id'         => 'is_payjs',
      'type'       => 'switcher',
      'title'      => 'PAYJS（支持个人·微信）',
      'label'       => '因为PAYJS也是微信支付，个人建议没有官方之资质可以用此方法完美替代*_*',
      'default'      => false,
    ),
    array(
      'id'     => 'payjs',
      'type'   => 'fieldset',
      'title'  => '配置详情',
      'fields' => array(
        array(
          'id'         => 'mchid',
          'type'       => 'text',
          'title'      => 'PAYJS商户号',
          'desc'      => 'PAYJS商户号',
          'default'      => '',
        ),
        array(
          'id'         => 'key',
          'type'       => 'text',
          'title'      => 'PAYJS通信密钥',
          'desc'      => 'PAYJS通信密钥',
          'default'      => '',
        ),
        // array(
        //   'id'         => 'is_mobile',
        //   'type'       => 'switcher',
        //   'title'      => '手机跳转H5支付',
        //   'label'       => '移动端自动自动切换为跳转支付（需开通JSAPI模式,并且设置JSAPI支付目录）',
        //   'default'      => false,
        // ),
        // array(
        //   'type'       => 'notice',
        //   'style'      => 'success',
        //   'content'    => 'JSAPI支付目录设置为：'.esc_url(home_url('/')),
        // ),

      ),
      'dependency' => array( 'is_payjs', '==', 'true' ),
    ),


    //XUNHUPAY
    array(
      'id'         => 'is_xunhupay',
      'type'       => 'switcher',
      'title'      => '虎皮椒（讯虎支付·微信）',
      'label'       => '当前是最新的虎皮椒V3版，微信完美收款，无资质可以用此方法完美替代*_*',
      'default'      => false,
    ),
    array(
      'id'     => 'xunhupay',
      'type'   => 'fieldset',
      'title'  => '配置详情',
      'fields' => array(
        array(
          'type'       => 'notice',
          'style'      => 'success',
          'content'    => '虎皮椒（讯虎支付）V3  <a target="_blank" href="https://admin.xunhupay.com/sign-up/4123.html">注册地址</a><br/>如测试可使用测试APPID和密钥进行。但只支持0.1元付款测试<br/>',
        ),

        array(
          'id'         => 'appid',
          'type'       => 'text',
          'title'      => 'APPID',
          'desc'      => 'APPID（测试：2147483647）',
          'default'      => '',
        ),
        array(
          'id'         => 'appsecret',
          'type'       => 'text',
          'title'      => 'APPSECRET',
          'desc'      => '密钥（测试：160130736b1ac0d54ed7abe51e44840b）',
          'default'      => '',
        ),
        array(
          'id'         => 'url_do',
          'type'       => 'text',
          'title'      => '支付网关',
          'desc'      => '一般不用动，如虎皮椒官方有调整手动更新即可',
          'default'      => 'https://api.xunhupay.com/payment/do.html',
        ),

      ),
      'dependency' => array( 'is_xunhupay', '==', 'true' ),
    ),

  )
));
//
// 商城-会员设置
//
CSF::createSection( $prefix, array(
  'parent'      => 'shop_fields',
  'title' => '会员设置',
  'icon'  => 'fa fa-user',
  'fields'      => array(
   
    array(
      'id'    => 'vip-price',
      'type'  => 'text',
      'default'  => '1',
      'desc'  => '开通一天'._cao('site_vip_name').'所需的'._cao('site_money_ua').'数量',
      'title' => _cao('site_vip_name').'售价/天',
    ),

    array(
      'id'         => 'is_novip_down_num',
      'type'       => 'switcher',
      'title'      => '普通用户每日可下载次数限制',
      'label'       => '',
      'default'      => false,
    ),
    array(
      'id'    => 'novip_down_num',
      'type'  => 'text',
      'default'  => '5',
      'desc'  => '普通用户每日可下载次数限制，限制（价格为0）的商品，正常购买的商品，不管打折还是原价，不计数',
      'title' => '普通用户每日可下载次数',
      'dependency' => array('is_novip_down_num', '==', 'true'),
    ),

    array(
      'id'         => 'is_vip_down_num',
      'type'       => 'switcher',
      'title'      => _cao('site_vip_name').'每日可下载次数限制',
      'label'       => '',
      'default'      => false,
    ),
    array(
      'id'    => 'vip_down_num',
      'type'  => 'text',
      'default'  => '10',
      'desc'  => _cao('site_vip_name').'用户每日可下载次数限制，限制（会员折扣为0）的商品，正常购买的商品，不管打折还是原价，不计数',
      'title' => _cao('site_vip_name').'用户每日可下载次数',
      'dependency' => array('is_vip_down_num', '==', 'true'),
    ),

    array(
      'id'     => 'vip-pay-setting',
      'type'   => 'repeater',
      'title'  => '开通套餐设置（'._cao('site_vip_name').'）',
      'fields' => array(
        array(
          'id'    => 'daynum',
          'type'  => 'text',
          'default'  => '30',
          'desc'  => '比如你想设置一个套餐是月费，则填写30',
          'title' => '开通天数',
        ),
        array(
          'id'    => 'price',
          'type'  => 'text',
          'default'  => '20',
          'desc'  => '此套餐所需的'._cao('site_money_ua').'数量，例： 会员一天需要1，设置一个月费则是30，如果填写为15，则相当于在打折',
          'title' => '套餐价格',
        ),
        array(
          'id'    => 'color',
          'type'  => 'color',
          'default'  => '#ff6a6d',
          'title' => '背景颜色',
        ),
      ),
      'default' => array(
        array(
          'daynum' => '1',
          'price'    => '1',
          'color'    => '#ff6a6d',
        ),
      ),
    ),

  )
));

//
// 商城-佣金设置
//
CSF::createSection( $prefix, array(
  'parent'      => 'shop_fields',
  'title' => '佣金设置',
  'icon'  => 'fa fa-circle',
  'fields'      => array(
    
    array(
      'id'         => 'is_ref_to_rmb',
      'type'       => 'switcher',
      'title'      => '关闭RMB提现功能',
      'label'       => '关闭后只支持提现到站内余额',
      'default'      => false,
    ),


    array(
      'id'         => 'is_charge_ref_float',
      'type'       => 'switcher',
      'title'      => '用户充值佣金奖励',
      'label'       => '',
      'default'      => false,
    ),

    array(
      'id'    => 'site_novip_ref_float',
      'type'  => 'slider',
      'title' => _cao('site_no_vip_name').'推荐充值消费佣金奖励比例*',
      'default' => '0.1',
      'max' => '1',
      'min' => '0',
      'step' => '0.1',
      'desc' => '0.2为20%,用户A推荐B注册充值，A可以得到B的实际付款RMB金额的20%的佣金，以此类推，0为关闭，此处佣金只在RMB充值站内余额的时候有效，卡密等不给佣金 怕血亏',
      'dependency' => array('is_charge_ref_float', '==', 'true'),
    ),
    array(
      'id'    => 'site_vip_ref_float',
      'type'  => 'slider',
      'title' => _cao('site_vip_name').'推荐充值消费佣金奖励比例*',
      'default' => '0.1',
      'max' => '1',
      'min' => '0',
      'step' => '0.1',
      'desc' => '0.2为20%,用户A推荐B注册充值，A可以得到B的实际付款RMB金额的20%的佣金，以此类推，0为关闭，此处佣金只在RMB充值站内余额的时候有效，卡密等不给佣金 怕血亏',
      'dependency' => array('is_charge_ref_float', '==', 'true'),
    ),


    array(
      'id'         => 'is_postpay_ref_float',
      'type'       => 'switcher',
      'title'      => '资源购买作者佣金',
      'label'       => '',
      'default'      => false,
    ),

    array(
      'id'    => 'site_postpay_ref_float',
      'type'  => 'slider',
      'title' => '作者佣金分红比例*',
      'default' => '0.1',
      'max' => '1',
      'min' => '0',
      'step' => '0.1',
      'desc' => '如果文章是用户发布的，被购买时奖励此作者佣金比例',
      'dependency' => array('is_postpay_ref_float', '==', 'true'),
    ),

    
    array(
      'id'    => 'site_min_tixian_num',
      'type'  => 'text',
      'title' => '网站最低提现金额限制/元',
      'default' => '1',
    ),

    


  )
));

//
// 网站-登录注册
//
CSF::createSection( $prefix, array(
  'title' => '登录注册',
  'icon'  => 'fa fa-user-o',
  'fields'      => array(
     array(
      'id'    => 'is_avatar_loaz',
      'type'  => 'switcher',
      'title' => '用户头像懒加载',
      'label' => '开启后网站速度明显翻倍，因为头像是通过API获取',
      'default' => true,
    ),
    array(
        'id'      => 'is_captcha_qq',
        'type'    => 'switcher',
        'title'   => '推荐-开启腾讯防水墙',
        'label'   => '开启后需要点击验证哦，申请地址：https://007.qq.com/',
        'default' => false,
    ),
    array(
      'id'    => 'captcha_qq_appid',
      'type'  => 'text',
      'title' => 'APPID',
      'desc' => '你在腾讯防水墙申请到的APPID',
      'dependency' => array('is_captcha_qq', '==', 'true'),
    ),
    array(
      'id'    => 'captcha_qq_secretkey',
      'type'  => 'text',
      'title' => 'Secret Key',
      'desc' => '你在腾讯防水墙申请到的Secret Key',
      'dependency' => array('is_captcha_qq', '==', 'true'),
    ),

    array(
        'id'      => 'is_close_wplogin',
        'type'    => 'switcher',
        'title'   => '仅限社交登录',
        'label'   => '仅限第三方登录，关闭表单登录',
        'default' => false,
    ),
    array(
        'id'      => 'is_close_wpreg',
        'type'    => 'switcher',
        'title'   => '仅限社交账号注册',
        'label'   => '仅限第三方注册，关闭表单注册',
        'default' => false,
    ),
    array(
        'id'      => 'is_email_reg_cap',
        'type'    => 'switcher',
        'title'   => '网站注册需要邮件验证码',
        'label'   => '需要开启SMTP服务，可有效防止垃圾注册等',
        'default' => false,
    ),
    array(
      'id'    => 'is_oauth_qq',
      'type'  => 'switcher',
      'title' => 'QQ登录',
      'label' => '申请地址：https://connect.qq.com/',
      'default' => false,
    ),
    array(
      'id'     => 'oauth_qq',
      'type'   => 'fieldset',
      'title'  => '配置详情',
      'fields' => array(
        array(
            'id'         => 'backurl',
            'type'       => 'text',
            'title'      => '回调地址',
            'attributes' => array(
                'readonly' => 'readonly',
            ),
            'default'    => esc_url(home_url('/oauth/qq/callback')),
        ),
        array(
          'id'    => 'appid',
          'type'  => 'text',
          'title' => 'Appid',
          'default' => '',
        ),
        array(
          'id'    => 'appkey',
          'type'  => 'text',
          'title' => 'Appkey',
          'default' => '',
        ),
        array(
          'id'    => 'agent',
          'type'  => 'switcher',
          'title' => 'CAO-qq-Agent',
          'label' => '开启此项可完美解决只能设置一个回调域名的问题',
          'default' => false,
        ),

      ),
      'dependency' => array( 'is_oauth_qq', '==', 'true' ),
    ),

    // 微信登录
    array(
      'id'    => 'is_oauth_weixin',
      'type'  => 'switcher',
      'title' => '微信登录',
      'label' => '申请地址：https://open.weixin.qq.com/',
      'default' => false,
    ),
    array(
      'id'     => 'oauth_weixin',
      'type'   => 'fieldset',
      'title'  => '配置详情',
      'fields' => array(
        array(
            'id'         => 'backurl',
            'type'       => 'text',
            'title'      => '回调地址',
            'attributes' => array(
                'readonly' => 'readonly',
            ),
            'default'    => esc_url(home_url('/oauth/weixin/callback')),
        ),
        array(
          'id'    => 'appid',
          'type'  => 'text',
          'title' => 'Appid',
          'default' => '',
        ),
        array(
          'id'    => 'appkey',
          'type'  => 'text',
          'title' => 'AppSecret',
          'default' => '',
        ),
        array(
          'id'    => 'agent',
          'type'  => 'switcher',
          'title' => 'CAO-weixin-Agent',
          'label' => '开启此项可完美解决只能设置一个回调域名的问题',
          'default' => false,
        ),
      ),
      'dependency' => array( 'is_oauth_weixin', '==', 'true' ),
    ),

    // 微博登录
    array(
      'id'    => 'is_oauth_weibo',
      'type'  => 'switcher',
      'title' => '微博登录',
      'label' => '申请地址：https://open.weibo.com/authentication/',
      'default' => false,
    ),
    array(
      'id'     => 'oauth_weibo',
      'type'   => 'fieldset',
      'title'  => '配置详情',
      'fields' => array(
        array(
            'id'         => 'backurl',
            'type'       => 'text',
            'title'      => '回调地址',
            'attributes' => array(
                'readonly' => 'readonly',
            ),
            'default'    => esc_url(home_url('/oauth/weibo/callback')),
        ),
        array(
          'id'    => 'appid',
          'type'  => 'text',
          'title' => 'Appid',
          'default' => '',
        ),
        array(
          'id'    => 'appkey',
          'type'  => 'text',
          'title' => 'Appkey',
          'default' => '',
        ),
        array(
          'id'    => 'agent',
          'type'  => 'switcher',
          'title' => 'CAO-weibo-Agent',
          'label' => '开启此项可完美解决只能设置一个回调域名的问题',
          'default' => false,
        ),
      ),
      'dependency' => array( 'is_oauth_weibo', '==', 'true' ),
    ),
    
  )
) );

//
// 网站-用户中心
//
CSF::createSection( $prefix, array(
  'title' => '用户中心',
  'icon'  => 'fa fa-user-o',
  'fields'      => array(
    array(
      'id'    => 'is_nav_write',
      'type'  => 'switcher',
      'title' => '是否显示投稿/我的文章菜单',
      'label' => '',
      'default' => true,
    ),
    array(
      'id'    => 'is_nav_ref',
      'type'  => 'switcher',
      'title' => '是否显示推广佣金菜单',
      'label' => '',
      'default' => true,
    ),

    array(
        'id'      => 'is_user_bang_email',
        'type'    => 'switcher',
        'title'   => '用户修改邮箱需要验证码',
        'label'   => '需要开启SMTP服务，可有效防止垃圾注册等',
        'default' => false,
    ),

    array(
        'id'      => 'is_userpage_vip_head',
        'type'    => 'switcher',
        'title'   => '我的会员页面',
        'label'   => '我的会员页面顶部显示余额块',
        'default' => false,
    ),

    array(
        'id'      => 'is_userpage_charge_head',
        'type'    => 'switcher',
        'title'   => '充值中心页面',
        'label'   => '充值中心页面顶部显示余额块',
        'default' => false,
    ),

    array(
        'id'      => 'is_mail_nitfy_reg',
        'type'    => 'switcher',
        'title'   => '用户注册成功邮件提醒',
        'default' => true,
    ),

    array(
        'id'      => 'is_mail_nitfy_charge',
        'type'    => 'switcher',
        'title'   => '用户在线充值成功邮件提醒',
        'default' => true,
    ),
    array(
        'id'      => 'is_mail_nitfy_cdk',
        'type'    => 'switcher',
        'title'   => '用户卡密充值成功邮件提醒',
        'default' => true,
    ),
    array(
        'id'      => 'is_mail_nitfy_vip',
        'type'    => 'switcher',
        'title'   => '用户开通/续费'._cao('site_vip_name','会员').'成功邮件提醒',
        'default' => false,
    ),
    array(
        'id'      => 'is_mail_nitfy_pay',
        'type'    => 'switcher',
        'title'   => '用户购买资源成功邮件提醒',
        'default' => false,
    ),

    
    
  )
) );



//
// SMTP设置
//
CSF::createSection($prefix, array(
    'title'       => 'SMTP设置',
    'icon'        => 'fa fa-envelope',
    'description' => 'SMTP设置可以解决wordpress无法发送邮件问题，建议用QQ邮箱，注意QQ邮箱的密码是独立密码。不是QQ密码！',
    'fields'      => array(

        array(
            'id'      => 'mail_smtps',
            'type'    => 'switcher',
            'title'   => '是否启用SMTP服务',
            'label'   => '该设置主题自带，不能与插件重复开启',
            'default' => false,
        ),
        array(
            'id'       => 'mail_name',
            'type'     => 'text',
            'title'    => '发信邮箱',
            'subtitle' => '请填写发件人邮箱帐号',
            'default'  => '88888888@qq.com',
            'validate' => 'csf_validate_email',
        ),

        array(
            'id'       => 'mail_host',
            'type'     => 'text',
            'title'    => '邮件服务器',
            'subtitle' => '请填写SMTP服务器地址',
            'default'  => 'smtp.qq.com',
        ),
        array(
            'id'       => 'mail_port',
            'type'     => 'text',
            'title'    => '服务器端口',
            'subtitle' => '请填写SMTP服务器端口',
            'default'  => '465',
        ),
        array(
            'id'       => 'mail_passwd',
            'type'     => 'text',
            'title'    => '邮箱密码',
            'subtitle' => '请填写SMTP服务器邮箱密码',
            'default'  => '88888888',
        ),
        array(
            'id'      => 'mail_smtpauth',
            'type'    => 'switcher',
            'title'   => '启用SMTPAuth服务',
            'label'   => '是否启用SMTPAuth服务',
            'default' => true,
        ),
        array(
            'id'       => 'mail_smtpsecure',
            'type'     => 'text',
            'title'    => 'SMTPSecure设置',
            'subtitle' => '若启用SMTPAuth服务则填写ssl，若不启用则留空',
            'default'  => 'ssl',
        ),

    ),
));



//
// 广告设置
//
CSF::createSection($prefix, array(
    'title'  => '广告设置',
    'icon'   => 'fa fa-legal',
    'fields' => array(

        array(
            'id'      => 'ad_list_header_s',
            'type'    => 'switcher',
            'title'   => '列表头部',
            'label'   => '',
            'default' => false,
        ),
        array(
            'id'         => 'ad_list_header',
            'type'       => 'code_editor',
            'title'      => '广告代码',
            'subtitle'   => '广告HTML代码',
            'settings'   => array(
                'theme' => 'dracula',
                'mode'  => 'html',
            ),
            'default'    => '<a href="https://github.com/AdFate/RiPro" target="_blank" rel="nofollow"><img src="'.get_stylesheet_directory_uri() . '/assets/images/hero/ads.jpg"></a>',
            'dependency' => array('ad_list_header_s', '==', 'true'),
        ),

        array(
            'id'      => 'ad_list_footer_s',
            'type'    => 'switcher',
            'title'   => '列表底部',
            'label'   => '',
            'default' => false,
        ),
        array(
            'id'         => 'ad_list_footer',
            'type'       => 'code_editor',
            'title'      => '广告代码',
            'subtitle'   => '广告HTML代码',
            'settings'   => array(
                'theme' => 'dracula',
                'mode'  => 'html',
            ),
            'default'    => '<a href="https://github.com/AdFate/RiPro" target="_blank" rel="nofollow"><img src="'.get_stylesheet_directory_uri() . '/assets/images/hero/ads.jpg"></a>',
            'dependency' => array('ad_list_footer_s', '==', 'true'),
        ),

        array(
            'id'      => 'ad_post_header_s',
            'type'    => 'switcher',
            'title'   => '文章内容上',
            'label'   => '',
            'default' => false,
        ),
        array(
            'id'         => 'ad_post_header',
            'type'       => 'code_editor',
            'title'      => '广告代码',
            'subtitle'   => '广告HTML代码',
            'settings'   => array(
                'theme' => 'dracula',
                'mode'  => 'html',
            ),
            'default'    => '<a href="https://github.com/AdFate/RiPro" target="_blank" rel="nofollow"><img src="'.get_stylesheet_directory_uri() . '/assets/images/hero/ads.jpg"></a>',
            'dependency' => array('ad_post_header_s', '==', 'true'),
        ),

        array(
            'id'      => 'ad_post_footer_s',
            'type'    => 'switcher',
            'title'   => '文章内容下',
            'label'   => '',
            'default' => false,
        ),
        array(
            'id'         => 'ad_post_footer',
            'type'       => 'code_editor',
            'title'      => '广告代码',
            'subtitle'   => '广告HTML代码',
            'settings'   => array(
                'theme' => 'dracula',
                'mode'  => 'html',
            ),
            'default'    => '<a href="https://github.com/AdFate/RiPro" target="_blank" rel="nofollow"><img src="'.get_stylesheet_directory_uri() . '/assets/images/hero/ads.jpg"></a>',
            'dependency' => array('ad_post_footer_s', '==', 'true'),
        ),

    ),
));

//
// Field: 底部设置
//
CSF::createSection($prefix, array(
    'title'  => '底部设置',
    'icon'   => 'fa fa-circle',
    'fields' => array(


      // Banner
      array(
        'id'     => 'mode_banner',
        'type'   => 'fieldset',
        'title'  => 'banner背景图块',
        'fields' => array(
          array(
            'id'    => 'bgimg',
            'type'  => 'upload',
            'title' => '背景图',
            'default'     => get_stylesheet_directory_uri() . '/assets/images/background/bg-1.jpg',
          ),
          array(
              'id'      => 'text',
              'type'    => 'text',
              'title'   => '标题',
              'default' => '提供最优质的资源集合',
          ),

          array(
              'id'      => 'primary_text',
              'type'    => 'text',
              'title'   => '按钮1名称',
              'default' => '立即查看',
          ),
          array(
              'id'      => 'primary_link',
              'type'    => 'text',
              'title'   => '按钮1链接',
              'default' => 'https://github.com/AdFate',
          ), 
          
          array(
              'id'      => 'secondary_text',
              'type'    => 'text',
              'title'   => '按钮2名称',
              'default' => '了解详情',
          ), 
          array(
              'id'      => 'secondary_link',
              'type'    => 'text',
              'title'   => '按钮2链接',
              'default' => 'https://github.com/AdFate/RiPro',
          ),

          
        ),
      ),
      
      array(
          'id'      => 'is_diy_footer',
          'type'    => 'switcher',
          'title'   => '是否开启底部DIY的html结构',
          'default' => true,
      ),

      array(
        'type'       => 'notice',
        'style'      => 'success',
        'content'    => '为更大程度的方便站着DIY自己的底部。底部请手动修改文件：<br/>/ripro/parts/diy-footer.php<br/>',
      ),
      array(
          'id'       => 'cao_copyright_text',
          'type'     => 'text',
          'title'    => '底部版权信息',
          'subtitle' => '自定义版权信息',
          'default'  => '© 2018 RIPRO - VIP.YLIT.CC &amp; WordPress Theme. All rights reserved',
      ),

      array(
          'id'       => 'cao_ipc_info',
          'type'     => 'text',
          'title'    => '网站备案号',
          'subtitle' => '',
          'default'  => '京ICP证8888888号 ',
      ),

      array(
          'id'      => 'is_console_footer',
          'type'    => 'switcher',
          'title'   => '是否在浏览器开发者选项显示网站系查询日志',
          'default' => true,
      ),

      array(
          'id'       => 'web_js',
          'type'     => 'code_editor',
          'title'    => '网站底部自定义JS代码',
          'subtitle' => '位于底部，用于添加第三方流量数据统计代码，如：Google analytics、百度统计、CNZZ',
          'settings' => array(
              'theme' => 'dracula',
              'mode'  => 'javascript',
          ),
          'default'  => '',
      ),

        
    ),
));


//
// 辅助其他
//
CSF::createSection($prefix, array(
    'title'       => '辅助其他',
    'icon'        => 'fa fa-envelope',
    'description' => '包含网站的功能组件，例如通知风格等设置',
    'fields'      => array(

        array(
            'id'      => 'disabled_block_editor',
            'type'    => 'switcher',
            'title'   => '禁用WP5.0+ 古滕堡反人类编辑器',
            'desc'    => '建议关闭，使用传统编辑器',
            'default' => true,
        ),
    ),
));




//
// Field: backup
//
CSF::createSection($prefix, array(
    'title'       => '备份恢复',
    'icon'        => 'fa fa-shield',
    'description' => '备份-恢复您的主题设置，方便迁移快速复刻网站</a>',
    'fields'      => array(

        array(
            'type' => 'backup',
        ),

    ),
));


CSF::createSection($prefix, array(
    'title'       => '主题授权',
    'icon'        => 'fa fa-handshake-o',
    'description' => '
    <h2><i class="fa fa-heart" style=" color: red; "></i>GitHub仓库： https://github.com/AdFate/RiPro <i class="fa fa-heart" style=" color: red; "></i></h2>
    <h2>这个主题Bug 数不胜数,作者还会日你三千遍,没必要受这个罪</h2>
    <h2>建议您还是把 买主题的钱 捐给公益机构.</h2>
    <h2>如果激活失败,请访问仓库,获取最新激活方式.</h2>
    ',
    'fields'      => array(
        
        array(
            'id'    => 'ripro_vip_id',
            'type'  => 'text',
            'title' => '会员ID',
            'default' => '天王盖地虎', 
            'attributes' => array(
                'readonly' => 'readonly',
            )
        ),
        array(
            'id'    => 'ripro_vip_code',
            'type'  => 'text',
            'title' => '授权码',
            'default' => '宝塔镇河妖', 
            'attributes' => array(
                'readonly' => 'readonly',
            )
        ),
       
    ),
));
