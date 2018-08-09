<?php
/**
 * Template Name: Create dpd order
 *
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'wp-content/themes/order-management-theme/PHPMailer-master/src/Exception.php';
require 'wp-content/themes/order-management-theme/PHPMailer-master/src/PHPMailer.php';
require 'wp-content/themes/order-management-theme/PHPMailer-master/src/SMTP.php';

include("templates/login_redirecter");

$order_info = array(
    "sender_name" => getUrlParameterValue('sender_name'),
    "sender_street" => getUrlParameterValue('sender_street'),
    "sender_houseNo" => getUrlParameterValue('sender_houseNo'),
    "sender_country" => getUrlParameterValue('sender_country'),
    "sender_zipCode" => getUrlParameterValue('sender_zipCode'),
    "sender_city" => getUrlParameterValue('sender_city'),

    "reciept_name" => getUrlParameterValue('reciept_name'),
    "reciept_street" => getUrlParameterValue('reciept_street'),
    "reciept_houseNo" => getUrlParameterValue('reciept_houseNo'),
    "reciept_country" => getUrlParameterValue('reciept_country'),
    "reciept_zipCode" => getUrlParameterValue('reciept_zipCode'),
    "reciept_city" => getUrlParameterValue('reciept_city'),
    "reciept_email" => getUrlParameterValue('reciept_email'),
    "saturday_delivery" => getUrlParameterValue('saturday_delivery'),
);



//$product_service_data = array(
//    'orderType' => 'consignment',
//);
//
//if($order_info["saturday_delivery"] == "true"){
//    $product_service_data = array(
//        'orderType' => 'consignment',
//        'saturdayDelivery' => true,
//    );
//
//}


$all_variables_set = true;

foreach ($order_info as $single_order_info => $value){
    if (empty($single_order_info)) {
        $all_variables_set = false;
    }
}

if ($all_variables_set){
    try {
        $dpd_auth = json_decode(get_field('dpd_auth_string', 'option'));
        $soapHeaderBody = array(
            'delisId' => $dpd_auth->return->delisId,
            'authToken' =>  $dpd_auth->return->authToken,
            'messageLanguage' => 'en_US'
        );
        $header = new SOAPHeader('http://dpd.com/common/service/types/Authentication/2.0', 'authentication', $soapHeaderBody, false);
        $client = new SoapClient('https://public-dis.dpd.nl/Services/ShipmentService.svc?singlewsdl');
        $soapHeader = $header;
        $client->__setSoapHeaders($soapHeader);

        $result = $client->storeOrders(array(
            'printOptions' => array(
                'printerLanguage' => 'PDF',
                'paperFormat' => 'A6',
                'barcodeCapable2D' => true,
                'printer' => array(
                    'offsetX' => '0',
                    'offsetY' => '0',
                    'connectionType' => 'SERIAL',
                    'barcodeCapable2D' => true,
                ),
            ),
            'order' => array(
                'generalShipmentData' => array(
                    'sendingDepot' => getDeopot($order_info["reciept_country"] , $order_info["reciept_zipCode"]),
                    'product' => 'CL',
                    'sender' => array(
                        'name1' => $order_info["sender_name"],
                        'street' => $order_info["sender_street"],
                        'houseNo' => $order_info["sender_houseNo"],
                        'country' => $order_info["sender_country"],
                        'zipCode' => $order_info["sender_zipCode"],
                        'city' => $order_info["sender_city"],
                    ),
                    'recipient' => array(
                        'name1' => $order_info["reciept_name"],
                        'name2' => '',
                        'street' => $order_info["reciept_street"],
                        'houseNo' => $order_info["reciept_houseNo"],
                        'country' => $order_info["reciept_country"],
                        'zipCode' => $order_info["reciept_zipCode"],
                        'city' => $order_info["reciept_city"],
                        'email' => $order_info["reciept_email"],
                    )
                ),
                'parcels' => array(
                        'weight' => 200
                    )
                ,'productAndServiceData' => array(
                        'orderType' => 'consignment',
                        'saturdayDelivery' => true,
                    )
                )
            )
        );

        $decoded = base64_decode($result->orderResult->parcellabelsPDF);
        $file = ''. $order_info["sender_name"] . $order_info["reciept_zipCode"] .'.pdf';


        if (getUrlParameterValue("noDownload") !== "true"){
            file_put_contents($file, $result->orderResult->parcellabelsPDF);
        }

        if (file_exists($file)) {
            if (getUrlParameterValue("noDownload") !== "true"){
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment; filename="'.$order_info["sender_name"] . $order_info["reciept_zipCode"] .'.pdf'.'"');
                echo $result->orderResult->parcellabelsPDF;
            }

            if (getUrlParameterValue("noDownload") === "true"){
                file_put_contents("wp-content/themes/order-management-theme/pdfs/". $file, $result->orderResult->parcellabelsPDF);
                echo "<script>window.close();</script>";
            }

            $packet_id = $result->orderResult->shipmentResponses->parcelInformation->parcelLabelNumber;
            $message = "
Beste ".$order_info["reciept_name"].",<br><br>

Bedankt voor uw bestelling bij ".$order_info["sender_name"]." Uw bestelling is momenteel ingepakt en zal worden opgehaald door DPD<br><br>

Zodra uw paket is opgehaald door DPD kunt u deze volgen met de volgende link:<br><br>

https://tracking.dpd.de/status/nl_NL/parcel/".$packet_id."<br>
Pakketnummer: ".$packet_id."<br><br>

Vriendelijke groeten van het ".$order_info["sender_name"]." team!
";

            if ($packet_id !== null || $packet_id !== ""){
                $mail = new PHPMailer;
                $mail->SMTPDebug = 0;
                $mail->isSMTP();
                $mail->Host = "mail.samti.nl";
                $mail->SMTPAuth = true;
                $mail->Username = "noreplay@samti.nl";
                $mail->Password = "LXE3sLKV";
                $mail->SMTPSecure = "tls";
                $mail->Port = 587;
                $mail->From = $order_info["reciept_email"];
                $mail->FromName = "Samti webshops";
                $mail->addAddress("danny@samti.nl", "Recepient Name");
                $mail->isHTML(true);
                $mail->Subject = $order_info["sender_name"] . " bestelling";
                $mail->Body = $message;
                $mail->AltBody = $message;
                $mail->smtpConnect(
                    array(
                        "ssl" => array(
                            "verify_peer" => false,
                            "verify_peer_name" => false,
                            "allow_self_signed" => true
                        )
                    )
                );
                $mail->send();
            }
            exit;
        }
    }
    catch (SoapFault $soapE) {
        if(isset($soapE->detail->authenticationFault->errorCode)
            && ($soapE->detail->authenticationFault->errorCode == 's:LOGIN_7'
                || $soapE->detail->authenticationFault->errorCode == 'LOGIN_7')) {
            echo "<h1>Auth fail request new auth<br>or seek help from Danny ;)</h1>";
        }
        else{
            echo "<br><br><br><br>Soap error<br>Seek help from Danny or read the FAQ docs<br><br>";
            var_dump($soapE);
        }
    }
}

function getDeopot($country , $zipCode){
    $dpd_auth = json_decode(get_field('dpd_auth_string', 'option'));

    $soapHeaderBody = array(
        'delisId' => $dpd_auth->return->delisId,
        'authToken' =>  $dpd_auth->return->authToken,
        'messageLanguage' => 'en_US'
    );
    $header = new SOAPHeader('http://dpd.com/common/service/types/Authentication/2.0', 'authentication', $soapHeaderBody, false);
    $client = new SoapClient('https://public-dis-stage.dpd.nl/Services/DepotDataService.svc?singlewsdl');
    $soapHeader = $header;
    $client->__setSoapHeaders($soapHeader);

    $result = $client->getDepotData(array(
        'country' => 'NL',
        'zipCode' => '7701NG',
        'depot' => ''
    ));

    return $result->DepotData->depot;
}
