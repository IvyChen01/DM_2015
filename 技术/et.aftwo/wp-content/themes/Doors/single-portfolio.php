<?php
/**
 * The Template for displaying all single posts
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */
get_header();
?>
<section id="blog-details">
    <div class="container">
        <div class="row blog-item">
            <div class="row blog-item portfolio-single">
                <div class="col-md-8 col-sm-7 blog-content">
                    <?php
                    // Start the Loop.
                    while (have_posts()) : the_post();
                        ?>

                        <article id = "post-<?php the_ID(); ?>" <?php post_class();
                        ?>>
                            <div class="entry-header">


                                <?php
                                if (has_post_thumbnail()) {
                                    ?>

                                    <?php
                                    echo get_the_post_thumbnail(get_the_ID(), 'portfolio-large', array('class' => 'img-responsive'));
                                }
                                ?>
                               
                                <br />
                            </div>	
                            <div class="entry-post">
                                <?php the_content(); ?>
                            </div>


                            <div class="wp_page_links">
                                <?php
                                wp_link_pages(array(
                                    'before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'Xs') . '</span>',
                                    'after' => '</div>',
                                    'link_before' => '<span>',
                                    'link_after' => '</span>',
                                ));
                                ?>
                            </div>
                        </article><!-- #post-## -->

                        
                    </div><!-- #content -->
                    <div class="col-md-4 col-sm-5">
                        <div class="sidebar doorssidebar">
                            <?php
                            $aboutPortfolio = get_post_meta(get_the_ID(), 'aboutPortfolio', true);
                            if ($aboutPortfolio) {
                                ?>
                                <div class="portfolio-details">
                                    <header class="portfolio-sidebar-title">
                                        <h2><?php echo get_the_title(); ?></h2>
                                    </header>
                                    <p>
                                        <?php echo $aboutPortfolio; ?>
                                    </p>
                                </div>  
                            <?php } ?>

                            <div class="project-details">
                                <header class="portfolio-sidebar-title">
                                    <h4>Portfolio Details</h4>
                                </header>
                                <?php
                                $portfolio_clients = get_post_meta(get_the_ID(), 'portfolioClients', true);
                                $portfolio_date = get_post_meta(get_the_ID(), 'releaseDate', true);
                                $portfolio_link = get_post_meta(get_the_ID(), 'liveLink', true);
                                $portfolio_categories = wp_get_post_terms(get_the_ID(), 'portfolio');
                                ?>

                                <ul class="unstyled">

                                    <?php if ($portfolio_clients) { ?>
                                        <li><i class="fa fa-user"></i><strong>Client</strong>: <?php echo $portfolio_clients; ?></li>
                                    <?php }
                                    if ($portfolio_date) {
                                        ?>

                                        <li><i class="fa fa-clock-o"></i><strong>Date</strong>: <?php echo $portfolio_date; ?></li>

                                    <?php
                                    }
                                    if (is_array($portfolio_categories) && count($portfolio_categories)) {

                                        $portfolio_categories_array = array();
                                        foreach ($portfolio_categories as $portfolio_category) {
                                            $portfolio_categories_array[] = $portfolio_category->name;
                                        }
                                        ?>
                                        <li><i class="fa fa-folder"></i><strong>Category</strong>: <?php echo implode(', ', $portfolio_categories_array); ?></li>

                                <?php } ?>
                                </ul>
                                <?php if ($portfolio_link) { ?>
                                    <a href="<?php echo $portfolio_link; ?>" class="btn btn-primary" target="_blank">See Live Project</a>
                            <?php } ?>
                            </div> 
                            <?php endwhile; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php
get_footer();
