<?php
/**
 * Template part for displaying single posts.
 *
 * @package Infinix
 */

global $post;
?>

<?php
    $kv = get_post_meta( $post->ID, '_acc_kv', true );
    $background = !empty($kv['color']) ? 'background-color:'.$kv['color'].';' : '';
    $background .= !empty($kv['bg']) ? 'background-image:url('.$kv['bg'].');' : '';
?>
<section class="acc-banner" style="<?php echo $background?>">
    <div class="container">
        <div class="row">
            <?php echo $kv['detail']?>
        </div>
    </div>
</section>

<article>

    <?php /*<div class="sp-anchor">
        <nav class="navbar sp-anchor-inner">
            <div class="container">
                <div class="navbar-header">
                    <div class="navbar-brand">
                        <img src="<?php echo theme_image_url() ?>/nav-hot-series.jpg">
                        <a href="#" class="nav-top"><span class="glyphicon glyphicon-arrow-up"></span> Back to Top</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>*/ ?>

    <?php
    $sp = get_post_meta( $post->ID, '_acc_sp', true );
    $sp_html = '';
    for ($i=0,$j=count($sp); $i < $j; $i++)
    {
        $sp_html .= '<section class="acc-section';
        $sp_html .= isset($sp[$i]['text-center']) ? ' x-text-center' : '';
        $sp_html .= isset($sp[$i]['text-light']) ? ' x-text-light' : '';
        $sp_html .= '" id="sp'.($i+1).'" style="';
        $sp_html .= !empty($sp[$i]['color']) ? 'background-color:'.$sp[$i]['color'].';' : '';
        $sp_html .= !empty($sp[$i]['bg']) ? 'background-image:url('.$sp[$i]['bg'].');' : '';
        $sp_html .= '">';
            $sp_html .= '<div class="container">';
                $sp_html .= '<div class="row">';
                    $sp_html .= $sp[$i]['content'];
                $sp_html .= '</div>';
            $sp_html .= '</div>';
        $sp_html .= '</section>';
    }
    echo $sp_html;
    ?>

</article>
