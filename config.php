<?php
function insert_response($CheckoutRequestID,$MpesaReceiptNumber,$ResultCode,$Amount,$PhoneNumber,$TransactionDate){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "payments";


    $conn = mysqli_connect($servername,$username,$password,$db);
    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
      }else{
        //Check existence of CheckoutRequestID in the db
        $selectQuery = "SELECT dbCheckoutRequestID FROM transactions WHERE dbCheckoutRequestID='$CheckoutRequestID'";
        $data = $conn->query($selectQuery);
        if (mysqli_num_rows($data)>0){
            //Update transaction where dbCheckoutRequestID='$CheckoutRequestID'
            $updateQuery = "UPDATE `transactions` SET `dbCheckoutRequestID`='$CheckoutRequestID',`dbMpesaReceiptNumber`='$MpesaReceiptNumber',`dbResultCode`='$ResultCode',`dbAmount`='$Amount',`dbPhoneNumber`='$PhoneNumber',`dbTransactionDate`='$TransactionDate' WHERE dbCheckoutRequestID='$CheckoutRequestID'";
            $update = $conn->query($updateQuery);
            if ($update){
                echo "Success";
            }else{
                $errLog = fopen('errors.txt','a');
                fwrite($errLog,"\n\nFailed to update the transaction\n");
                fclose($errLog);

                //Log failed transactions
                $FailedTransaction = $CheckoutRequestID."\n".$MpesaReceiptNumber."\n".$ResultCode."\n".$Amount."\n".$PhoneNumber."\n".$TransactionDate."\n\n";

                $logFailedTransaction = fopen('failedTransaction.txt','a');
                fwrite($logFailedTransaction,$FailedTransaction);
                fclose($logFailedTransaction);
            }
        }
    }

    function conn(){
        $servername = "localhost";
        $username = "root";
        $password = "hp101";
        $db = "payments";

        $conn = mysqli_connect($servername,$username,$password,$db);
        if (!$conn){
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    $conn->close();
}
?>