<?php if (!defined('VIEW')) exit; ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>introduction</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="css/layst.css" media="screen" title="no title" charset="utf-8">
    <script src="js/jquery.js" charset="utf-8"></script>
    <script src="js/wish.js" charset="utf-8"></script>
  </head>
  <body>
    <script type="text/javascript">
    jQuery.fn.center=function(){
    this.css('position','absolute');
    this.css('top',($(window).height()-this.height())/2 +$(window).scrollTop()+40+'px');
    this.css('left',($(window).width()-this.width())/2+$(window).scrollLeft()+'px');
    return this;
}
    $(function(){  $('.ido-content').center()})
//    $('*').css({overflow-x:"hidden"});
    $('.ido-cor').css('overflow-y','scroll');
    $('.ido-cor p').css('overflow-y','scroll');
    </script>
    <script type="text/javascript">
      $(function(){
        $('.ido-rule').click(function(){
          $('.ido-content').hide();
          $('.intrdto').css('background','#333')
          $('.ido-cover').fadeIn('slow');
        })
        $('.ido-close').click(function(){
          $('.intrdto').hide();
          location.href="?m=wish&a=introuction&d=mobile";
        })
      })
    </script>
    <div class="intrdto">
      <div class="ido-content">
        <i class="balloonrt"></i>
        <i class="balloonlf after"></i>
          <div class="ido-container">
            <p class="ido-title sy">Infinix Wish</p>
            <p class="ido-text">Make a Wish on Infinix Wish Wall</P>
            <p class="ido-text">Make it Come Ture with Infinix</P>
            <a class="ido-rule">
              <!--<i class="ido-ruleyt"></i>-->
              <i class="ido-rulecot">I agree to the terms.</i></a>
            <a class="ido-enter sy ft10" href="<?php echo $loginUrl; ?>">ENTER</a>
          </div>
      </div>
      <div class="ido-cover">
        <div class="ido-cor">
            <i class="ido-close"></i>
            <i style="font-size:14px;line-height:14px;font-weight:bold;">Terms and Conditions</i></br>
This Terms and Conditions (“Terms and Conditions”) describes the information collected by Infinix Wish Wall. (“we,” “us,” or “our”), how that information may be used, with whom it may be shared, and your choices about such uses and disclosures. By using our website, located at <a href="http://www.infinixmobility.com">http://www.infinixmobility.com</a> (“Website”), you are accepting the practices set forth in this Privacy Policy. If you do not agree with this policy, then you must not access or use Infinix Wish Wall.</br>
<i style="font-size:14px;line-height:14px;font-weight:bold;">Information we collect and how we collect it:</i></br>
<i style="font-size:14px;line-height:14px;font-weight:bold;">Information collected automatically:</i> When you use Infinix Wish Wall, we automatically collect and store certain information about your computer or mobile device and your activities. This information includes:</br>
1. Facebook ID and Facebook profile. Your Facebook's ID and personal profile.</br>
2. Email Address. Your email address to log in Facebook.</br>
3. Cookies: We use “cookies” to keep track of some types of information while you are visiting Infinix Wish Wall. “Cookies” are very small files placed on your computer, and they allow us to count the number of visitors to our Website and distinguish repeat visitors from new visitors. They also allow us to save user preferences and track user trends. We rely on cookies for the proper operation of Infinix Wish Wall; therefore if your browser is set to reject all cookies, Infinix Wish Wall may not function properly. Users who refuse cookies assume all responsibility for any resulting loss of functionality with respect to Infinix Wish Wall.</br>
<i style="font-size:14px;line-height:14px;font-weight:bold;">Information you choose to provide:</i>
Information We Obtain from Facebook. In order to register with Infinix Wish Wall, you will be asked to sign in using your Facebook login. If you do so, you are authorizing us to access certain Facebook account information, including information about you and your Facebook friends who might be common Facebook friends with other Infinix Wish Wall users. By allowing us to access your Facebook account, you understand that we may obtain certain information from your Facebook account, including your name, email address, birthday, work history, education history, current city, pictures stored on Facebook, and the names, profile pictures, relationship status, and current cities of your Facebook friends. We only obtain information from your Facebook account that you specifically authorize and grant us permission to obtain.</br>
<i style="font-size:14px;line-height:14px;font-weight:bold;">How we use the information</i></br>
Pursuant to the terms of this Privacy Policy, we may use the information we collect from you for the following purposes:</br>
1. respond to your actions on Infinix Wish Wall;</br>
2. monitor and analyze trends, usage and activities;</br>
3. investigate and prevent fraud and other illegal activities; and</br>
<i style="font-size:14px;line-height:14px;font-weight:bold;">Sharing Your Information</i></br>
The information we collect is used to collect the content generated on Infinix Wish Wall, and without your consent we will not otherwise share your personal information to/with any other party(s) for commercial purposes, except: (a) to provide Infinix Wish Wall, (b) when we have your permission, or (c) or under the following instances:</br>
Service Providers. We may share your information with our third-party service providers that support various aspects of our business operations (e.g., analytics providers, security and technology providers, and payment processors).</br>
Legal Disclosures and Business Transfers. We may disclose any information without notice or consent from you: (a) in response to a legal request, such as a subpoena, court order, or government demand; (b) to investigate or report illegal activity; or (c) to enforce our rights or defend claims. We may also transfer your information to another company in connection with a merger, corporate restructuring, sale of any or all of our assets, or in the event of bankruptcy.</br>
Sharing Your Facebook Information. Your Facebook friends’ names and one profile picture can be shared with your wish matches who are already friends with these Facebook friends.</br>
<i style="font-size:14px;line-height:14px;font-weight:bold;">Securing Your Personal Information</i>
We endeavor to safeguard personal information to ensure that information is kept private. However, please be aware that unauthorized entry or use, hardware or software failure, the inherent insecurity of the Internet and other factors, may compromise the security of your personal information at any time. As such, we cannot guarantee the security of your personal information.</br>
<i style="font-size:14px;line-height:14px;font-weight:bold;">How to contact us</i></br>
If you have any questions about this Privacy Policy, please contact us by email at<a href="dm@infinixmobility.com"> dm@infinixmobility.com. </a>

        </div>
      </div>
    </div>
  </body>
</html>
