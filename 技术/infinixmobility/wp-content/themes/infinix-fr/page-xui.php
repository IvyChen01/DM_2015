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
            <div class="col-xs-12 xui-kv-logo"><img src="/wp-content/uploads/images/xui-kv-logo-fr.png"></div>
            <div class="col-xs-12"><img src="/wp-content/uploads/images/xui-kv-1.png"></div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-1">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Amélioration de la performance de 21%</h2>
                <p>Gestion optimisée grâce à l'utilisation intelligente de la RAM, une accélération régulière du système et une touche de nettoyage rapide et propre de la mémoire. La performance globale est améliorée de 21% pour un fonctionnement ultra lisse avec zéro lag.</p>
            </div>
            <div class="col-xs-12">
                <img src="/wp-content/uploads/images/xui-1-1-fr.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-2">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Amelioration de la durée de batterie de 20%</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-2-1.png">
                <h3>Gestion unique des Applications ouvertes</h3>
                <p>Diminution de la consommation d’énergie des applications ouvertes non utilisées.</p>
            </div>
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-2-2.png">
                <h3>Gestion unique des réseaux lors de la veille</h3>
                <p>En mode veille, XUI initie automatiquement une gestion spécifique des réseaux pour augmenter la durée de vie de 28%.</p>
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-3">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>Fonds d'écran et thèmes chics</h2>
                <p>Couleurs branchées de l’Interface utilisateur offrant des images vives et des textes nets. Méticuleusement conçus; icônes, thèmes et fonds d'écran sont régulièrement mis à jour. De nouveaux thèmes seront disponibles rendant votre smartphone encore plus personnalisé.</p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-3-1-fr.jpg">
            </div>
            <div class="col-xs-12 col-sm-6">
                <img src="/wp-content/uploads/images/xui-3-2-fr.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-4">
    <img class="" src="/wp-content/uploads/images/xui-4-bg-1.jpg">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 pull-right">
                <h2>Suivez les mises à jour Android</h2>
                <p>XUI a été optimisé avec une méthodologie légère basée sur les tendances du marché et sur la logique de fonctionnement Android; ce qui maintient le bon fonctionnement du système d'exploitation et assure des mises à jour rapides. Avec XUI, vous pouvez profiter du dernier système d'exploitation.</p>
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
                <span>Restez en contact</span>
                <h2>un seul compte, connecté partout</h2>
                <p>Xaccounts est connecté pour votre confort. Créez votre compte pour accéder à la plate-forme de logiciel comprennant Xcontacts, Xclub, et les commentaires d’utilisateurs.</p>
                <img src="/wp-content/uploads/images/xui-5-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-6">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>Fonction d'économie d'énergie avancée</span>
                <h2>une batterie faible n’est plus un problème</h2>
                <p>Mode “ultra économie énergie”, les utilisateurs peuvent définir des rappels ou l’activer automatiquement lorsque l'alimentation tombe en dessous de 10%. L'interface de ce mode comprend 6 applications. Toutes les fonctions en arrière plan sont coupées pour une consommation d'énergie minimale. La durée de vie en veille est doublée afin d’optimiser le temps utilisation de votre smartphone quand la batterie est faible.</p>
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
                <h2>ne jamais perdre le contact</h2>
                <p>Xcontacts garde vos contacts en toute sécurité; Identifiez-vous avec Xcontacts et synchronisez via le cloud. Lors de la perte ou d’un changement de smartphone, Il vous suffira de les télécharger pour gagner du temps et de l'énergie. Une fonction de recyclage est incluse pour une mise à jour pratique de l’annuaire téléphonique.</p>
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
                <h2>Changer de téléphone mobile facilement.</h2>
                <p>Notre technologie unique de transfert rapide vous permet d'économiser à la fois temps et argent. Lorsque vous changez de téléphone, connectez-vous sur Xender via votre compte afin de transférer rapidement vos photos, vidéos, logiciels et autres formats de données. Ce processus ne consomme pas la bande passante et est nettement plus rapide que Bluetooth. Xender permet également aux utilisateurs de partager du contenu avec des amis à travers les dispositifs mobiles</p>
                <img src="/wp-content/uploads/images/xui-8-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-9">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h2>forum XClub-Infinix</h2>
                <p>Xclub est le forum officiel de Infinix. Les utilisateurs peuvent se connecter via leurs comptes afin de partager des conseils, télécharger des mises à jour, donner leurs avis et gagner des prix.</p>
                <img src="/wp-content/uploads/images/xui-9-1.jpg">
            </div>
        </div>
    </div>
</section>

<section class="xui-section xui-section-10">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <span>Avis des utilisateurs</span>
                <h2>discuter avec les développeurs</h2>
                <p>La plate-forme Xui avec les avis rapporche les utilisateurs et développeurs . Connectez-vous avec votre X-compte afin de partager votre expérience, faire des suggestions ou rapporter des bugs. Etant une partie importante de notre processus, les avis sont soigneusements considérés dans les mises à jour et correctifs futurs.</p>
                <img src="/wp-content/uploads/images/xui-10-1.png">
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
