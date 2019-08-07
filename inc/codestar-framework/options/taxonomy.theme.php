<?php if (!defined('ABSPATH')) {die;} // Cannot access directly.

//
// Set a unique slug-like ID
//
$prefix = '_cao_taxonomy_options';

//
// Create taxonomy options
//
CSF::createTaxonomyOptions($prefix, array(
    'taxonomy'  => array('post_tag' , 'category'),
    'data_type' => 'unserialize', // The type of the database save options. `serialize` or `unserialize`
));
//
// Create a section
//
CSF::createSection($prefix, array(
    'fields' => array(

        
        array(
          'id'      => 'the_style',
          'type'    => 'radio',
          'title'   => '文章布局风格',
          'options' => array(
            'grid'   => '网格布局',
            'list'    => '列表布局',
          ),
          'default' => 'grid',
        ),
        array(
          'id'    => 'is_sidebar',
          'type'  => 'switcher',
          'title' => '是否显示文章侧边栏',
        ),
        array(
          'id'    => 'is_filter',
          'type'  => 'switcher',
          'title' => '禁用本内页高级筛选功能',
        ),
        
        array(
            'id'    => 'seo-title',
            'type'  => 'text',
            'title' => '自定义SEO标题',
            'help'  => '不设置则遵循WP标题规则',
        ),
        array(
            'id'    => 'seo-keywords',
            'type'  => 'textarea',
            'title' => '自定义SEO关键词',
            'help'  => '自定义SEO关键词,用英文逗号隔开',
        ),
        array(
            'id'    => 'seo-description',
            'type'  => 'textarea',
            'title' => '自定义SEO描述',
            'help'  => '自定义SEO描述',
        ),


    ),
));
