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

get_header(1); ?>

<style>
    .xui-kv {background: url(/wp-content/uploads/images/xui-kv-bg.jpg) center center no-repeat;background-size: 100% auto;padding-bottom: 0;}
    .xui-kv-logo {text-align: center;margin-bottom: 15px;}
    .xui-kv-logo img {max-width: 80%;}

    .xui-section {padding: 15px 0;background-repeat: no-repeat;background-size: cover;background-position: center center;text-align: center;}
    .xui-section h2 {font-size: 16px;font-weight: bold;margin-top:0;color: #00b0a2;}
    .xui-section span {color: #00b0a2;font-size: 16px;}
    .xui-section h3 {font-size: 14px;margin-top: 0;}
    .xui-section p {max-width: 80%;margin:0 auto;font-size: 12px;color: #333;}
    .xui-section img {margin: 15px auto;}

    .xui-section-1 {background-color: #f5f5f5;}

    .xui-section-2 {background-image: url(/wp-content/uploads/images/xui-2-bg.jpg);}
    .xui-section-2 h2,.xui-section-2 h3,.xui-section-2 p {color: #fff;}
    .xui-section-2 img {max-width: 80px;}

    .xui-section-3 {padding-bottom: 0;}

    .xui-section-4 {padding: 0;background-color: #aeafb4;}
    .xui-section-4 img {margin: 0;}
    .xui-section-4 h2,.xui-section-4 p {color: #fff;}

    .xui-section-5 {padding-top: 0;}

    .xui-section-6 {background-color: #f5f5f5;}

    .xui-section-7 {padding-bottom: 0;}
    .xui-section-7 img {margin: 0 auto;}

    .xui-section-8 {background-color: #f5f5f5;}

    .xui-section-10 {background-image: url(/wp-content/uploads/images/xui-10-bg.jpg);}
    .xui-section-10 h2,.xui-section-10 span,.xui-section-10 p {color: #fff;}

    @media (min-width: 768px) {
        .xui-section {padding: 30px 0;}
        .xui-section h2 {font-size: 24px;}
        .xui-section span {font-size: 20px;}
        .xui-section h3 {font-size: 18px;margin-top: 0;}
        .xui-section p {max-width: 90%;font-size: 14px;}
        .xui-section img {margin: 30px auto;}
        .xui-section-2 img {max-width: 100%;}
        .xui-section-3 {padding-bottom: 0;}
        .xui-section-4 {padding: 0;text-align: left;}
        .xui-section-4 p {max-width: 100%;}
        .xui-section-4 img {margin: 0;}
        .xui-section-5 {padding-top: 0;}
        .xui-section-7 {padding-bottom: 0;text-align: left;}
        .xui-section-7 img {margin: 0;}
        .xui-section-7 p {max-width: 100%;}
    }
    @media (min-width: 992px) {
        .xui-kv img {margin: 30px auto;}
        .xui-section h2 {font-size: 36px;}
        .xui-section span {font-size: 30px;}
        .xui-section h3 {font-size: 24px;}
        .xui-section p {font-size: 18px;}
        .xui-section {padding: 60px 0;}
        .xui-section-3 {padding-bottom: 0;}
        .xui-section-4 {padding: 0;}
        .xui-section-4 img {margin: 0;}
        .xui-section-5 {padding-top: 0;}
        .xui-section-7 {padding-bottom: 0;}
        .xui-section-7 img {margin: 0;}
    }
    @media (min-width: 1200px) {
        .xui-kv img {margin: 60px auto;}
    }
</style>

<section class="xui-kv">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 xui-kv-logo"><img src="/wp-content/uploads/images/xui-kv-logo-th.png"></div>
            <div class="col-xs-12"><img src="/wp-content/uploads/images/xui-kv-1.png"></div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-1">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>ปรับปรุงการทำงานถึง 21%</h2>
                <p>การจัดการพื้นหลังมีความเหมาะสมมากที่สุดผ่านการจัดการ RAM อัจฉริยะ การเพิ่มความเร็วของระบบ และการจัดการหน่วยความจำอย่างรวดเร็วด้วยคีย์เดียว  การทำงานโดยรวมได้รับการปรับปรุง 21% สำหรับการปฏิบัติการที่ราบรื่นเป็นพิเศษโดยไม่มีความล่าช้า การทำงานโดยรวมได้รับการปรับปรุง 21%</p>
            </div>
            <div class="col-xs-12">
                <img src="/wp-content/uploads/images/xui-1-1-th.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>ยืดระยะเวลาการใช้งานของแบตเตอรี่ถึง 20%</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-2-1.png">
                <h3>การเตือนเป็นพิเศษเสมือนกับการเต้นของหัวใจ</h3>
                <p>ระบบลดการปลุกเพื่อลดการใช้กำลังไฟของแอปปลิเคชั่นพื้นหลัง</p>
            </div>
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-2-2.png">
                <h3>การจัดการเครือข่ายการ Standby เป็นพิเศษ</h3>
                <p>ในโหมด Standby XUI จะทำการจัดการเครือข่ายการ Standby โดยอัตโนมัติเพื่อเพิ่มเวลาในการ Standby 28%</p>
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-3">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>วอลล์เปเปอร์และธีมสุดชิค</h2>
                <p>ใช้เทรนการออกแบบสีเพื่อให้ภาพนั้นชัดเจนมีชีวิตชีวาและเนื้อหาที่ชัดเจน การออกแบบไอคอนอย่างพิถีพิถัน ธีมและวอลล์เปเปอร์ที่มีการอัพเดทเป็นประจำ การออกแบบธีมสามารถนำมาใช้ได้ในเวลาต่อมา ทำให้สมาร์ทโฟนของคุณมีความเป็นส่วนตัวมากขึ้น</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-3-1-th.jpg">
            </div>
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-3-2-th.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-4">
    <img class="" src="/wp-content/uploads/images/xui-4-bg-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 pull-right">
                <h2>ก้าวทันการอัพเกรดแอนดรอยด์ของคุณ</h2>
                <p>XUI มีความเหมาะสมโดยมีการใช้เทคโนโลยีที่ลดการใช้งานหนักสำหรับแนวโน้มทางการตลาดและเหตุผลในการปฏิบัติการของแอนดรอยด์ ทำให้การทำงานของระบบปฏิบัติการ OS มีความราบรื่นและมั่นใจได้ว่ามีการอัพเดทที่รวดเร็ว ด้วย XUI คุณสามารถสัมผัสได้ถึงระบบปฏิบัติการที่อัพเดตที่สุดเสมอ</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-8">
                <img src="/wp-content/uploads/images/xui-4-1.jpg">
            </div>
        </div>
    </div>
    <img src="/wp-content/uploads/images/xui-4-bg-2.jpg">
</section>

<section class="xui-section xui-section-5">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>ไม่พลาดการติดต่อ</span>
                <h2>หนึ่งบัญชีติดต่อได้ทุกๆ ที่</h2>
                <p>Xaccounts เป็นการเชื่อมต่อเพื่อความสะดวกของคุณ การลงทะเบียนหนึ่งบัญชีเพื่อให้เข้าถึงซอร์ฟแวร์รวมถึง Xcontacts, X club และการตอบรับของผู้ใช้</p>
                <img src="/wp-content/uploads/images/xui-5-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-6">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>โหมดประหยัดไฟล่วงหน้า</span>
                <h2>ไม่ต้องร้องไห้เมื่อแบตเตอรี่อ่อนอีกแล้ว</h2>
                <p>ด้วยโหมดการประหยัดพลังงานแบบอัลตร้า ผู้ใช้สามารถกำหนดการตั้งเตือนหรือระบบอัตโนมัติในทันทีเมื่อกำลังไฟตกลงต่ำกว่า 10% โดย interface สำหรับโหมดนี้จะมีแค่ 6 แอปพลิเคชั่นหลัก การทำงานทั้งหมดของแอปพลิเคชั่นพื้นหลังจะถูกระงับเพื่อการใช้กำลังไฟที่น้อยที่สุด รวมถึงทำให้ระยะเวลาในโหมด standby เพิ่มขึ้นสองเท่า ดังนั้นคุณสามารถใช้ได้อย่างต่อเนื่องภายใต้สภาวะของแบตเตอรี่อ่อน</p>
                <img src="/wp-content/uploads/images/xui-6-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-7">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 pull-right">
                <span>XContacts</span>
                <h2>ไม่เคยขาดการติดต่อ</h2>
                <p>Xcontacts ให้รายชื่อติดต่อของคุณปลอดภัยเสมอ ล๊อคอินด้วย Xcontacts กับ sync up ผ่าน Cloud ดาวน์โหลดง่ายๆ เมื่อทำการเปลี่ยนอุปกรณ์มือถือเพื่อประหยัดเวลาและพลังงาน การหมุนเวียนนี้ถูกนำมารวมสำหรับการอัพเดทสมุดโทรศัพท์ที่สะดวกมากขึ้น</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <img src="/wp-content/uploads/images/xui-7-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-8">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>Xender</span>
                <h2>การแลกเปลี่ยนของโทรศัพท์ได้โดยง่าย</h2>
                <p>ด้วยเทคโนโลยีการถ่ายโอนข้อมูลพิเศษของเราทำให้คุณประหยัดทั้งเวลาและเงิน โดยล๊อคอินไปที่ Xender ผ่านบัญชี X เพื่อทำการถ่ายโอนข้อมูลของโทรศัพท์อย่างรวดเร็วเช่น วีดีโอ ซอร์ฟแวร์และรูปแบบข้อมูลอื่นๆ ขั้นตอนนี้ไม่ต้องใช้แบนวิซและรวดเร็วกว่า Bluetooth ดังนั้น Xender จึงเปิดโอกาสให้ผู้ใช้ได้ใช้คอนเท็นต์ร่วมกันกับเพื่อนผ่านอุปกรณ์โทรศัพท์มือถือ</p>
                <img src="/wp-content/uploads/images/xui-8-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-9">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>การแลกเปลี่ยนความคิดเห็นของ XClub-Infinix</h2>
                <p>Xclub เป็นการแลกเปลี่ยนความเห็นอย่างเป็นทางการของ Infinix ผู้ใช้สามารถล๊อคอินผ่านบัญชี X เพื่อใช้คำแนะนำร่วมกัน อัพเดท ดาวน์โหลด แนะนำติชม และให้รางวัลผู้ชนะในกิจกรรมต่างๆ</p>
                <img src="/wp-content/uploads/images/xui-9-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-10">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>การตอบรับของผู้ใช้</span>
                <h2>พูดคุยกับนักพัฒนา</h2>
                <p>แนวทางการตอบรับของ XUI ที่ทำให้ผู้ใช้ใกล้ชิดกับนักพัฒนามากขึ้น ล๊อคอินด้วยบัญชี X เพื่อแสดงความคิดเห็นจากประสบการณ์ของผู้ใช้ ทำการแนะนำ หรือรายงานจุดบกพร่อง ซึ่งเป็นส่วนสำคัญของขั้นตอนของเรา โดยความคิดเห็นจะได้รับการพิจารณาอย่างรอบคอบสำหรับการอัพเดทและแก้ไขในอนาคต</p>
                <img src="/wp-content/uploads/images/xui-10-1.png">
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
