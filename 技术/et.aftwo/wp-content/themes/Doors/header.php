<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
    <!--<![endif]-->
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
        <![endif]-->
        <?php
        $lat = get_option('glatitude', FALSE);
        $lon = get_option('glongitude', FALSE);
        ?>
        <script type="text/javascript">
            var home_url = '<?php echo home_url(); ?>';
            var glatitude = '<?php echo $lat; ?>';
            var glongitude = '<?php echo $lon; ?>';
            var prloadorimg = '<?php echo get_template_directory_uri(); ?>';
        </script>

        <?php
        $furl = get_option('favicon_url', FALSE);
        if ($furl != '') {
            $fu = $furl;
        } else {
            $fu = get_template_directory_uri() . '/TW/Assets/images/ico/favicon.png';
        }
        ?>  
        <link rel="shortcut icon" href="<?php echo $fu; ?>"/>
<?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>  data-spy="scroll" data-target="#main-navbar">
        <!-- Page Loader -->
        <div class="loader">
            <div class="loaded">&nbsp;</div>
        </div>

        <div id="page" class="hfeed site">
            <div id="home">
                <header id="navigation">
                    <?php
                    $bgclass = '';
                    if (!is_front_page() || is_home()) {
                        $bgclass = 'blognav';
                    }
                    ?>
                    <div class="navbar main-nav <?php echo $bgclass; ?>" role="banner" id="main-navbar">
                        <div class="container">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <?php
                                $logo = get_option('logo_url', FALSE);
                                $logotext = get_option('logo_text', FALSE);
                                if ($logo != '') {
                                    $lo = $logo;
                                } else {
                                    $lo = get_template_directory_uri() . '/TW/Assets/images/logo.png';
                                }
                                if ($logotext != '') {
                                    $lt = $logotext;
                                } else {
                                    $lt = '';
                                }
                                ?>
                                <a class="navbar-brand" href="<?php echo home_url('/'); ?>">
                                    <h1><img class="img-responsive" src="<?php echo $lo; ?>" alt="<?php bloginfo('name'); ?>"></h1>
                                    <h2><?php echo $lt; ?></h2>
                                </a>                    
                            </div>	
                            <div class="top-bar">
                                <?php if (get_option('quickEmail', FALSE) != ''): ?><span><a href="mailto:<?php echo get_option('quickEmail', FALSE); ?>" target="_top"><i class="fa fa-envelope"></i> <?php echo get_option('quickEmail', FALSE); ?></a></span> <?php endif; ?>
                                <?php if (get_option('quickPhone', FALSE) != ''): ?><span><i class="fa fa-phone"></i> <?php echo get_option('quickPhone', FALSE); ?></span><?php endif; ?>
 <span><?php do_action('icl_language_selector'); ?></span>
                            </div>
                            <nav class="collapse navbar-collapse navbar-right">
                                <?php
                                if (has_nav_menu('primary-menu')) {
                                    wp_nav_menu(array(
                                        'theme_location' => 'primary-menu',
                                        'container' => FALSE,
                                        'menu_class' => 'nav navbar-nav',
                                        'menu_id' => 'main_menu',
                                        'echo' => true,
                                        'walker' => new Menu_Walker(),
                                        'depth' => 0
                                    ));
                                } else {
                                    echo '<ul class="nav navbar-nav">';
                                    echo '<li>' . _e('There is no Main Menu.', 'doors') . '</li>';
                                    echo '</ul>';
                                }
                                ?>
                            </nav>
                            <div class="searcha">
                                <form role="search" method="get" id="searchform" action="<?php echo home_url('/'); ?>">
                                    <i class="fa fa-search"></i>
                                    <div class="field-toggle">
                                        <input autocomplete="off" type="text" class="search-form" value="Search" name="s" id="s" onfocus="if (this.value == 'Search') {
                                        this.value = '';
                                    }" onblur="if (this.value == '')
                                                this.value = 'Search';" />
                                        <input type="hidden" class="post_type" name="post_type" value="post" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </header><!--/#navigation-->
                <?php
                $slider = get_option('sliderShortcode', FALSE);
                if ($slider != '') {
                    $sli = stripslashes($slider);
                } else {
                    $sli = '[doors-carousel category="" item="3" features="1"]';
                }

                if (is_front_page() && !is_home()) {
                    echo do_shortcode($sli);
                }
                ?>
            </div>
            <div id="main" class="site-main">
