<?php
// SMTP Configuration
$smtp_config = [
    // SMTP Server Settings - CHANGE THESE TO YOUR SMTP PROVIDER
    'host' => 'smtp.gmail.com',           // SMTP server (e.g., smtp.gmail.com, smtp.office365.com)
    'username' => 'sandeshbellale2020@gmail.com', // Your email address
    'password' => 'dnoa ekvg xlmm otip',    // Your app password for Gmail
    'port' => 587,                        // SMTP port (usually 587 for TLS, 465 for SSL)
    'encryption' => 'tls',                // Encryption type: 'tls' or 'ssl'
    
    // Email Settings
    'from_email' => 'sandeshbellale2020@gmail.com', // Sender email address
    'from_name' => 'Manjara International School',   // Sender name
    'reply_to' => 'sandeshbellale2020@gmail.com',    // Reply-to address
    
    // Recipient Email
    'recipient_email' => 'manjaraschool@gmail.com',  // Main recipient address
    
    // School Information
    'school_name' => 'Manjara International School',
    'school_website' => 'https://mis.edu.in',        // Your school website
    'school_phone' => '+91 9175518919',              // School phone number
    'school_address' => 'Khadgaon-Pakharsangvi Road, Latur' // School address
];

/*
IMPORTANT NOTES:

1. Gmail Users:
   - You MUST use an "App Password" instead of your regular Gmail password
   - To create an App Password:
     a. Enable 2-Step Verification on your Google Account
     b. Go to https://myaccount.google.com/apppasswords
     c. Select "Mail" and your device, then generate
     d. Copy the 16-character password and use it here

2. Other Email Providers:
   - Outlook/Office365: smtp.office365.com, port 587
   - Yahoo: smtp.mail.yahoo.com, port 587
   - Hotmail: smtp.live.com, port 587
   - AOL: smtp.aol.com, port 587

3. Security:
   - Keep this file secure and don't expose it publicly
   - Consider placing it outside your web root if possible
*/
?> 