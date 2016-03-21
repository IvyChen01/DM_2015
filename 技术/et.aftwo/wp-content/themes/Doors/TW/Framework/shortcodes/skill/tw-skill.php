<?php

/* * *********************************************************
 * jQuery Skill
 * ********************************************************* */

function tw_skills($params, $content = null) {
    extract(shortcode_atts(array(
        'id' => rand(100, 1000),
        'title' => rand(100, 1000)
                    ), $params));

    $scontent = do_shortcode($content);
    if (trim($scontent) != "") {
        $output = '<div class="container"><div class="skills-section">
                        <h2 class="text-center heading text-capitalize">' . $title . '</h2>
                    <div class="row">' . $scontent;
        $output .= '</div></div></div>';


        return $output;
    } else {
        return "";
    }
}

add_shortcode('tw-skills', 'tw_skills');

function tw_skill($params, $content = null) {
    extract(shortcode_atts(array(
        'id'          => '',
        'parcentange' => ''
                    ), $params));
    
    $presetcolor = get_option('presetcolor', FALSE);
    if($presetcolor != '')
    {
        $color = $presetcolor;
    }
    else
    {
        $color = 'red';
    }
    $bgc = '';
    $trc = '';
    switch ($color)
    {
        case 'black':
            $bgc = "#000000";
            $trc = "#666666";
            break;
        case 'blue':
            $bgc = '#0072BC';
            $trc = '#58bcfd';
            break;
        case 'grap':
            $bgc = '#90185B';
            $trc = '#fc5cb5';
            break;
        case 'green':
            $bgc = '#8EC63F';
            $trc = '#d3fc9a';
            break;
        case 'red':
            $bgc = '#d9232d';
            $trc = '#8f232d';
            break;
        default :
            $bgc = '#d9232d';
            $trc = '#8f232d';
            break;
    }
    
    
    return '<div class="col-sm-3 col-xs-6 skill wow zoomIn" data-wow-duration="700ms" data-wow-delay="300ms">
                    <div class="skill-circle" id="'.$id.'" data-bgcolor="'.$bgc.'" data-trackcolor="'.$trc.'" data-percent="'.$parcentange.'"><span class="skill-data">'.$parcentange.'%</span></div>
                    <h2 class="">'.$content.'</h2>
            </div>';
}

add_shortcode('tw-skill', 'tw_skill');
