<?php
/**
 * Template Name: Get dpd tracking
 *
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

include("templates/login_redirecter");
try {
    $dpd_auth = json_decode(get_field('dpd_auth_string', 'option'));

    $soapHeaderBody = array(
        'delisId' => $dpd_auth->return->delisId,
        'authToken' =>  $dpd_auth->return->authToken,
        'messageLanguage' => 'en_US'
    );

    echo "<br><br><br><br><br><br>";
    var_dump($soapHeaderBody);

    $header = new SOAPHeader('http://dpd.com/common/service/types/Authentication/2.0', 'authentication', $soapHeaderBody, false);

    $client = new SoapClient('https://public-dis.dpd.nl/Services/ParcelLifeCycleService.svc?singlewsdl');
//        $client= new SoapClient('https://public-dis-stage.dpd.nl/Services/ShipmentService.svc?singlewsdl');
    $soapHeader = $header;
    $client->__setSoapHeaders($soapHeader);

    $id = getUrlParameterValue('id');
    echo $id;

    $result = $client->getTrackingData(array(
            'parcelLabelNumber' => $id
        )
    );

    echo "<br><br><br><br><br><br>";
    var_dump($result);

}
catch (SoapFault $soapE)
{

    if(isset($soapE->detail->authenticationFault->errorCode)
        && ($soapE->detail->authenticationFault->errorCode == 's:LOGIN_7'
            || $soapE->detail->authenticationFault->errorCode == 'LOGIN_7'))
    {
        echo "<h1>Auth fail request new auth<br>or seek help from Danny ;)</h1>";
    }
    else
    {
        echo "<br><br><br><br>Soap error<br>Seek help from Danny or read the FAQ docs<br><br>";
        var_dump($soapE);
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
//    $client = new SoapClient('https://public-dis.dpd.nl/Services/ParcelShopFinderService.svc?singlewsdl');

    $soapHeader = $header;
    $client->__setSoapHeaders($soapHeader);

    $result = $client->getDepotData(array(
        'country' => 'NL',
        'zipCode' => '7701NG',
        'depot' => ''
    ));

    return $result->DepotData->depot;
}