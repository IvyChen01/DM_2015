<?php
    if(isset($_POST['home_settings']) && $_POST['home_settings'] == 'Save Home Settings')
    {
        $parallax_page_list = serialize($_POST['pID']);
        update_option('parallax_page_list', $parallax_page_list);
        $url = admin_url().'themes.php?page=tw_theme_option&CPart=home_option';
        echo "<script>window.location= '".$url."'</script>";
    }
?>
<form method="post" name="general" enctype="multipart/form-data" action="">
<table class="wp-list-table widefat fixed posts" cellspacing="0">
    <tr>
        <th>
            Parallax Settings
        </th>
    </tr>
    <tr>
        <td>
            <p class="rmsnotic"><i class="up_icon fa fa-floppy-o"></i>Select Page That you want to show in <strong>Home</strong> page. Please select those with <strong>Correct Oreder</strong>. </p>
            <select id="pageSelect" name="page_select">
            <?php
                $args = array(
                    'post_type'     => array('page'),
                    'post_status'   => array('publish'),
                    'orderby'       => 'ID', 
                    'order'         => 'ASC',
                    'posts_per_page'=> 100
                );
            ?>
            <option value="">Select All</option>
            <?php
                query_posts($args);
                if(have_posts())
                {
                    while(have_posts()):the_post();
                    echo '<option value="'.get_the_ID().'">'.  get_the_title().'</option>';
                    endwhile;
                }
                else
                {
                    echo '<option value="">No Parallax Page';
                }
            ?>
            </select>
            
            <div class="clear"></div>
            <p class="rmsnotic" style="margin-top: 30px;"><i class="up_icon fa fa-floppy-o"></i>Your Selected Page. </p>
            <div class="selected_page">
                <?php 
                    echo '<ul id="pagelistul">';
                    $parallax_page_list = unserialize(get_option('parallax_page_list', FALSE)); 
                    if(is_array($parallax_page_list)):
                        
                        foreach ($parallax_page_list as $id)
                        {
                            $pageTitle = get_the_title($id);
                            echo '<li><p class="page_sereal"><span>'.$pageTitle.'</span><input type="hidden" value="'.$id.'" name="pID[]"><a class="deduct" href="#">x</a></p></li>';
                        }
                        
                    endif;
                    echo '</ul>';
                ?>
            </div>
        </td>
    </tr>
    
</table>

<div class="submit_area">
    <input type="submit" value="Save Home Settings" name="home_settings"/>
</div>
</form>


<script type="text/javascript">
    document.getElementById("file_upload").onchange = function () {
    document.getElementById("upfile").value = this.value;
};
</script>