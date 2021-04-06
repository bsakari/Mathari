<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pay</title>
    <script src="dists/sweetalert.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="dists/sweetalert.css">
</head>
<body class="pay_main_body">
    <div class="pay">
        <form action="index.php?pay" class="was-validated" method="post">
            <div class="form-group">
                <label for="phonenumber">PHONE NUMBER:</label>
                <input type="text" class="form-control" id="phonenumber" placeholder="Enter Phone Number" name="phonenumber"
                       required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field. Start with 2547...</div>
            </div>

            <div class="form-group">
                <label for="amount">AMOUNT:</label>
                <input type="text" class="form-control" id="amount" placeholder="Enter Amount" name="amount" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field. Don't start with Ksh.</div>
            </div>

            <div class="form-group">
                <label for="description">PAYING FOR?:</label>
                <input type="text" class="form-control" id="description" placeholder="Enter Description" name="description" required>
                <div class="valid-feedback">Valid.</div>
                <div class="invalid-feedback">Please fill out this field.</div>
            </div>

            <button type="submit" class="btn btn-primary btn-block" onclick="loading();" name="pay">DONATE</button>
        </form>
        <!--    Loading spinner start-->
        <div id="divloading">
            <!-- This div displays the loading spinner  -->
        </div>
    </div>

    <script>
        function loading() {
            var phonenumber = document.getElementById('phonenumber').value;
            var amount = document.getElementById('amount').value;
            var description = document.getElementById('description').value;
            if ((phonenumber == "") || (amount == "") || (description == "")) {

            }else {
                document.getElementById('divloading').innerHTML ='<div class="spinner-grow text-success"></div> \n'+'<p>Loading...</p>';
            }
        }
    </script>
<!--    Loading spinner end-->

    <?php
    //        error_reporting(E_ALL);
    //        ini_set('display_errors', 1);
    if (!isset($_GET['pay'])){
        header("location:home.php");
        exit();
    }

    if (isset($_POST['pay'])){
        require __DIR__."/vendor/autoload.php";
        $mpesa= new \Safaricom\Mpesa\Mpesa();
        $BusinessShortCode="174379";
        $LipaNaMpesaPasskey="bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $TransactionType="CustomerPayBillOnline";
        $Amount=$_POST['amount'];
        $PartyA=$_POST['phonenumber'];
        $PartyB="174379";
        $PhoneNumber=$_POST['phonenumber'];
        $CallBackURL="https://214e1f82.ngrok.io/mathari/callBack.php";
        $AccountReference="Fee Payment 1";
        $TransactionDesc=$_POST['description'];
        $Remarks="Fee Payment 3";
        $stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode,$LipaNaMpesaPasskey, $TransactionType, $Amount, $PartyA, $PartyB, $PhoneNumber, $CallBackURL, $AccountReference, $TransactionDesc, $Remarks);
        //var_dump($stkPushSimulation);
        $json = json_decode($stkPushSimulation);
        $state = $json->ResponseCode;
        //        echo "<br>";
        //        echo $json->ResponseCode;
        //        echo "<br>";
        //        echo $json->CheckoutRequestID;
        //        echo "<br>";
        //        echo $TransactionDesc;
        //        echo "<br>";
        //        echo var_dump($json->ResponseCode);


        //Connect to DB
        $conn = mysqli_connect("localhost","root","hp101","payments");
        //Check if the response code is 0
        if ($state==="0"){
            //Save the CheckoutRequestID and TransactionDesc
            $insert = "INSERT INTO `transactions`(`id`, `dbCheckoutRequestID`, `dbTransactionDesc`) VALUES (null ,'$json->CheckoutRequestID','$TransactionDesc')";
            mysqli_query($conn,$insert);
            //Display the success message
            echo "
                <script>
                    swal({
                        title:'Success!', 
                        text: 'Check your phone to enter pin!', 
                        type:'success',
                        confirmButtonClass: 'btn btn-success',
                        confirmButtonText: 'Ok',
                    },function() {
                        window.location.href='home.php';
                      
                    });
                </script>
            ";
        }else{
            echo "
                <script>
                    sweetAlert({
                        title:'Failed!', 
                        text: 'Please check your phone and try again!', 
                        type:'error',
                        confirmButtonClass: 'btn btn-danger',
                        confirmButtonText: 'Ok',
                    },function() {
                        window.location.href='home.php';
                      
                    });
                </script>
            ";
        }

    }
    ?>
</body>
<!--    Local bootstrap libraries-->
<script src="bootstrap/js/jquery-3.4.0.js"></script>
<script src="bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<!--    Online bootstrap-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/custom.css">

</html>