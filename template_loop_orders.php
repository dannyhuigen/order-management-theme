<?php
/**
 * Template Name: Signle shop page
 *
 */

include('phpqrcode/qrlib.php');

$get_shop_url = getUrlParameterValue("shopGetUrl");
$singleShopWithOrders = returnSingleShop($get_shop_url);
$shop_info = getShopByGetUrl(explode("?" , $get_shop_url)[0]);
?>
        <div data-idPrefix="<?php echo $shop_info["idPrefix"]; ?>" class="row all-order-row">
            <div class="col-12 js-expand-click shop-title-wrapper js-shop-title-wrapper"><h2><?php echo $singleShopWithOrders[0][0]["shop_name"] ; ?></h2><h3><?php echo " " . count($singleShopWithOrders[0][0]["orders"]) . " orders over" ?></h3></div>
            <div class="col-12 js-expander" style="display: none;">
                <div class="row info-orders-wrapper">
                    <div data-orderstatus="processing" class="col-6 col-lg-1 js-checkbox active">Processing<br>(0)</div>
                    <div data-orderstatus="on-hold" class="col-6 col-lg-1 js-checkbox active">On hold<br>(0)</div>
                    <div data-orderstatus="pending" class="col-6 col-lg-1 js-checkbox active">Pending<br>(0)</div>
                    <div data-orderstatus="completed" class="col-6 col-lg-1 js-checkbox">Completed<br>(0)</div>
                    <div class="col-12 col-lg-2"></div>
                    <div class="col-6 col-lg-2"><input class="orderfill js-orderfill-id" placeholder="order id" type="text"></div>
                    <div class="col-6 col-lg-2"><input class="orderfill js-orderfill-zip" placeholder="Postcode" type="text"></div>
                    <div class="col-6 col-lg-1"><div class="orderfill orderfill-btn js-orderfill-search">Zoek order</div></div>
                    <div class="col-6 col-lg-1"><div class="orderfill orderfill-btn js-orderfill-reload">Reset</div></div>
                </div>
                <div class="row info-orders-wrapper">
                    <div class="order-col-title col-1">Klant naam</div>
                    <div class="order-col-title col-1">Order #</div>
                    <div class="order-col-title col-1">Verzending</div>
                    <div class="order-col-title col-1">Bestelling geplaatst</div>
                    <div class="order-col-title col-1">Order status</div>
                    <div class="order-col-title col-1">Complete order</div>
                    <div class="order-col-title col-1">Huisnummer toevoeging</div>

                    <div class="col-2"></div>
                    <div class="col-2"></div>
                </div>
                <div class="orders-wrapper js-orders-wrapper">
                    <?php foreach ($singleShopWithOrders[0][0]["orders"] as $order){

                        //Straatnaam en straathuisnummer worden vaak door elkaar gehaald
                        //Probeert een waring te geven door deze paar regels code
                        $straat_naam_fout = false;
                        $straat_debug = false;
                        $straat_naam_debug = preg_replace('/[^0-9]/', 'FIREDEBUG', $straat_nummer);
                        $straat_nummer_debug = preg_replace('/[0-9]+/', 'FIREDEBUG', $straat_naam);
                        $shipping_method = $order->order_shipping_method;
                        $afhalen_class = "sb-correct";

                        //main heeft huisnummer in adress
                        if(1 === preg_match('~[0-9]~', $order->order_shipping_address_1)){
                            preg_match('/([^\d]+)\s?(.+)/i', $order->order_shipping_address_1, $adress);
                            $straat_naam = $adress[1];
                            $straat_nummer = $adress[2];
                        }
                        else{
                            $straat_naam = $order->order_shipping_address_1;
                            $straat_nummer = $order->order_shipping_houseno;
                        }

                        if (strpos($straat_naam_debug, "FIREDEBUG") !== false || strpos($straat_nummer, "FIREDEBUG") !== false) {
                            $straat_debug = true;
                        }

                        if(strpos($shipping_method, "Afhalen") !== false){
                            $afhalen_class = "sb-danger";
                        }
                        ?>

                        <div data-orderzip="<?php echo $order->order_billing_postcode; ?>" data-orderid="<?php echo $shop_info["idPrefix"] . $order->order_id; ?>" data-orderstatus="<?php echo $order->order_status; ?>" class="row order-row  js-refreshable">
                            <div class="order-row-checker"></div>
                            <div class="order-colum order-colum-name col-1"><?php echo $order->order_billing_first_name; ?> <?php echo $order->order_billing_last_name; ?></div>
                            <div class="order-colum order-colum-orderid col-1">#<?php echo $shop_info["idPrefix"] . $order->order_id; ?></div>
                            <div style="padding: 0;" class="order-colum col-1 <?php echo $afhalen_class ?>">
                                <?php echo $order->order_shipping_method; ?>
                            </div>
                            <div class="order-colum col-1"><?php echo $order->order_date_created; ?></div>
                            <div style="<?php if($order->order_status === "completed"){?> background-color: limegreen;<?php } elseif($order->order_status === "on-hold"){ echo "background-color: goldenrod;";}else{ echo "background-color: aquamarine;";} ?>" class="order-colum col-1"><?php echo $order->order_status; ?></div>
                            <div class="order-colum col-1"><a target="_blank" class="clicker" href="<?php echo $get_shop_url . "?changeStatus=" . dec_enc("encrypt", $order->order_id);?>">Complete order</a></div>
                            <div style="padding: 0;" class="col-1 <?php if($straat_debug){ echo "sb-danger"; }?>">
                                <?php if($straat_debug){
                                    echo "Let op!";
                                } else{
                                    echo "OK";
                                }?>
                            </div>
                            <div class="order-colum col-1"><a target="_blank" class="clicker" href="<?php echo get_site_url() . "/order/?orderId=" . $order->order_id . "?siteUrl=" . $get_shop_url ?>">Ga naar order</a></div>
                            <div class="order-colum col-1"><a class="clicker" target="_blank" href="<?php echo $order->edit_url; ?>">Wordpress</a></div>
                            <div class="order-colum order-colum-createdpd col-1"><a class="clicker" href="<?php echo str_replace("%20" , " " , get_site_url() . "/createdpdorder?sender_name=". $singleShopWithOrders[0][0]["shop_name"]."?sender_street=".$singleShopWithOrders[0][0]['sender_street']."?sender_houseNo=".$singleShopWithOrders[0][0]['sender_houseNo']."?sender_country=".$singleShopWithOrders[0][0]['sender_country']."?sender_zipCode=".$singleShopWithOrders[0][0]['sender_zipCode']."?sender_city=".$singleShopWithOrders[0][0]['sender_city']."?reciept_name=". $order->order_shipping_first_name . " ". $order->order_shipping_last_name ."?reciept_street=".$straat_naam."?reciept_houseNo=".$straat_nummer."?reciept_country=".$order->order_shipping_country."?reciept_zipCode=".$order->order_shipping_postcode."?reciept_city=".$order->order_shipping_city . "?reciept_email=". $order->order_shipping_email); ?>">Creer DPD</a></div>
                            <div class="order-colum col-1"><a class="clicker js-dpd-clicker" href="" data-name="<?php echo $order->order_shipping_first_name . " " . $order->order_shipping_last_name; ?>" data-adress="<?php echo $straat_naam . " " . $straat_nummer ?>" data-city="<?php echo $order->order_shipping_city; ?>" data-postcode="<?php echo $order->order_shipping_postcode; ?>" data-country="<?php echo $order->order_shipping_country; ?>" data-telephone="<?php echo $order->order_shipping_phone; ?>" data-email="<?php echo $order->order_billing_email; ?>" data-id="<?php echo $order->order_id; ?>" >Copy GLS</a></div>
                            <div class="order-colum col-1 js-expand-click expand-click">Expand</div>
                            <div class="js-expander expand-info col-12">
                                <div class="row" style="word-break: break-word; margin-top: 20px;">
                                    <div class="col-3 col-lg-2">
                                        <h3>Billing</h3>
                                        <span><?php echo $order->order_billing_first_name; ?> <?php echo $order->order_billing_last_name; ?></span><br>
                                        <span><?php echo $order->order_billing_company; ?></span><br>
                                        <span><?php echo $order->order_billing_address_1; ?></span><br>
                                        <span><?php echo $order->order_billing_address_2; ?></span><br>
                                        <span><?php echo $order->order_billing_city; ?></span><br>
                                        <span><?php echo $order->order_billing_state; ?></span><br>
                                        <span><?php echo $order->order_billing_postcode; ?></span><br>
                                        <span><?php echo $order->order_billing_country; ?></span><br>
                                    </div>
                                    <div class="col-3 col-lg-2">
                                        <h3>Shipping</h3>
                                        <span><?php echo $order->order_shipping_first_name; ?> <?php echo $order->order_billing_last_name; ?></span><br>
                                        <span><?php echo $order->order_shipping_company; ?></span><br>
                                        <span><?php echo $order->order_shipping_address_1; ?></span><br>
                                        <span><?php echo $order->order_shipping_address_2; ?></span><br>
                                        <span><?php echo $order->order_shipping_city; ?></span><br>
                                        <span><?php echo $order->order_shipping_state; ?></span><br>
                                        <span><?php echo $order->order_shipping_postcode; ?></span><br>
                                        <span><?php echo $order->order_shipping_country; ?></span><br>
                                    </div>
                                    <div class="col-3 col-lg-2">
                                        <h3>Contact</h3>
                                        <span><?php echo $order->order_billing_first_name; ?> <?php echo $order->order_billing_last_name; ?></span><br>
                                        <span><?php echo $order->order_billing_company; ?></span><br>
                                        <span></span><br>
                                        <span><?php echo $order->order_billing_email; ?></span><br>
                                        <span><?php echo $order->order_billing_phone; ?></span>
                                    </div>
                                    <div class="col-3 col-lg-2">
                                        <h3>Straatverwarring:</h3><br><br>
                                        <span>straatnaam: <?php echo  $straat_naam?></span><br>
                                        <span>straatnummer <?php echo $straat_nummer ?></span>
                                    </div>
                                    <div class="col-0 col-lg-2"></div>
                                    <?php $url = str_replace("&","%26",$order->edit_url); ?>
                                    <div class="d-none d-lg-block"><img src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=<?php echo $url; ?>" title="Ga naar order QR" /></div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>


