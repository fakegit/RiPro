<?php
$mode_search = _cao('mode_search');
$image = $mode_search['bgimg'];
$categories = get_categories( array('hide_empty' => 0) );//获取所有分类
?>
<div class="section">
	  	<div class="container">
			<div class="row">
				<div class="home-filter--content">
				    <form class="mb-0" method="get" action="<?php echo home_url(); ?>">
				        <div class="form-box search-properties mb-0">
				            <div class="row">
				                <div class="col-xs-12 col-sm-6 col-md-9">
				                    <div class="form-group mb-0">
				                        <input type="text" name="s" placeholder="输入关键词搜索...">
				                    </div>
				                </div>
				                
				                <div class="col-xs-12 col-sm-6 col-md-3">
				                    <input type="submit" value="搜索"  class="btn btn--block">
				                </div>
				            </div>
							
				            <!-- .row end -->
				        </div>
				        <!-- .form-box end -->
				    </form>
				</div>
		</div>
	</div>
</div>