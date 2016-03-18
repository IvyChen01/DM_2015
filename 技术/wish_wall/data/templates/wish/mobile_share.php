<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>make a wish</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="css/layst.css" media="screen" title="no title" charset="utf-8">
    <script src="js/jquery.js" charset="utf-8"></script>
    <script src="js/wish.js" charset="utf-8"></script>
  </head>
  <body>
    <div class="shad">
      <div class="shaddo">
        <img src="<?php echo $wishData['photo']; ?>" width="100px" height="100px" alt="" />
        <i class="shname"><?php echo $wishData['username']; ?></i>
        <i class="shtime"><?php echo $wishData['pubdate']; ?></i>
        <i class="shsoli"><?php echo $wishData['content']; ?></i>
        <a class="shad-share sy ft12" href="./" target="_self">Make a wish.</a>
      </div>
    </div>
  </body>
</html>
