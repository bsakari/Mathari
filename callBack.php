<?php
require 'config.php';
//Callback DATA from MPESA
$callbackResponse = file_get_contents('php://input');

//Write to file
$logFile = "CallbackResponse.json";
$log = fopen($logFile,"a");
fwrite($log,$callbackResponse."\n");
fclose($log);

$json = json_decode($callbackResponse);

$CheckoutRequestID = $json->Body->stkCallback->CheckoutRequestID;
$ResultCode = $json->Body->stkCallback->ResultCode;
$CallbackMetadata = $json->Body->stkCallback->CallbackMetadata;

$Amount = 0;
$MpesaReceiptNumber = "";
$PhoneNumber = "";
$TransactionDate = "";
foreach ($CallbackMetadata->Item as $item){

    if ($item->Name=="Amount"){
        $Amount=$item->Value;
    }
    else if ($item->Name=="MpesaReceiptNumber"){
        $MpesaReceiptNumber=$item->Value;
    }
    else if ($item->Name=="PhoneNumber"){
        $PhoneNumber=$item->Value;
    }
    else if ($item->Name=="TransactionDate"){
        $TransactionDate=$item->Value;
    }

}

//echo $CheckoutRequestID."\n".$MpesaReceiptNumber."\n".$ResultCode."\n".$Amount."\n".$PhoneNumber."\n".$TransactionDate."\n";
insert_response($CheckoutRequestID,$MpesaReceiptNumber,$ResultCode,$Amount,$PhoneNumber,$TransactionDate);
?>