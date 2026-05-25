<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    $to = "info@yourdomain.com";

    $subject = "New Website Enquiry";

    $body = "
    Name: $name

    Phone: $phone

    Message:
    $message
    ";

    $headers = "From: noreply@yourdomain.com";

    if(mail($to, $subject, $body, $headers)){

        echo "
        <script>
            alert('Message Sent Successfully');
            window.location.href='index.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Failed to Send');
            window.location.href='index.php';
        </script>
        ";
    }
}
?>