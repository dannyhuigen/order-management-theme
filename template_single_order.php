<?php
/**
 * Template Name: Single order page
 *
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

$order_id = getUrlParameterValue("orderId");
$site_url = getUrlParameterValue("siteUrl");
$get_url = $site_url . "/?orderId=" . $order_id;
$json = dec_enc("decrypt" , file_get_contents($get_url));
$recieved_info = json_decode($json);

$products = $recieved_info->products;
$order = $recieved_info->order_details;

$current_shop = getShopByGetUrl($site_url);

//var_dump($products);

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/samti.png"/>
    <meta charset="UTF-8">
    <title>Order #<?php echo $order_id ?></title>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/styles/styles.css">
<body>

<?php include_once "templates/header.php" ?>

    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 shop-title-wrapper"><h1>Order #<?php echo $current_shop["idPrefix"] . $order_id ?></h1></div>
            <div class="col-12">
                <?php include_once "templates/klant_info"; ?>
            </div>
            <div class="col-12 shop-title-wrapper" style="margin-top: 20px;">
                <h1>Producten:</h1>
            </div>
            <div class="col-12 product-wrapper">
                <div class="row info-orders-wrapper">
                    <div class="col-2">Product foto</div>
                    <div class="col-8">Product naam</div>
                    <div class="col-2">Product hoeveelheid</div>
                </div>
                <div class="order-wrapper">
                    <?php foreach ($products as $single_product){?>
                    <div class="row order-row">
                        <div class="col-2 order-colum ">
                            <div class="order-image" style="background-image: url('<?php echo $single_product->product_image_url;?>')"></div>
                        </div>
                        <div class="col-8 order-colum product-name">
                            <p><?php echo $single_product->product_name; ?></p>
                            <?php if (count($single_product->extra_options) !== 0){?>
                            <div class="row">
                                <div class="col-8 extra-options">
                                    <div class="row">
                                        <div class="col-8 title"><p>Extra opties</p></div>
                                        <div class="col-4 title"><p>Aantal</p></div>
                                    </div>
                                    <?php foreach ($single_product->extra_options as $single_option){ ?>
                                        <div class="row">
                                            <div class="col-8 text"><?php echo $single_option->value; ?></div>
                                            <div class="col-4 text"><?php echo $single_option->quantity; ?></div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <div class="col-2 order-colum product-amount"><?php echo $single_product->product_quantity . "x";?></div>
                    </div>
                        <div class="row">
                            <div class="col-2"></div>
                        </div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>

    <?php include_once "templates/gls_grabber"; ?>

</body>
</html>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/scripts/app.js"></script>

