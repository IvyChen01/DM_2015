<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */

get_header(); ?>


    <section id="error-page">
        <div class="error-page-inner">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="text-center">                           
                            <h1>404 Error</h1>
                            <h2>Page Not Found</h2>
                            <p>The page you are looking for might have been removed, had its name changed.</p>
                            <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">Back To Home</a>
                            <div class="social-link">
                                 <?php
                                    $f = get_option('facebook', false);
                                    $gp = get_option('googlePlus', false);
                                    $vk = get_option('vk', false);
                                    $db = get_option('dropbox', false);
                                    $lk = get_option('linkedin', false);
                                    $tw = get_option('twitter', false);
                                    $pg = get_option('pagelines', false);
                                    $dr = get_option('dribbble', false);
                                    if($f != ''):
                                ?>
                                <span><a href="<?php echo $f; ?>" class="sf"><i class="fa fa-facebook"></i></a></span>
                                <?php endif; if($tw != ''):?>
                                <span><a href="<?php echo $tw; ?>" class="st"><i class="fa fa-twitter"></i></a></span>
                                <?php endif; if($vk != ''): ?>
                                <span><a class="hidden-sm hidden-md sv" href="<?php echo $vk; ?>"><i class="fa fa-vk"></i></a></span>
                                <?php endif; if($lk != ''): ?>
                                <span><a class="hidden-sm hidden-md" href="<?php echo $lk; ?>"><i class="fa fa-linkedin"></i></a></span>
                                <?php endif; if($gp != ''): ?>
                                <span><a href="<?php echo $gp; ?>" class="sg"><i class="fa fa-google-plus"></i></a></span>
                                <?php endif; if($db != ''): ?>
                                <span><a class="hidden-sm hidden-md sd" href="<?php echo $db; ?>"><i class="fa fa-dropbox"></i></a></span>
                                <?php endif; if($dr != ''): ?>
                                <span><a class="hidden-sm hidden-md sdr" href="<?php echo $dr; ?>"><i class="fa fa-dribbble"></i></a></span>
                                <?php endif; if($pg != ''): ?>
                                <span><a class="hidden-sm hidden-md sp" href="<?php echo $pg; ?>"><i class="fa fa-pagelines"></i></a></span>
                                <?php endif; ?>
                            </div>
                            
                        </div>
                        <div class="search404 col-sm-4 col-sm-offset-4 col-xs-12">
                            <?php 
                                echo get_search_form();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<style type="text/css">
    #footer, #home{
        display: none;
    }
</style>
<?php
get_footer();
