<?php
// mail.php - Server-side email handler
header('Content-Type: application/json');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Get form data
    $name = trim($_POST['contact-name'] ?? '');
    $phone = trim($_POST['contact-phone'] ?? '');
    $email = trim($_POST['contact-email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['contact-message'] ?? '');
    
    // Validation
    $errors = [];
    
    if (empty($name)) {
        echo json_encode(['code' => false, 'field' => 'contact-name', 'err' => 'Name is required']);
        exit;
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['code' => false, 'field' => 'contact-email', 'err' => 'Valid email is required']);
        exit;
    }
    
    if (empty($message)) {
        echo json_encode(['code' => false, 'field' => 'contact-message', 'err' => 'Message is required']);
        exit;
    }
    
    // Your Gmail address where you want to receive messages
    $to = "damirrahymberdi662@gmail.com"; // Replace with your actual Gmail
    
    // Email subject
    $email_subject = "New Contact Form Message: " . $subject;
    
    // Email body
    $email_body = "
    New contact form submission:
    
    Name: $name
    Phone: $phone
    Email: $email
    Subject: $subject
    
    Message:
    $message
    
    ---
    This message was sent from your portfolio contact form.
    ";
    
    // Email headers
    $headers = [
        'From: ' . $email,
        'Reply-To: ' . $email,
        'X-Mailer: PHP/' . phpversion(),
        'Content-Type: text/plain; charset=UTF-8'
    ];
    
    // Send email
    if (mail($to, $email_subject, $email_body, implode("\r\n", $headers))) {
        echo json_encode(['code' => true, 'success' => 'Thank you! Your message has been sent successfully.']);
    } else {
        echo json_encode(['code' => false, 'field' => 'general', 'err' => 'Sorry, there was an error sending your message. Please try again.']);
    }
    
} else {
    echo json_encode(['code' => false, 'field' => 'general', 'err' => 'Invalid request method']);
}
?>