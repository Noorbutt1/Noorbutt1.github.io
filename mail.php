<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    // Basic input handling
    $name    = trim($_POST["name"] ?? "");
    $email   = trim($_POST["email"] ?? "");
    $subject = trim($_POST["subject"] ?? "");
    $message = trim($_POST["message"] ?? "");

    // Validation
    if ($name === "" || $email === "" || $subject === "" || $message === "") {
        http_response_code(400);
        exit("All fields are required");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        exit("Invalid email");
    }

    // Sanitize to prevent header injection
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $name = preg_replace('/[^\p{L}\p{N}\s-]/u', '', $name);
    $subject = preg_replace('/[\r\n]/', '', $subject);

    $recipient = "noorbutthere160@gmail.com";
    
    $headers  = "From: Noor Butt Website <contact@noorbutt.pro>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    $body  = "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message";

    if (mail($recipient, $subject, $body, $headers)) {
        http_response_code(200);
        echo "Message sent successfully";
    } else {
        http_response_code(500);
        error_log("Mail failed for: $email"); // Log for debugging
        echo "Mail sending failed";
    }
}
?>