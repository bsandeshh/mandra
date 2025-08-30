<?php
// Include the mailer helpers
require_once 'mailer.php';
require_once 'supabase.php';

// Collect form data
$email = isset($_POST['email']) ? $_POST['email'] : '';

// Get recipient email from config
require_once 'smtp_config.php';
$to = $smtp_config['recipient_email'];

// Set email subject
$subject = "New Newsletter Subscription";

// Email body
$body = "New newsletter subscription request from: $email\n";
$body .= "Please add this email to your newsletter list.\n";

// Log to Supabase (best-effort)
try {
    $sb = supabase_client();
    $payload = [
        'email' => $email,
        'submitted_at' => date('c')
    ];
    $sb->insert('newsletter_subscriptions', $payload);
} catch (\Throwable $e) {
}

// Try to send email using SMTP
$result = send_email($to, $subject, $body, $email);

// If successful, show success message
if ($result['success']) {
    echo "Subscription request sent successfully!";
} else {
    // Try the fallback method
    $headers = "From: " . $smtp_config['from_email'] . "\r\n";
    $headers .= "Reply-To: $email" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    if (send_mail_fallback($to, $subject, $body, $headers)) {
        echo "Subscription request sent successfully!";
    } else {
        echo "Failed to send subscription request. Please try again or contact us directly.";
    }
}
?> 