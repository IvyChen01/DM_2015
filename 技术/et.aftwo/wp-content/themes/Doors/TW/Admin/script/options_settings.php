<?php
/**
 * XpeedStudio WordPress Framework
 *
 * Copyright (c) 2014,  XpeedStudio, s.r.o. (http://XpeedStudio.com)
 */
require TW_ADMIN_DIR.'/design/optionHeader.php';

if(isset($_GET['CPart']))
{
    $cpart = $_GET['CPart'];
    switch ($cpart)
    {
        case "h_option" :
            require TW_ADMIN_DIR.'/design/header_option.php';
            break;
        case "f_option" :
            require TW_ADMIN_DIR.'/design/footer_option.php';
            break;
        case  "b_option":
            require TW_ADMIN_DIR.'/design/blog_option.php';
            break;
        case "home_option":
            require TW_ADMIN_DIR.'/design/home_option.php';
            break;
        case "import_option":
            require TW_ADMIN_DIR.'/design/import_option.php';
            break;
        case "css_option":
            require TW_ADMIN_DIR.'/design/css_option.php';
            break;
    }
}
else
{
    require_once TW_ADMIN_DIR.'/design/general.php';
}

require TW_ADMIN_DIR.'/design/optionFooter.php';