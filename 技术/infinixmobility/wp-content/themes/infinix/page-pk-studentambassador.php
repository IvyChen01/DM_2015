<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Infinix
 */

get_header(); ?>

<section class="uap-head">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1>Infinix University<br>Ambassador Program</h1>
            </div>
        </div>
        <div class="uap-btns">
            <a class="uap-btn-download" href="https://www.dropbox.com/s/rvi3oeqp7e5iw47/Form.xlsx?dl=0&s=sl"><span></span> Download The Form</a>
            <?php /*<a class="uap-btn-sendmail" href="mailto:hello@infinixmobility.com?subject=Student Ambassador"><span></span> Send us your Form</a> */?>
        </div>
    </div>
</section>

<section class="uap-content">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-9">

                <h2>Join us and become part of our global corporate family</h2>
                <p>Infinix Pakistan offers you an experience of a lifetime! Join us to learn norms of the professional world with an international perspective.Operating in more than 20 different countries, Infinix offers you to learn the all about marketing &amp; sales before graduation that will help you apply your university business concepts in practical life.</p>
                <p>— Join us and become part of our global corporate family.</p>
                <h2>Application Process</h2>
                <div class="uap-process">
                    <img src="/wp-content/uploads/images/uap-process.jpg">
                    <div class="uap-btns">
                        <a class="uap-btn-download" href="https://www.dropbox.com/s/rvi3oeqp7e5iw47/Form.xlsx?dl=0&s=sl"><span></span> Download The Form</a>
                        <?php /*<a class="uap-btn-sendmail" href="mailto:hello@infinixmobility.com?subject=Student Ambassador"><span></span> Send us your Form</a> */ ?>
                    </div>
                </div>

                <h2>Task/Responsibility</h2>
                <dl>
                    <dt>General Tasks</dt>
                    <dd>— Represent Infinix at your university</dd>
                    <dd>— Ensure the marketing plan is implemented in the university</dd>
                    <dd>— Responsible for engaging university students on <a href="http://bbs.infinixmobility.com/">Xclub PK forum</a> &amp; <a href="https://www.facebook.com/XClubPakistan">Facebook page</a></dd>
                    <dd>— Infuse Infinix into the student lifestyle through co-ordination of projects on university campuses and support of student events</dd>
                    <dd>— Maintain relationships and support of key university bodies and individuals</dd>
                    <dd>— Spots trends and the opinion leaders on campus</dd>
                </dl>
                <dl>
                    <dt>SALES &amp; Communication Tasks</dt>
                    <dd>— Promote the sales of Infinix products on campus</dd>
                    <dd>— Act as a channel of communication between university students/administration/student bodies &amp; Infinix brand team</dd>
                    <dd>— Responsible for reporting monthly activities for performance measurements</dd>
                </dl>
                <h2>Product Promotion</h2>
                <dl>
                    <dd>— Induces trial, develops new usage situations and creates positive word of mouth about Infinix phones</dd>
                    <dd>— Increases awareness amongst associates of the students who are not in university i.e. work colleagues and sporting team-mates</dd>
                    <dd>— Continually seeks opportunities to develop Infinix brand profile, image and credibility on and around campus within the student market</dd>
                </dl>

            </div>
            <div class="uap-cdt col-xs-12 col-md-3">
                <h2>Ideal candidate</h2>
                <img src="/wp-content/uploads/images/uap-cdt.jpg">
                <p>Are you the one?</p>
            </div>
        </div>
    </div>
</section>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-69529119-1', 'auto');
  ga('send', 'pageview');
</script>

<?php get_footer(); ?>
