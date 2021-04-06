<?php
session_start();
if (!isset($_SESSION['email'])){
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaction Details</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container mt-3">
    <input class="form-control" id="myInput" type="text" placeholder="Search..">
    <br>
    <table class="table table-bordered table-dark table-hover">
        <thead>
        <tr>
            <th>Receipt Number</th>
            <th>Amount</th>
            <th>Phone Number</th>
            <th>Date</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody id="myTable">
        <?php
            require 'conn.php';
            $select_query = "SELECT * FROM transactions WHERE dbMpesaReceiptNumber !=''";
            $select_transactions = mysqli_query($conn,$select_query);
            while ($row = mysqli_fetch_assoc($select_transactions)){
                extract($row);
                echo "
                    <tr>
                        <td>$dbMpesaReceiptNumber</td>
                        <td>$dbAmount</td>
                        <td>$dbPhoneNumber</td>
                        <td>$dbTransactionDate</td>
                        <td>$dbTransactionDesc</td>
                    </tr>
                ";
            }
        ?>
        </tbody>
    </table>

</div>

<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>

</body>
</html>
