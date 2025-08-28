<?php
// Include PHPMailer classes
require 'vendor/phpmailer/PHPMailer.php';
require 'vendor/phpmailer/SMTP.php';
require 'vendor/phpmailer/Exception.php';
require 'smtp_config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Function to send email using PHPMailer and SMTP
 * 
 * @param string $to Recipient email address
 * @param string $subject Email subject
 * @param string $body Email body (can be HTML)
 * @param string $reply_to Reply-to email address (optional)
 * @param array $attachments Array of file paths to attach (optional)
 * @return array ['success' => bool, 'message' => string]
 */
function send_email($to, $subject, $body, $reply_to = '', $attachments = []) {
    global $smtp_config;
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Uncomment for debugging
        $mail->isSMTP();
        $mail->Host       = $smtp_config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_config['username'];
        $mail->Password   = $smtp_config['password'];
        $mail->SMTPSecure = $smtp_config['encryption'];
        $mail->Port       = $smtp_config['port'];
        
        // Recipients
        $mail->setFrom($smtp_config['from_email'], $smtp_config['from_name']);
        $mail->addAddress($to);
        
        // Set reply-to address
        if (!empty($reply_to)) {
            $mail->addReplyTo($reply_to);
        } else {
            $mail->addReplyTo($smtp_config['reply_to']);
        }
        
        // Attachments
        if (!empty($attachments) && is_array($attachments)) {
            foreach ($attachments as $attachment) {
                if (file_exists($attachment)) {
                    $mail->addAttachment($attachment);
                }
            }
        }
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        
        // Format body as HTML with school branding
        $htmlBody = '
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background-color: #0d6efd; color: #fff; padding: 20px; text-align: center; }
                .content { padding: 20px; background: #f9f9f9; }
                .footer { font-size: 12px; text-align: center; margin-top: 20px; color: #777; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h2>' . $smtp_config['school_name'] . '</h2>
                </div>
                <div class="content">
                    ' . nl2br($body) . '
                </div>
                <div class="footer">
                    <p>
                        ' . $smtp_config['school_name'] . '<br>
                        ' . $smtp_config['school_address'] . '<br>
                        Phone: ' . $smtp_config['school_phone'] . '<br>
                        <a href="' . $smtp_config['school_website'] . '">' . $smtp_config['school_website'] . '</a>
                    </p>
                </div>
            </div>
        </body>
        </html>';
        
        $mail->Body = $htmlBody;
        $mail->AltBody = strip_tags(str_replace('<br>', "\n", $body)); // Plain text version
        
        // Send the email
        $mail->send();
        
        return [
            'success' => true,
            'message' => 'Email sent successfully!'
        ];
        
    } catch (Exception $e) {
        return [
            'success' => false,
            'message' => "Email could not be sent. Mailer Error: {$mail->ErrorInfo}",
            'error_details' => $mail->ErrorInfo
        ];
    }
}

/**
 * Function to test the SMTP configuration
 * Returns true if successful, false otherwise
 */
function test_smtp_connection() {
    global $smtp_config;
    
    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = $smtp_config['host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $smtp_config['username'];
        $mail->Password   = $smtp_config['password'];
        $mail->SMTPSecure = $smtp_config['encryption'];
        $mail->Port       = $smtp_config['port'];
        
        // Just testing connection, not actually sending
        $mail->SMTPDebug = SMTP::DEBUG_CONNECTION;
        
        // Start the connection but don't send
        ob_start();
        $result = $mail->smtpConnect();
        ob_end_clean();
        
        return $result;
    } catch (Exception $e) {
        return false;
    }
}

// Fallback to standard mail() function if SMTP fails
function send_mail_fallback($to, $subject, $body, $headers) {
    return mail($to, $subject, $body, $headers);
}
?> 