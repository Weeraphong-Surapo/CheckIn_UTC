<?php 
ini_set('display_errors',1);
error_reporting( E_ALL );

$form = "checkinutc2022@bigshop.world";
$to = "weeraphong61045@gmail.com";

$subject = "test mail";
$message = "test mail";
$headers = "FORM : ".$form;
mail($to,$subject,$message,$headers);
?>