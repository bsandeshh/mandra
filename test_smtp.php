<?php
// Include the mailer helpers
require_once 'mailer.php';

// Test connection first
echo "<h2>Testing SMTP Connection</h2>";
if (test_smtp_connection()) {
    echo "<p style='color:green'>✓ SMTP Connection successful! Your settings appear to be correct.</p>";
} else {
    echo "<p style='color:red'>✗ SMTP Connection failed. Please check your settings in smtp_config.php.</p>";
    echo "<p>Common issues:</p>";
    echo "<ul>";
    echo "<li>Incorrect username or password</li>";
    echo "<li>Using Gmail without an app password</li>";
    echo "<li>Incorrect SMTP server or port</li>";
    echo "<li>Firewall blocking outgoing SMTP connections</li>";
    echo "</ul>";
}

// Only try to send a test email if prompted
if (isset($_GET['send_test']) && $_GET['send_test'] == '1') {
    echo "<h2>Sending Test Email</h2>";
    
    $to = $smtp_config['recipient_email']; // Will be sent to recipient
    $subject = "SMTP Test Email from School Website";
    $body = "This is a test email to verify your SMTP configuration is working correctly.\n\n";
    $body .= "If you're seeing this, congratulations! Your email setup is working!";
    
    $result = send_email($to, $subject, $body);
    
    if ($result['success']) {
        echo "<p style='color:green'>✓ Test email sent successfully!</p>";
        echo "<p>A test email has been sent to: $to</p>";
    } else {
        echo "<p style='color:red'>✗ Test email failed to send.</p>";
        echo "<p>Error: " . $result['message'] . "</p>";
        
        if (isset($result['error_details'])) {
            echo "<p>Detailed error: " . $result['error_details'] . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMTP Configuration Test</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #f9f9f9; padding: 20px; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { color: #0d6efd; text-align: center; }
        .btn { display: inline-block; background: #0d6efd; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; margin-top: 20px; }
        .btn:hover { background: #0b5ed7; }
        .section { margin-bottom: 20px; padding: 15px; background: white; border-radius: 4px; }
        pre { background: #f1f1f1; padding: 10px; border-radius: 4px; overflow-x: auto; }
        .warning { background: #fff3cd; border-left: 4px solid #ffc107; padding: 10px; margin: 15px 0; }
        .info { background: #cfe2ff; border-left: 4px solid #0d6efd; padding: 10px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>SMTP Configuration Test</h1>
        
        <div class="section">
            <h2>Your Current SMTP Configuration</h2>
            <pre>
Host: <?php echo $smtp_config['host']; ?>
Username: <?php echo $smtp_config['username']; ?>
Password: <?php echo str_repeat('*', strlen($smtp_config['password'])); ?>
Port: <?php echo $smtp_config['port']; ?>
Encryption: <?php echo $smtp_config['encryption']; ?>
            </pre>
            
            <div class="warning">
                <strong>Important:</strong> If you're using Gmail, make sure you're using an app password, not your regular password.
                <a href="https://myaccount.google.com/apppasswords" target="_blank">Create an app password here</a>.
            </div>
        </div>
        
        <div class="section">
            <h2>Next Steps</h2>
            
            <?php if (!isset($_GET['send_test'])): ?>
                <p>Click the button below to send a test email to yourself (<?php echo $smtp_config['username']; ?>):</p>
                <a href="?send_test=1" class="btn">Send Test Email</a>
            <?php else: ?>
                <p>Test completed. <a href="test_smtp.php">Run another test</a></p>
            <?php endif; ?>
            
            <div class="info">
                <p><strong>Remember:</strong> After testing, make sure to secure this file or delete it from your production server.</p>
            </div>
        </div>
    </div>
</body>
</html> 