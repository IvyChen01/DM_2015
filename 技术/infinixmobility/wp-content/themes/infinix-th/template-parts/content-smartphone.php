<?php
/**
 * Template part for displaying single posts.
 *
 * @package Infinix
 */

global $post;
?>

<?php
    $kv = get_post_meta( $post->ID, '_kv', true );
    $background = !empty($kv['color']) ? 'background-color:'.$kv['color'].';' : '';
    $background .= !empty($kv['bg']) ? 'background-image:url('.$kv['bg'].');' : '';
?>
<section class="phone-banner" style="<?php echo $background?>">
    <div class="container">
        <div class="row">
            <?php echo $kv['detail']?>
        </div>
    </div>
</section>

<article>
    <?php
    $sp = get_post_meta( $post->ID, '_sp', true );
    $sp_html = '';
    for ($i=0,$j=count($sp); $i < $j; $i++)
    {
        $sp_html .= '<section class="sp-section';
        $sp_html .= isset($sp[$i]['text-center']) ? ' x-text-center' : '';
        $sp_html .= isset($sp[$i]['text-light']) ? ' x-text-light' : '';
        $sp_html .= '" id="sp'.($i+1).'" style="';
        $sp_html .= !empty($sp[$i]['color']) ? 'background-color:'.$sp[$i]['color'].';' : '';
        $sp_html .= !empty($sp[$i]['bg']) ? 'background-image:url('.$sp[$i]['bg'].');' : '';
        $sp_html .= '">';
            // $sp_html .= '<div class="container">';
            //     $sp_html .= '<div class="row">';
                    $sp_html .= $sp[$i]['content'];
            //     $sp_html .= '</div>';
            // $sp_html .= '</div>';
        $sp_html .= '</section>';
    }
    echo $sp_html;

    //$video = get_post_meta( $post->ID, '_video', true );
    ?>
    <?php /*
    <section class="sp-section sp-video" style="background-image: url(<?php echo $video['bg']?>);">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <img class="sp-pic" src="<?php echo $video['logo']?>">
                </div>
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <div class="video-container">
                        <iframe width="560" height="315" src="<?php echo $video['url']?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="sp-section sp-spec" id="sp<?php echo $i+1?>">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="sp-slide row">
                        <?php
                        $photos = get_post_meta( $post->ID, '_photos', true );
                        ?>
                        <div class="col-xs-12">
                            <div class="sp-slide-box">
                            <img src="<?php echo $photos[0]; ?>">
                            </div>
                        </div>
                        <div class="sp-slide-nav">
                            <?php
                            $photo_html = '';
                            for ($i=0,$j=count($photos); $i < $j; $i++)
                            {
                                $photo_html .= '<div class="col-xs-3 col-sm-3 col-md-2"><img src="'.$photos[$i].'"></div>';
                            }
                            echo $photo_html;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="row">
                        <?php
                        $features = get_post_meta( $post->ID, '_features', true );
                        $feature_html = '<div class="col-xs-12 col-sm-6">';
                        for ($i=0,$j=count($features); $i < $j; $i++)
                        {
                            if ($i == ceil($j/2))
                            {
                                $feature_html .= '</div><div class="col-xs-12 col-sm-6">';
                            }
                            $feature_html .= '<div class="sp-spec-item"><h4>'.$features[$i]['title'].'</h4><p>'.$features[$i]['detail'].'</p></div>';
                        }
                        $feature_html .= '</div>';
                        echo $feature_html;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    */ ?>
</article>

<!-- Area modal -->
<div class="modal fade buy-modal" id="buyArea" tabindex="-1" role="dialog" aria-labelledby="buyAreaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="buyAreaLabel">Please choose your location</h4>
            </div>
            <div class="modal-body">
                <div class="area-list row">
                    <div class="col-xs-3 show-country"><a class="area-1" href="#"><img src="<?php echo theme_image_url() ?>/area-1.jpg"></a><span>Africa</span></div>
                    <div class="col-xs-3 show-country"><a class="area-2" href="#"><img src="<?php echo theme_image_url() ?>/area-2.jpg"></a><span>Middle East</span></div>
                    <div class="col-xs-3 show-country"><a class="area-3" href="#"><img src="<?php echo theme_image_url() ?>/area-3.jpg"></a><span>Asia</span></div>
                    <div class="col-xs-3 show-country"><a class="area-4" href="#"><img src="<?php echo theme_image_url() ?>/area-4.jpg"></a><span>Europe</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Country modal -->
<div class="modal fade buy-modal" id="buyCountry" tabindex="-1" role="dialog" aria-labelledby="buyCountryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="buyCountryLabel">Please choose your Country</h4>
            </div>
            <div class="modal-body">
            <?php $buy_links = get_post_meta( $post->ID, '_buy', true );?>
                <!-- Area 1 -->
                <div class="country-list" id="area-0">
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-cotedivorie.jpg"><span>Ghana</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                            <?php
                            $i=0;
                            $html='';
                            foreach ($buy_links as $link)
                            {
                                if($link['country']=='cotedivorie')
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                    $i++;
                                }
                            }
                            for ($i; $i < 4; $i++)
                            {
                                $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                            }
                            echo $html;
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-ghana.jpg"><span>Ghana</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                            <?php
                            $i=0;
                            $html='';
                            foreach ($buy_links as $link)
                            {
                                if($link['country']=='ghana')
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                    $i++;
                                }
                            }
                            for ($i; $i < 4; $i++)
                            {
                                $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                            }
                            echo $html;
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-kenya.jpg"><span>Kenya</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='kenya')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-morocco.jpg"><span>Morocco</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='morocco')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-nigeria.jpg"><span>Nigeria</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='nigeria')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Area 1 -->
                <!-- Area 2 -->
                <div class="country-list" id="area-1" style="display: none;">
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-egypt.jpg"><span>Egypt</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='egypt')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-ksa.jpg"><span>Saudi Arabia</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='ksa')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-uae.jpg"><span>UAE</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='uae')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Area 2 -->
                <!-- Area 3 -->
                <div class="country-list" id="area-2" style="display: none;">
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-indonesia.jpg"><span>Indonesia</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='indonesia')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-pakistan.jpg"><span>Pakistan</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='pakistan')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-philippines.jpg"><span>Thailand</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='philippines')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-thailand.jpg"><span>Thailand</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='thailand')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-vietnam.jpg"><span>Thailand</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='vietnam')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Area 3 -->
                <!-- Area 4 -->
                <div class="country-list" id="area-3" style="display: none;">
                    <div class="row">
                        <div class="col-xs-4 col-sm-2 buy-flag"><img src="<?php echo theme_image_url() ?>/flag-france.jpg"><span>France</span></div>
                        <div class="col-xs-8 col-sm-10 buy-vendor">
                            <div class="row">
                                <?php
                                $i=0;
                                $html='';
                                foreach ($buy_links as $link)
                                {
                                    if($link['country']=='france')
                                    {
                                        $html .= '<div class="col-xs-6 col-sm-3"><a href="'.$link['url'].'"><img src="'.theme_image_url().'/btn-'.$link['seller'].'.png"></a></div>';
                                        $i++;
                                    }
                                }
                                for ($i; $i < 4; $i++)
                                {
                                    $html .= '<div class="col-xs-6 col-sm-3"><a href="#"><img src="'.theme_image_url().'/btn-buy.jpg"></a></div>';
                                }
                                echo $html;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Area 4 -->
            </div>
        </div>
    </div>
</div>
<!-- /Country modal -->
