<?php
require_once 'mailer.php';
require_once 'smtp_config.php';

$to = $smtp_config['recipient_email'];

// Normalize POST
function post_val($key, $default = '') { return isset($_POST[$key]) ? trim($_POST[$key]) : $default; }

// Detect form type
$isTeacher = post_val('education') !== '' || post_val('experience') !== '';
$isContact = post_val('subject') !== '' || post_val('message') !== '' || post_val('email') !== '';

if (!$isTeacher && !$isContact) {
    http_response_code(400);
    echo 'Invalid form submission.';
    exit;
}

if ($isTeacher) {
    $name = post_val('name');
    $education = post_val('education');
    $age = post_val('age');
    $experience = post_val('experience');
    $contact = post_val('contact');

    $subject = "New Teacher Application: $name";
    $body = "TEACHER APPLICATION DETAILS\n\n";
    $body .= "Full Name: $name\n";
    $body .= "Education: $education\n";
    $body .= "Age: $age\n";
    $body .= "Teaching Experience (years): $experience\n";
    $body .= "Contact Number: $contact\n";

    $result = send_email($to, $subject, $body, '');
    echo $result['success'] ? 'Application sent successfully!' : 'Failed to send application. Please try again.';
    exit;
}

if ($isContact) {
    $name = post_val('name');
    $email = post_val('email');
    $subject = post_val('subject', 'New Contact Message');
    $message = post_val('message');

    $body = "CONTACT MESSAGE\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Subject: $subject\n\n";
    $body .= "Message:\n$message\n";

    $result = send_email($to, $subject, $body, $email);
    echo $result['success'] ? 'Message sent successfully!' : 'Failed to send message. Please try again.';
    exit;
}
?>


