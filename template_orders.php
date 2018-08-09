<?php
/**
 * Template Name: samti template
 *
 */

include("templates/login_redirecter");
include('phpqrcode/qrlib.php');

$allShopsWithHoutOrders = getAllShops();
$current_user = wp_get_current_user();
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/samti.png"/>
    <meta charset="UTF-8">
    <title>Samti orders</title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/styles.css">
<body id="body">

<?php include_once "templates/header.php" ?>

<div id="js-all-shops" class="content-wrapper js-all-shops">

    <?php foreach ($allShopsWithHoutOrders as $singleShop){ ?>
        <div data-geturl="<?php echo get_site_url() . "/getsignleshop/?shopGetUrl=" . $singleShop["get_url"] . "?parameters=wc-pending///wc-processing///wc-on-hold"  ?>" class="js-single-shop" id="<?php echo $singleShop["shop_name"]; ?>">
            <div class="row all-order-row">
                <div style="margin: 0" class="shop-title-wrapper shoploader col-12 js-expand-click shop-title-wrapper js-shop-title-wrapper">
                    <h2><?php echo $singleShop["shop_name"]; ?> informatie aan het ophalen...</h2>
                    <div class="loader-icon lds-default"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
                </div>
            </div>
        </div>
    <?php } ?>

</div>

<?php include "templates/selected-manager.php"; ?>

<div class="gls-auto-grabber" style="display: none;">
    <p id="gls_name"></p>
    <p id="gls_adress"></p>
    <p id="gls_city"></p>
    <p id="gls_postcode"></p>
    <p id="gls_country"></p>
    <p id="gls_telephone"></p>
    <p id="gls_email"></p>
    <p id="gls_id"></p>
</div>
<?php //include "templates/gls_grabber"?>
<div style="margin-top: 100px"></div>
<div class="gls-confirmation-wrapper" style="display: none">
    <p>De order van Danny Huigen is gecopierd naar uw GLS klembord</p>
</div>

<div class="utility-wrapper js-utility-wrapper">
    <span class="credits">Samti order-getter by Danny Huigen</span>
    <div class="toggle-click js-utility-click"></div>
    <div class="content-wrapper utility-conent">
        <div class="row">
            <div class="col-9 sub-info">
                <input class="js-search-input" type="text" placeholder="order id">
                <span class="search-button">Zoek order</span><br><br>
                <a href="http://www.dpdshippingreport.nl/">Klik hier voor de DPD tracking</a><br><br>
                <a href="<?php echo get_site_url() . "/getDPDauthkey" ?>">Vraag nieuwe DPD authkey aan</a>
            </div>
            <div class="col-3 sub-info">
                <p>Ingelogd als:</p>
                <p><?php echo $current_user->display_name; ?></p>
                <br><br>
                <a href="<?php echo wp_logout_url(); ?>">Klik hier om uit te loggen</a>
            </div>
        </div>
    </div>
</div>

<div class="dark-background"></div>
<div class="search-results">
    <div class="row">
        <div class="col-3 header">Webshop</div>
        <div class="col-2 header">OrderId</div>
        <div class="col-2 header">Klant naam</div>
        <div class="col-3 header">Datum</div>
        <div class="col-2 header">Status</div>
        <div class="col-12" style="font-size: 18px;">
            <?php foreach ($allShopsWithHoutOrders as $singleShop){ ?>
                <div class="row js-to-search"  data-geturl="<?php echo get_site_url()?>/searchresult/?shopGetUrl=<?php echo $singleShop["get_url"] . "?shopName=".$singleShop["shop_name"] ; ?>" data-id="7646"></div>
            <?php } ?>
        </div>
    </div>
</div>

</body>
</html>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/scripts/app.js"></script>