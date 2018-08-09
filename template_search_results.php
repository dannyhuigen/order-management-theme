<?php
/**
 * Template Name: Search result
 *
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

error_reporting(E_ERROR | E_PARSE);
$get_shop_url = getUrlParameterValue("shopGetUrl");
$shopname = getUrlParameterValue("shopName");
$order_id = getUrlParameterValue("orderId");
$get_url = $get_shop_url . "?orderId=" . $order_id;
$encrypted_content = file_get_contents($get_url);

if ($encrypted_content == ""){
    ?>

    <div class="col-3" style="color: white; font-size: 16px;"><?php echo $shopname; ?></div>
    <div class="col-9" style="color: red; font-size: 16px;">Geen order gevonden...</div>

    <?php
}
else{
    $json = dec_enc("decrypt" , $encrypted_content);
    $orderinfo = json_decode($json)->order_details;
    ?>
    <div class="col-3"><?php echo $shopname; ?></div>
    <div class="col-2"><?php echo $orderinfo->order_id; ?></div>
    <div class="col-2"><?php echo $orderinfo->order_billing_first_name . " " . $orderinfo->order_billing_last_name; ?></div>
    <div class="col-3"><?php echo $orderinfo->order_date_created; ?></div>
    <div class="col-2"><?php echo $orderinfo->order_status; ?></div>
<?php
}

