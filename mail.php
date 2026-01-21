<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name    = trim($_POST["name"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    if ($name === "" || $email === "" || $subject === "" || $message === "") {
        exit("All fields are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit("Invalid email");
    }

    // 👇 WHERE YOU RECEIVE EMAILS
    $recipient = "noorbutthere160@gmail.com";

    // 👇 SENT FROM YOUR DOMAIN
    $headers  = "From: Noor Butt Website <contact@noorbutt.pro>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $body  = "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message";

    if (mail($recipient, $subject, $body, $headers)) {
        echo "Message sent successfully";
    } else {
        echo "Mail sending failed";
    }
}
?>
