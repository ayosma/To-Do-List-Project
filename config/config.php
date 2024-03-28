<?php
ob_start();
session_start();
$con = mysqli_connect("localhost:3307", "root", "", "taskkeeper");

if(mysqli_connect_errno()){
	echo "Failed to connect: " . mysqli_connect_errno();
	exit();
}
?>