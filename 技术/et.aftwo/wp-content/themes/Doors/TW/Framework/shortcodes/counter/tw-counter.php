<?php
function counter($atts, $content = null)
{
    extract(shortcode_atts(array(
        'icon'               => '',
        'title'              => 'Test Title',
        'percentange'        => '',
        'value'              => '90',
        'tcolor'             => ''
    ), $atts));
    
    $counter_return = '';
    
    $counter_return .= '<div class="counter_container">';
    $counter_return .= '<div class="counter_icon"><i class="'.$icon.'"></i></div>';
    $counter_return .= '<div class="counter_value" style="color: '.$tcolor.'"><span class="counterarea">0</span><input type="hidden" value="'.$value.'" class="counter_input"/><input type="hidden" name="p_status" value="'.$percentange.'" class="p_status"/></div>';
    $counter_return .= '<div class="counter_title" style="color: '.$tcolor.'">'.$title.'</div>';
    $counter_return .= '<div class="counter_content" style="color: '.$tcolor.'">'.$content.'</div>';
    $counter_return .= '</div>';
    return $counter_return; 
    
    
}
add_shortcode( "tw-counter", "counter" );