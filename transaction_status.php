<?php
require __DIR__."/vendor/autoload.php";
$mpesa= new \Safaricom\Mpesa\Mpesa();

$Initiator = "testapi";
$SecurityCredential="AuT0LqK2YR0y1G8M8aQ7ETAQNnS+AmCyEa9EoKGrSFV+kKO9U1Syc9prtHSogQzFPNarWNi84rCs4jadG3dg6Yau+ySYr44NJARrincp2UaOCcRDvHNA+F21PGpa3gY8Twzs7UXKqw5KN5OEH7QpsAI3xcSvNfzPp532/OZVIeTfczRC7c+sSr2KIxr5he4o3nPEsAqp4e/SCucsOp9zo/yfcq9WS+F0qqbBq0vCqJy4PQJp7n7p0BPN9J7xI0gM2PLr8VECz/l8dSXBo11CIlehyLrwGWrJv0vsMI6mG01EPDYdJ7m3rEEJk/MWfaaU9q7Nt2BtJnzNattkNC39Vw==";
$CommandID = "TransactionStatusQuery";
$TransactionID = "NIJ8OdMI2HK";
$PartyA = "600183";
$IdentifierType = "4";
$ResultURL = "https://a1c762cb.ngrok.io/mpesa_api_code/tStatusCallBack.php";
$QueueTimeOutURL = "https://a1c762cb.ngrok.io/mpesa_api_code/tStatusCallBack.php";
$Remarks = "King1234";
$Occasion = "mzae5";



$trasactionStatus=$mpesa->transactionStatus($Initiator, $SecurityCredential, $CommandID, $TransactionID, $PartyA, $IdentifierType, $ResultURL, $QueueTimeOutURL, $Remarks, $Occasion);
var_dump($trasactionStatus);
?>