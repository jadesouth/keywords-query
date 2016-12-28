<?php if(! empty($banners)):?>
<div class="banner clearfix">
    <div class="flicker-example" data-block-text="false">
        <ul>
            <?php  foreach($banners as $banner):?>
            <li data-background="<?=base_url('resources/uploads/' . $banner['img_path'])?>"></li>
            <?php endforeach;?>
        </ul>
    </div>
</div>
<?php endif;?>
<div class="m-width">
    <div class="doc_list_l clearfix" style="margin-top:30px;">
        <div class="m-all-ks">
            <dl class="all-ks all-ks1 fl clearfix">
                <dt class="clearfix">
                    <span><i><img src="/resources/assets/images/1.png" width="40" height="38"></i>
                        <a href="/articles/business">业务介绍</a>
                    </span>
                </dt>
                <dt>
                    <p style="line-height:30px;font-size:14px;color:#666;height:90px;overflow:hidden;text-overflow:ellipsis;text-indent:2em;">
                    <?=empty($areas[0]['resume']) ? '' : mb_substr($areas[0]['resume'], 0, 68, 'utf-8') . '...'?>
                    </p>
                </dt>
            </dl>
            <dl class="all-ks all-ks12 fl clearfix">
                <dt class="clearfix">
                    <span><i><img src="/resources/assets/images/2.png" width="40" height="38"></i>
                        <a href="/articles/property">知识产权服务</a>
                    </span>
                </dt>
                <dt>
                    <p style="line-height:30px;font-size:14px;color:#666;height:90px;overflow:hidden;text-overflow:ellipsis;text-indent:2em;">
                        <?=empty($areas[2]['resume']) ? '' : mb_substr($areas[2]['resume'], 0, 68, 'utf-8') . '...'?>
                    </p>
                </dt>
            </dl>
            <dl class="all-ks all-ks12 fl clearfix">
                <dt class="clearfix">
                    <span><i><img src="/resources/assets/images/3.png" width="40" height="38"></i>
                        <a href="/articles/price">价格管控</a>
                    </span>
                </dt>
                <dt>
                    <p style="line-height:30px;font-size:14px;color:#666;height:90px;overflow:hidden;text-overflow:ellipsis;text-indent:2em;">
                        <?=empty($areas[3]['resume']) ? '' : mb_substr($areas[3]['resume'], 0, 68, 'utf-8') . '...'?>
                    </p>
                </dt>
            </dl>
            <dl class="all-ks all-ks12 fl clearfix">
                <dt class="clearfix">
                    <span><i><img src="/resources/assets/images/4.png" width="40" height="38"></i>
                        <a href="/articles/cases">合作案例</a>
                    </span>
                </dt>
                <dt>
                    <p style="line-height:30px;font-size:14px;color:#666;height:90px;overflow:hidden;text-overflow:ellipsis;text-indent:2em;">
                        <?=empty($areas[1]['resume']) ? '' : mb_substr($areas[1]['resume'], 0, 68, 'utf-8') . '...'?>
                    </p>
                </dt>
            </dl>
            <dl class="all-ks all-ks12 fl clearfix">
                <dt class="clearfix">
                    <span><i><img src="/resources/assets/images/5.png" width="40" height="38"></i>
                        <a href="/articles/cases">广告法检测</a>
                    </span>
                </dt>
                <dt>
                    <p style="line-height:30px;font-size:14px;color:#666;height:90px;overflow:hidden;text-overflow:ellipsis;text-indent:2em;">
                        <?=empty($areas[1]['resume']) ? '' : mb_substr($areas[1]['resume'], 0, 68, 'utf-8') . '...'?>
                    </p>
                </dt>
            </dl>
            <dl class="all-ks all-ks12 fl clearfix">
                <dt class="clearfix">
                    <span><i><img src="/resources/assets/images/6.png" width="40" height="38"></i>
                        <a href="/articles/cases">地址检测</a>
                    </span>
                </dt>
                <dt>
                    <p style="line-height:30px;font-size:14px;color:#666;height:90px;overflow:hidden;text-overflow:ellipsis;text-indent:2em;">
                        <?=empty($areas[1]['resume']) ? '' : mb_substr($areas[1]['resume'], 0, 68, 'utf-8') . '...'?>
                    </p>
                </dt>
            </dl>
        </div>
    </div>
    <div style="clear:both;"></div>
    <div class="m5 clearfix">
        <p>最新动态<a href="/articles/index/1">更多</a></p>
        <?php if(! empty($articles)):?>
        <ul class="clearfix">
            <?php foreach($articles as $article):?>
            <li><a href="/articles/desc/<?=$article['id']?>"><?=$article['title']?></a></li>
            <?php endforeach;?>
        </ul>
        <?php endif;?>
    </div>
</div>
<script src="<?=base_url()?>resources/assets/libs/jquery-finger/jquery-finger-v0.1.0.min.js"></script>
<script src="<?=base_url()?>resources/assets/libs/flickerplate/flickerplate.min.js"></script>
<script>
$(document).ready(function() {
    //banner
    $(document).ready(function(){
        $('.flicker-example').flicker();
    });
});
</script>
