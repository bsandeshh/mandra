<?php
// Include the mailer helpers
require_once 'mailer.php';

// Collect form data
$gname = isset($_POST['gname']) ? $_POST['gname'] : '';
$gmail = isset($_POST['gmail']) ? $_POST['gmail'] : '';
$cname = isset($_POST['cname']) ? $_POST['cname'] : '';
$cage = isset($_POST['cage']) ? $_POST['cage'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Get recipient email from config
require_once 'smtp_config.php';
$to = $smtp_config['recipient_email'];

// Set email subject
$subject = "New Appointment Request from $gname";

// Email body
$body = "Guardian Name: $gname\n";
$body .= "Guardian Email: $gmail\n";
$body .= "Child Name: $cname\n";
$body .= "Child Age: $cage\n";
$body .= "Message:\n$message\n";

// Try to send email using SMTP
$result = send_email($to, $subject, $body, $gmail);

// If successful, show success message
if ($result['success']) {
    echo "Appointment request sent successfully! We'll contact you soon.";
} else {
    // Try the fallback method
    $headers = "From: " . $smtp_config['from_email'] . "\r\n";
    $headers .= "Reply-To: $gmail" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    if (send_mail_fallback($to, $subject, $body, $headers)) {
        echo "Appointment request sent successfully! We'll contact you soon.";
    } else {
        echo "Failed to send appointment request. Please try again or contact us directly.";
    }
}
?> 