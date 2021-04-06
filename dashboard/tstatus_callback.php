<?php
//Callback DATA from MPESA
$callbackResponse = file_get_contents('php://input');

//Write to file
$logFile = "tStatusCallbackResponse.json";
$log = fopen($logFile,"a");
fwrite($log,$callbackResponse."\n");
fclose($log);