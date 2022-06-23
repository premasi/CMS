<?php 
ob_start();
session_start();

$_SESSION['user_id'] = null;

header("location: /course/CMS/index");


?>