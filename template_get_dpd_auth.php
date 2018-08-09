<?php
/**
 * Template Name: get dpd login
 *
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

include("templates/login_redirecter");

$data = file_get_contents("wp-content/themes/order-management-theme/data.json");
$data = json_decode($data, true);

$field_key = "field_5b28f1d0dfab9";

$client = new SoapClient('https://public-dis.dpd.nl/Services/LoginService.svc?singlewsdl');
$result = $client->getAuth(array(
    'delisId' => $data["delisId"],
    'password' => $data["delisPassword"],
    'messageLanguage' =>'en_US'
));

?>

<div>
<pre>
Je hebt een nieuwe DPD auth string aangevraagd en deze is automatisch opgeslagen in het systeem.
Je kunt nu weer DPD labels aanmaken met de nieuwe auths string

let op!
elke keer als je deze pagina refreshed wordt er een nieuwe DPD auth aangevraagd,
DPD wil veel requests voorkomen dus probeer deze pagina niet meer dan 2x per dag te refreshen.
Zijn er problemen? neem dan even contact op met een van de developers


De volgende text is debug text:

</pre>
</div>

<?php

echo "old value: <br><br>";
echo get_field($field_key , "option");

update_field($field_key , json_encode($result) , "option");

echo "<br><br><br><br>New value: <br>";
echo get_field($field_key , "option");