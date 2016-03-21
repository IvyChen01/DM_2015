<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package Doors
 * @subpackage Doors
 * @since Doors 1.0
 */
?>

		</div><!-- #main -->


	
	<footer id="footer">
		<div class="container text-center wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">
                        <?php
                            $copyRight = get_option('copyRight', FALSE); 
                            if($copyRight != '')
                            {
                                $cop = stripslashes($copyRight);
                            }
                            else
                            {
                                $cop = '&copy; 2014 <a href="#">doors theme.</a> All rights reserved.';
                            }
                        ?>
			<p><?php echo $cop; ?></p>
		</div>
		<a data-scroll href="#navigation" class="to-top"></a>
                <div class="container socialcontainer text-center wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">
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
                    <a href="<?php echo $f; ?>" class="sf"><i class="fa fa-facebook"></i></a>
                    <?php endif; if($tw != ''):?>
                    <a href="<?php echo $tw; ?>" class="st"><i class="fa fa-twitter"></i></a>
                    <?php endif; if($vk != ''): ?>
                    <a class="hidden-sm hidden-md sv" href="<?php echo $vk; ?>"><i class="fa fa-vk"></i></a>
                    <?php endif; if($lk != ''): ?>
                    <a class="hidden-sm hidden-md" href="<?php echo $lk; ?>"><i class="fa fa-linkedin"></i></a>
                    <?php endif; if($gp != ''): ?>
                    <a href="<?php echo $gp; ?>" class="sg"><i class="fa fa-google-plus"></i></a>
                    <?php endif; if($db != ''): ?>
                    <a class="hidden-sm hidden-md sd" href="<?php echo $db; ?>"><i class="fa fa-dropbox"></i></a>
                    <?php endif; if($dr != ''): ?>
                    <a class="hidden-sm hidden-md sdr" href="<?php echo $dr; ?>"><i class="fa fa-dribbble"></i></a>
                    <?php endif; if($pg != ''): ?>
                    <a class="hidden-sm hidden-md sp" href="<?php echo $pg; ?>"><i class="fa fa-pagelines"></i></a>
                    <?php endif; ?>
                    
                </div>
	</footer><!--/#footer--> 
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>