<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{	
    $username = $_POST["username"];
    $password = $_POST["password"];

    echo "You've created your account";
} 
else 
{
    echo "Error: Form not submitted.";
}
?>