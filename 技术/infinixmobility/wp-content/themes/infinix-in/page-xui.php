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
            <div class="col-xs-12 xui-kv-logo"><img src="/wp-content/uploads/images/xui-kv-logo-in.png"></div>
            <div class="col-xs-12"><img src="/wp-content/uploads/images/xui-kv-1.png"></div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-1">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Peningkatan Kinerja 21%</h2>
                <p>Manajemen latar belakang dimaksimalkan melalui pengelolaan RAM yang terperinci, akselarasi system secara teratur, dan akses cepat untuk pembersihan cepat. Secara umum kinerjanya meningkat 21% untuk pengoperasian sangat lancar tanpa lag sedikitpun.</p>
            </div>
            <div class="col-xs-12">
                <img src="/wp-content/uploads/images/xui-1-1-in.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Daya tahan baterai bertambah 20%</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-2-1.png">
                <h3>Peringatan unik disinkronisasi dengan detak jantung</h3>
                <p>Meminimalisasi system bekerja untuk mengurangi penggunaan daya ketika aplikasi berjalan saat tidak digunakan.</p>
            </div>
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-2-2.png">
                <h3>Manajemen Jaringan Aktif yang unik</h3>
                <p>Dalam keadaan aktif, Xui secara otomatis memulai jaringan manajemen siaga untuk meningkatkan waktu siaga sebesar 28%.</p>
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-3">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Wallpaper &amp; Tema yang Menawan</h2>
                <p>Desain warna yang trendy ditambah dengan gambar yang nyata dan teks yang tajam. Rancangan ikon, tema dan wallpaper yang cermat diperbaharui secara teratur. Akan tersedia pula desain tema, yang membuat Smartphonemu menjadi lebih berwarna.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-3-1-in.jpg">
            </div>
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-3-2-in.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-4">
    <img class="" src="/wp-content/uploads/images/xui-4-bg-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 pull-right">
                <h2>Selalu mendapatkan pembaruan yang terbaru dari Android</h2>
                <p>Xui dioptimalkan dengan metodologi ringan berdasarkan tren pasar dan operasi Android; OS ini berjalan lancar dan dipastikan mendapat versi pembaruan teratur. Dengan XUI, anda dapat merasakan sistem operasi terbaru.</p>
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
                <span>Satu Akun</span>
                <h2>untuk semua keperluan</h2>
                <p>X Account disambungkan untuk kenyamanan anda. X account Mendaftarkan satu akun untuk software platform akses termasuk Xcontacts, Xclub, dan umpan balik pengguna.</p>
                <img src="/wp-content/uploads/images/xui-5-1-in.png">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-6">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>Fungsi penghemat daya: tidak ada lagi baterai lemah</span>
                <p>Dengan mode penghemat daya ultra, pengguna dapat mengatur atau mengaktifkan secara otomatis ketika daya berada dibawah 10%. Tampilan pada mode ini hanya memiliki 6 aplikasi saja. Semua fungsi yang berjalan di latar belakang dihentikan untuk meminimalisasi penggunaan daya; ini secara efisien sehingga kamu dapat menggunakannya walaupun dalam keadaan baterai lemah.</p>
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
                <h2>tidak akan pernah</h2>
                <h2>kehilangan kontak</h2>
                <p>X Contacts menjaga kontakmu dengan aman; masuk menggunakan X Contacts dan sinkronisasi menggunakan Cloud. Pengunduhan yang gampang ketika berpindah device untuk menghemat waktu dan tenaga. Sebuah fungsi daur ulang ditambahkan untuk pembaharuan buku telepon dengan teratur.</p>
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
                <h2>bertukar data dengan mudah</h2>
                <p>Teknologi unik ini menghadirkan transfer data yang cepat menghemat waktu dan uang. Login ke xender melalui X Account ketika berganti ponsel dengan cepat mentransfer foto, video, software, dan format data lainnya. Proses ini tidak mengkonsumsi bandwidth dan secara signifikan lebih cepat daripada Bluetooth. Xender juga memungkinkan pengguna untuk berbagi konten dengan teman - teman di seluruh perangkat telepon.</p>
                <img src="/wp-content/uploads/images/xui-8-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-9">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>X Club-Forum Infinix</h2>
                <p>X Club adalah Forum resmi dari Infinix. <br>Pengguna dapat masuk menggunakan X Account untuk berbagi tips, mengunduh pembaharuan, memberikan umpan balik dan memenangkan hadiah.</p>
                <img src="/wp-content/uploads/images/xui-9-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-10">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>Umpan balik pengguna</span>
                <h2>berbicara dengan pengembang</h2>
                <p>Umpan balik pada XUI membawa pengguna lebih dekat dengan pengembang. Masuk dengan X Account untuk memberikan komentar pengalaman pengguna, membuat saran, atau laporan bug. Sebagai bagian penting dari proses kami, umpan balik dipertimbangkan secara cermat untuk pembaruan dan perbaikan kedepannya.</p>
                <img src="/wp-content/uploads/images/xui-10-1.png">
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
