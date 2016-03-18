<?php if (!defined('VIEW')) exit; ?>
﻿<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Survey </title>
    <link rel="stylesheet" href="css/rest.css?v=2016.1.22_10.29" media="screen" title="no title" charset="utf-8">
  </head>
  <body>
    <span class="process-tele process whide">

    </span>
    <div class="main-wrapper">
        <div class="process-wrapper whide">
          <span class="title show">Survey.</span>
          <span class="process-table process">
            <ul><li class="sur"></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li></ul>
          </span>
        </div>

        <div class="wercty">
			<section class="wer wer0 wer17 wshow wrapper">
            <p class="werp0"><a href="javascript:;" class="cover1"></a></p>
            <p class="survey">Survey</p>
            <p class="surtitle">What Do You Think of the Service of TECNO?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            <p><span class="surspan"><a href="javascript:;" class="only">Only 1 min</a><a href="javascript:;" class="let">Let us know what you need</a></span></p>
            <p class="cover2p"><a href="javascript:;" class="cover2"></a></p>
            <p class="sert"><a href="javascript:void(0);" target="_self" class="startbtn" >Start >></a></p>
          </section>
		  
          <section class="wer wer1 wer17 whide wrapper">
            <h3>What Do You Think of the Service of TECNO?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
            <h4>Dear Consumer,</h4>
            <p>
              Thank you in advance for taking the time to complete the survey to help us<br />
			  to improve the service for you.
            </p>
            <p>
			  It will take you approximately one minute to answer all questions. We promise<br />
			  we will not disclose your personal information to any third party.
            </p>
            <p>
			  With many thanks, you will have a chance to win a special gift from TECNO<br />
			  after completing the survey.
			</p>
            <p>Thank you!</p>
            <p class="wer1start next">
              Start >>
            </p>
          </section>

          <section class="wer wer2 whide wrapper">
            <h2 class="que">Your Sex?</h2>
            <ul>
              <li class="quo squ">Male</li>
			  <li class="squ">Female</li>
            </ul>
          </section>
		  
		  <section class="wer wer3 whide wrapper">
            <h2 class="que">Your Age?</h2>
            <ul>
              <li class="quo squ">12-20</li>
			  <li class="squ">21-35</li>
			  <li class="squ">35-50</li>
			  <li class="squ">above 50</li>
            </ul>
          </section>
		  
		  <section class="wer wer4 whide wrapper">
            <h2 class="que">How can you know about TECNO? (Multiple Choice)</h2>
            <ul>
              <li id="chk1">Through Internet</li>
			  <li id="chk2">Through advertisement</li>
			  <li id="chk3">Through Friends and Families</li>
			  <li id="chk4">Others(Please specify:<i class="eb"><input type="text" placeholder='_______________________________' name="name" value=""></i>)</li>
            </ul>
          </section>
		  
		  <section class="wer wer5 whide wrapper">
            <h2 class="que">Do you know TECNO can provide 12+1 months warranty?</h2>
            <ul>
              <li class="quo squ">Yes, I know</li>
			  <li class="squ">No, I’v never heard of it</li>
            </ul>
          </section>
		  
		  <section class="wer wer6 whide wrapper">
            <h2 class="que">You think the service of TECNO Show Room in Juba is?</h2>
            <ul>
              <li class="quo squ">Very Satisfied</li>
			  <li class="squ">Good</li>
			  <li class="squ">Just So So</li>
			  <li class="squ">Very Bad</li>
            </ul>
          </section>
		  
		  <section class="wer wer7 whide wrapper">
            <h2 class="que">Do you know if you buy TECNO phones, you can get a free MTN SIM card with free 50 minutes telephone charge and 50MB free data?</h2>
            <ul>
              <li class="quo squ">Yes, I know</li>
			  <li class="squ">No, I’v never heard of it</li>
            </ul>
          </section>
		  
		  <section class="wer wer8 whide wrapper">
            <h2 class="que">If you can choose the free SIM card when you buy TECNO phones, which one do you want?</h2>
            <ul>
			  <li class="quo squ">MTN</li>
			  <li class="squ">VIVACELL</li>
			  <li class="squ">ZAIN</li>
			  <li class="squ">GEMTELL</li>
            </ul>
          </section>
		  
		  <section class="wer wer9 whide wrapper">
            <h2 class="que">Why do you want that SIM Card?</h2>
            <ul>
              <li>My answer:<i class="eb"><input type="text" id="simTxt" placeholder='_______________________________' name="name" value=""></i></li>
            </ul>
          </section>
		  
		  <section class="wer wer10 whide wrapper">
            <h2 class="que">Do you have some suggestions to TECNO in South Sudan?</h2>
            <ul>
              <li>My answer:<i class="eb"><input type="text" id="suggestionTxt" placeholder='_______________________________' name="name" value=""></i></li>
            </ul>
          </section>
		  
          <section class="wer wer11 whide wrapper">
            <h2 class="que">Thank you!</h2>
            <ul>
              <li class="sqh">Thank you for completing the survey.
Your lucky draw number is <b><?php echo $luckyCode; ?></b>. The winners will be announced in February, 2016.</li>
              <li>Please leave your email address here <i class="eb"><?php if ($isEmail) { ?><span><?php echo $profile['email2']; ?></span><input /><?php } else { ?><input type="text" id="address" placeholder='_______________________________' name="name" value=""><?php } ?></i></li>
              <li class="sqh">if you win, we will inform you.</li>
            </ul>
            <span class="lev">
              <a href="javascript:;" class="lebtn"></a>
              <a href="javascript:;" class="levbtn">Submit >>.</a>
            </span>
          </section>
        </div>

        <div class="lift whide">
          <a href="javascript:;" class="li"><< Previous</a>
          <a href="javascript:;" class="ft">Next >></a>
        </div>
    </div>
	
	<input type="hidden" id="isPlayed" value="<?php if ($isPlayed) { echo 1; } else { echo 0; } ?>" />
	<input type="hidden" id="isEmail" value="<?php if ($isEmail) { echo 1; } else { echo 0; } ?>" />
	
  <script src="js/jquery-1.11.2.min.js" charset="utf-8"></script>
  <script src="js/main.js?v=2016.1.22_10.30" charset="utf-8"></script>
  </body>
</html>
