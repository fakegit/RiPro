<div class="footer-widget">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3 widget--about">
            <div class="widget--content">
                <div class="footer--logo mb-20">
                    <img class="tap-logo" src="<?php echo esc_url( _cao( 'site_logo') ); ?>" data-dark="<?php echo esc_url(_cao( 'site_dark_logo')); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                </div>
                <p class="mb-10">RIPRO主题，余额管理，自定义积分，集成支付，卡密，推广奖励等。https://github.com/AdFate/RiPro 免费在线激活</p>
            </div>
        </div>
        <!-- .col-md-2 end -->
        <div class="col-xs-12 col-sm-3 col-md-2 col-md-offset-1 widget--links">
            <div class="widget--title">
                <h5>本站导航</h5>
            </div>
            <div class="widget--content">
                <ul class="list-unstyled mb-0">
                    <li><a href="#">关于我们</a></li>
                    <li><a href="#">充值说明</a></li>
                    <li><a href="#">下载说明</a></li>
                </ul>
            </div>
        </div>
        <!-- .col-md-2 end -->
        <div class="col-xs-12 col-sm-3 col-md-2 widget--links">
            <div class="widget--title">
                <h5>更多介绍</h5>
            </div>
            <div class="widget--content">
                <ul class="list-unstyled mb-0">
                    <li><a href="#">隐私协议</a></li>
                    <li><a href="#">权限说明</a></li>
                    <li><a href="#">账户中心</a></li>
                </ul>
            </div>
        </div>
        <!-- .col-md-2 end -->
        <div class="col-xs-12 col-sm-12 col-md-4 widget--newsletter">
            <div class="widget--title">
                <h5>快速搜索</h5>
            </div>
            <div class="widget--content">
                <form class="newsletter--form mb-30" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                    <input type="text" class="form-control" name="s" placeholder="关键词">
                    <button type="submit"><i class="fa fa-arrow-right"></i></button>
                </form>
                <h6>RiPro 会员版V <?php echo _the_theme_version();?></h6>
            </div>
        </div>

    </div>
</div>