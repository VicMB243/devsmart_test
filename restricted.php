<?php

$id =  $_COOKIE['auth_id'];
$email = $_COOKIE['auth_email'];

$sql = "SELECT user_id FROM users WHERE user_id='$id' AND email='$email'";
$result = mysqli_query($link,$sql);

if (mysqli_num_rows($result)==0)
{
    echo "Unauthorized access!";
    exit;
}


?>