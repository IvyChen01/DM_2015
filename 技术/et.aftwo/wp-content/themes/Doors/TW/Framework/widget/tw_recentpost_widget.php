<?php
/**
 * Creates widget with recent post thumbnail
 */

class xs_recent_post extends WP_Widget
{
    function __construct() 
    {
        $widget_opt = array(
            'classname'     => 'rms_widget',
            'description'   => 'TW Recent Post With Thumbnail'
        );
        
        $this->WP_Widget('rms-widget1', __('TW Recent Post', 'rms'), $widget_opt);
    }
    
    function widget( $args, $instance )
    {
        global $wp_query;
        
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        
        if(!empty($instance['number_of_posts1']))
        {
            $ppp = $instance['number_of_posts1'];
        }
        else
        {
            $ppp = 5;
        }
        
        $query = array(
            'post_type'         => array('post'),
            'post_status'       => array('publish'),
            'orderby'           => 'date',
            'order'             => 'DESC',
            'posts_per_page'    => $ppp
        );
        
        query_posts($query);
        if(have_posts())
        {
            echo '<div class="recent_post_holder">';
            while(have_posts()): the_post();
        ?>
            
            <div class="rms_rec_post">
                <div class="media">
                    <div class="pull-left widgetthumb">
                        <a href="<?php echo get_the_permalink(); ?>">
                            <?php if(has_post_thumbnail()): ?>
                                <?php echo get_the_post_thumbnail(get_the_ID(), 'square-xsmall'); ?>
                            <?php else: ?>
                            <img src="http://placehold.it/50x50" alt="<?php echo get_the_title(); ?>"/>
                            <?php endif;?>
                        </a>
                    </div>
                    <div class="media-body">
                        <h4><a href="<?php echo get_the_permalink(); ?>"><?php echo substr(get_the_title(), 0, 22); ?></a></h4>
                        <p>Posted on <?php echo date("d F Y", strtotime(get_the_date())); ?></p>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
            
        <?php
            endwhile;
            echo '<div class="clear"></div>
                </div>';
        }
        else
        {
            echo '<div class="recent_post_holder">';
            echo '<div class="rms_rec_post">';
            echo '<h1 class="null_message">No Post Available</h1>';
            echo '</div>';
            echo '<div class="clear"></div>
                    </div>';
        }
        
        echo $args['after_widget'];
    }
    
    
    function update ( $new_instance, $old_instance ) 
    {
        $old_instance['title'] = strip_tags( $new_instance['title'] );
        $old_instance['number_of_posts1'] = $new_instance['number_of_posts1'];

        return $old_instance;
    }
    
    function form($instance)
    {
        if(isset($instance['title']))
        {
            $title = $instance['title'];
        }
        else
        {
            $title = __( 'New title', 'wpb_widget_domain' );
        }
        if(isset($instance['number_of_posts1']))
        {
            $np = $instance['number_of_posts1'];
        }
        else
        {
            $np = 0;
        }
        ?>
        <p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'rms' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
        <p>
	<label for="<?php echo $this->get_field_id( 'number_of_posts1' ); ?>"><?php _e( 'Number Of Posts:' , 'rms' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'number_of_posts1' ); ?>" name="<?php echo $this->get_field_name( 'number_of_posts1' ); ?>" type="text" value="<?php echo esc_attr( $np ); ?>" />
	</p>
        <?php
    }
}
register_widget( 'xs_recent_post' );