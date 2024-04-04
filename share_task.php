<?php
session_start();
// Include the connection file
require 'connection.php';

if(isset($_POST['share'])){
    $task_id = $_POST['task_id'];
    $email = $_POST['email'];

    // Get task details from the database
    $get_task_query = "SELECT * FROM tasks WHERE id = $task_id";
    $result = mysqli_query($conn, $get_task_query);
    $task = mysqli_fetch_assoc($result);

    // Send an email with the task details to the entered email address
    $to = $email;
    $subject = 'Task sharing';
    $message = 'Task: ' . $task['task_name'];
    $headers = 'From: your_email@example.com' . "\r\n" .
        'Reply-To: your_email@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers)){
        echo "Task shared successfully!";
    } else {
        echo "Error sharing task. Please try again.";
    }
}
?>
