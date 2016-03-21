<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );


$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

$mailto = get_option("quickEmail", false);
$mailto1 = get_option("admin_email", false);

if($mailto != '')
{
    $to = $mailto;
}
else
{
    $to = $mailto1;
}

$blogname = get_option("blogname", false);
$subject = "Mail From ".$blogname. "Contact Form";


$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <'.$email.'>' . "\r\n";

mail($to,$subject,$message,$headers);
echo 1;