<?php
// Include the mailer helpers
require_once 'mailer.php';

// Collect form data
$fullName = isset($_POST['fullName']) ? $_POST['fullName'] : '';
$age = isset($_POST['age']) ? $_POST['age'] : '';
$motherName = isset($_POST['motherName']) ? $_POST['motherName'] : '';
$religion = isset($_POST['religion']) ? $_POST['religion'] : 'Not provided';
$motherTongue = isset($_POST['motherTongue']) ? $_POST['motherTongue'] : '';
$dob = isset($_POST['dob']) ? $_POST['dob'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$classToJoin = isset($_POST['classToJoin']) ? $_POST['classToJoin'] : '';
$previousSchool = isset($_POST['previousSchool']) ? $_POST['previousSchool'] : 'Not provided';
$contactNumber = isset($_POST['contactNumber']) ? $_POST['contactNumber'] : '';

// Get recipient email from config
require_once 'smtp_config.php';
$to = $smtp_config['recipient_email'];

// Set email subject
$subject = "New Admission Application: $fullName";

// Email body
$body = "ADMISSION APPLICATION DETAILS\n\n";
$body .= "Full Name: $fullName\n";
$body .= "Age: $age\n";
$body .= "Mother's Name: $motherName\n";
$body .= "Religion: $religion\n";
$body .= "Mother Tongue: $motherTongue\n";
$body .= "Date of Birth: $dob\n";
$body .= "Address: $address\n";
$body .= "Class to Join: $classToJoin\n";
$body .= "Previous School: $previousSchool\n";
$body .= "Contact Number: $contactNumber\n";

// Try to send email using SMTP
$result = send_email($to, $subject, $body, $contactNumber);

// If successful, show success message
if ($result['success']) {
    echo "Admission application submitted successfully! We'll contact you soon.";
} else {
    // Try the fallback method
    $headers = "From: " . $smtp_config['from_email'] . "\r\n";
    $headers .= "Reply-To: $contactNumber" . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    if (send_mail_fallback($to, $subject, $body, $headers)) {
        echo "Admission application submitted successfully! We'll contact you soon.";
    } else {
        echo "Failed to submit application. Please try again or contact us directly.";
    }
}
?> 