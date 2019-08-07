<?php 
    if (!_cao('is_filter_bar')) :
    $categories = get_categories( array('hide_empty' => 1) );//获取所有分类
    $cat_ID = (is_category()) ? get_query_var('cat') : 0 ;
?>

<div class="filter--content">
    <form class="mb-0" method="get" action="<?php echo home_url(); ?>">
    	<input type="hidden" name="s">
        <div class="form-box search-properties mb-0">
            <!-- 一级分类 -->
            <div class="filter-item">
                <?php

                $content = '<ul class="filter-tag"><span><i class="fa fa-folder-open-o"></i> 分类：</span>';
                foreach ($categories as $category) {
                   	// 排除二级分类
                    if ($category->category_parent == 0) {
                        $_oncss = ($category->term_id == $cat_ID) ? 'on' : '' ;
                        $content .= '<li><a href="'.get_category_link($category->term_id).'" class="'.$_oncss.'">'.$category->name.'</a></li>';
                    }
                }
                $content .= "</ul>";
                echo $content;
                ?>
            </div>

            <?php
            if (is_category()) {
                $child_categories = get_categories( array('hide_empty' => 0,'parent'=>$cat_ID) );//获取所有分类
            }
            if (!empty($child_categories)) : ?>
            <!-- 二级分类 -->
			<div class="filter-item">
                <?php
                    $content = '<ul class="filter-tag"><span><i class="fa fa-long-arrow-right"></i> 更多：</span>';
                    foreach ($child_categories as $category) {
                        $content .= '<li><a href="'.get_category_link($category->term_id).'">'.$category->name.'</a></li>';
                    }
                    $content .= "</ul>";
                    echo $content;
                ?>
            </div>
            <?php endif; ?>
            <!-- 相关标签 -->
			<div class="filter-item">
				<?php
					$cat_ID = (get_query_var('cat')) ? get_query_var('cat') : 0 ;
					$this_cat_arg = array( 'categories' => $cat_ID);
					$tags = _get_category_tags($this_cat_arg);
					$content = '<ul class="filter-tag"><span><i class="fa fa-tags"></i> 标签：</span>';
					if(!empty($tags)) {
					  foreach ($tags as $tag) {
					    $content .= '<li><a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a></li>';
					  }
					}else{$content .= '<li><a href="#">暂无相关标签</a></li>';}
					$content .= "</ul>";
					echo $content;
				?>
			</div>
            
            <!-- 快速筛选 -->
            <div class="filter-item">
                <?php
                    $is_on = !empty($_GET['cao_type']) ? $_GET['cao_type'] : '';
                    $cao_vip_name = _cao('site_vip_name');
                    $content = '<ul class="filter-tag"><span><i class="fa fa-filter"></i> 价格：</span>';
                    $caotype_arr = array('1' => '免费','2' => '付费' ,'3' => $cao_vip_name.'免费','4' => $cao_vip_name.'优惠');
                    foreach ($caotype_arr as $key => $item) {
                        $_oncss = ($is_on == $key) ? 'on' : '' ;
                        $content .= '<li><a href="'.add_query_arg("cao_type",$key).'" class="'.$_oncss.'">'.$item.'</a></li>';
                    }
                    $content .= "</ul>";
                    echo $content;
                ?>
            </div>

            <!-- 排序 -->
            <div class="filter-item">
                <?php
                    $is_on = !empty($_GET['order']) ? $_GET['order'] : 'date';
                    $content = '<ul class="filter-tag"><span><i class="fa fa-sort-alpha-desc"></i> 排序：</span>';
                    $order_arr = array('date' => '发布日期','ID' => 'ID' ,'title' => '标题','modified' => '修改时间','comment_count' => '评论数量','rand' => '随机');
                    foreach ($order_arr as $key => $item) {
                        $_oncss = ($is_on == $key) ? 'on' : '' ;
                        $content .= '<li><a href="'.add_query_arg("order",$key).'" class="'.$_oncss.'">'.$item.'</a></li>';
                    }
                    $content .= "</ul>";
                    echo $content;
                ?>
            </div>



            <!-- .row end -->
        </div>
        <!-- .form-box end -->
    </form>
</div>
<?php endif;?>