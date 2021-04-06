<?php
$conn = mysqli_connect("localhost","root","","payments");
if (!$conn){
    echo "Connection Failed";
}
