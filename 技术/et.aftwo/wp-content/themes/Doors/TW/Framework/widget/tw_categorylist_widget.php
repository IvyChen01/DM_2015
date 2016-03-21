<?php
/**
 * Creates widget with Category List
 */

class tw_flicker extends WP_Widget
{
    function __construct() 
    {
        $widget_opt = array(
            'classname'     => 'tw_widget',
            'description'   => 'TW Post and Product Flickr'
        );
        
        $this->WP_Widget('tw-widget3', __('TW Site Flickr', 'tw'), $widget_opt);
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
        
        if(!empty($instance['number_of_item']))
        {
            $ppp = $instance['number_of_item'];
        }
        else
        {
            $ppp = 9;
        }
        
        if(!empty($instance['post_type']))
        {
            $se = $instance['post_type'];
        }
        else
        {
            $se = 'post';
        }
        
        $argu = array(
            'orderby'            => 'name',
            'order'              => 'ASC',
            'post_type'          => array($se),
            'post_status'        => array('publish'),
            'posts_per_page'     => $ppp
        );
        
        query_posts($argu);
        if(have_posts())
        {
            while (have_posts()): the_post();
            if(has_post_thumbnail())
            {
                $img = get_the_post_thumbnail(get_the_ID(), 'blob-thumb');
            }
            else
            {
                $img = '<img src="http://placehold.it/150x150" alt="'.get_the_title().'"/>';
            }
            echo '<ul class="flckr_item">';
            echo '<li><a href="'.get_permalink().'">'.$img.'</a></li>';
            echo '</ul>';
            endwhile;
        }
        else
        {
            echo '<h1>Insert Some '.$se.' First';
        }
       
        echo $args['after_widget'];
    }
    
    
    function update ( $new_instance, $old_instance ) 
    {
        $old_instance['title'] = strip_tags( $new_instance['title'] );
        $old_instance['number_of_item'] = $new_instance['number_of_item'];
        $old_instance['post_type'] = $new_instance['post_type'];

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
        if(isset($instance['number_of_item']))
        {
            $pc = $instance['number_of_item'];
        }
        else
        {
            $pc = 0;
        }
        if(isset($instance['post_type']))
        {
            $es = $instance['post_type'];
        }
        else
        {
            $es = 'post';
        }
        ?>
        <p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tw' ); ?></label>
	<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
        <p>
	<label for="<?php echo $this->get_field_id( 'number_of_item' ); ?>"><?php _e( 'Number Of Item:', 'tw' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'number_of_item' ); ?>" name="<?php echo $this->get_field_name( 'number_of_item' ); ?>" type="text" value="<?php echo esc_attr( $pc ); ?>" />
	</p>
        <p>
	<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post Type:', 'tw' ); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>">
            <option value="product" <?php if($es == 'product') { echo 'Selected';} ?> >Products</option>  
            <option value="post" <?php if($es == 'post') { echo 'Selected';} ?> >Posts</option>
        </select>
	</p>
        <?php
    }
}
register_widget( 'tw_flicker' );