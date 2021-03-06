<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>How Much Do You Know About Infinix</title>
    <link rel="stylesheet" href="css/main.css?v=2015.1.5_15.01" media="screen" title="no title" charset="utf-8">
  </head>
  <body class="">
    <!--pc-->
      <!--main-->
      <section class="main show-wrapper wrapper">
        <span class="main-title">How Much Do You Know About Infinix?</span>
        <span class="quotes"><p><i class="quo">Q1:&nbsp;</i>What is the slogan of Infinix?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.The future is now.</li>
          <li>B.The future is coming.</li>
          <li>C.Born to change</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q2:&nbsp;</i>Which is the first Infinix phone launched online?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.ZERO </li>
          <li>B.Hot</li>
          <li>C.Hot Note</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q3:&nbsp;</i>Which is the first Infinix phone to use the Kevlar as the back cover?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.ZERO </li>
          <li>B.ZERO 2</li>
          <li>C.HOT 2</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q4:&nbsp;</i>Currently, which phone’s screen is the biggest among Infinix phones?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.ZERO </li>
          <li>B.NOTE 2</li>
          <li>C.HOT 2</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q5:&nbsp;</i>What is the screen size of Infinix HOT NOTE?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.4.5 inches screen</li>
          <li>B.5 inches IPS screen</li>
          <li>C.5.5 inches HD screen</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q6:&nbsp;</i>Which is the first Infinix phone to use the fast charge technology?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.ZERO 2</li>
          <li>B.HOT NOTE</li>
          <li>C.HOT 2</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q7:&nbsp;</i>Which Infinix phone’s operating system is Android one?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.HOT</li>
          <li>B.HOT 2</li>
          <li>C.ZERO 2</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q8:&nbsp;</i>What is the name of Infinix Forum?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.Xbbs</li>
          <li>B.Xforum</li>
          <li>C.Xclub</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q9:&nbsp;</i>How long is the Infinix warranty?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.6 months</li>
          <li>B.300 days</li>
          <li>C.12 months</li>
        </ul></span>

        <span class="quotes"><p><i class="quo">Q10:&nbsp;</i>Which brand provides after-sales service to Infinix?</p><ul>
          <span class="aa">&nbsp;</span>
          <li>A.Infinix Care</li>
          <li>B.Xcare</li>
          <li>C.Carlcare</li>
        </ul></span>

        <span class="submit">Submit</span>
      </section>

      <!--thanks-->
      <section class="thx item-wrapper wrapper">
        <div class="thx-wrapper">
        <div class="thx-title"><p class="thx-he">Thank you</p><p class="thx-re">for participating in the competition</p></div>
        <div class="thx-img hide-md"><img src="images/thx.jpg" alt="" /></div>
        <div class="share"><p>Share it on you Facebook with hashtag</br>
#HowMuchDoYouKnowAboutInfinix and</br>
stand a chance to win tickets to #InfinixerFestival.
</p>
<a href="javascript:;" class="shfb">Share To Facebook</a>
</div>  </div>
      </section>
    <!--end pc-->
	
	<input type="hidden" id="isFb" value="<?php if (Config::$isFb) { echo 1; } else { echo 0; } ?>" />
	<input type="hidden" id="appId" value="<?php echo Config::$fbAppId; ?>" />
	<input type="hidden" id="shareUrl" value="<?php echo Config::$shareUrl; ?>" />
	<input type="hidden" id="sharePic" value="<?php echo Config::$sharePic; ?>" />
	<input type="hidden" id="isPlayed" value="<?php if ($isPlayed) { echo 1; } else { echo 0; } ?>" />

    <script src="js/jquery-1.11.2.min.js" charset="utf-8"></script>
    <script src="js/main.js?v=2015.12.31_14.18" charset="utf-8"></script>
  </body>
</html>
