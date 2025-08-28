# Email Setup Instructions

This document explains how to set up the email functionality for your school website.

## What's Included

We've implemented an advanced email system with:

1. **PHPMailer Integration**: Industry-standard library for sending emails
2. **SMTP Support**: More reliable than PHP's built-in mail() function
3. **Fallback Mechanism**: If SMTP fails, the system tries alternative methods
4. **HTML Emails**: Professional-looking emails with your school branding
5. **Testing Tools**: Easy-to-use scripts to verify your configuration

## Setup Steps

### Step 1: Install PHPMailer

Run one of these scripts to download PHPMailer (depending on your system):

- Windows: Double-click `install_phpmailer.bat`
- Mac/Linux: Run `bash install_phpmailer.sh` in the terminal

This will create a `vendor/phpmailer` folder with the necessary files.

### Step 2: Configure Your SMTP Settings

1. Open `smtp_config.php`
2. Update the following settings:
   - `host`: Your SMTP server (e.g., `smtp.gmail.com` for Gmail)
   - `username`: Your email address
   - `password`: Your password or app password
   - `port`: Usually 587 for TLS or 465 for SSL
   - `encryption`: 'tls' or 'ssl'
   - Other settings (from_email, school information, etc.)

### Step 3: Test Your Configuration

1. Upload all files to your web server
2. Navigate to `test_smtp.php` in your browser
3. The page will show if your SMTP connection is working
4. Click "Send Test Email" to verify the full sending process

### Gmail-Specific Instructions

If you're using Gmail, you **MUST** use an App Password:

1. Enable 2-Step Verification on your Google Account
   - Go to https://myaccount.google.com/security
   - Turn on 2-Step Verification

2. Generate an App Password
   - Go to https://myaccount.google.com/apppasswords
   - Select "Mail" and your device
   - Click "Generate"
   - Use the 16-character password in your `smtp_config.php`

## Common Issues and Solutions

### Email Not Sending

1. **Wrong SMTP Settings**: Double-check host, port, encryption
2. **Authentication Failed**: Verify username and password
3. **Missing App Password**: For Gmail, using your regular password won't work
4. **Server Restrictions**: Some hosting providers block outgoing mail

### Email Goes to Spam

1. Add proper SPF and DKIM records to your domain's DNS
2. Use a consistent sender email address
3. Avoid spam trigger words in your email subjects

## Security Considerations

1. **Keep smtp_config.php secure** - it contains your password
2. Delete `test_smtp.php` after testing in production
3. Consider moving sensitive configuration outside your web root

## Support

If you need additional help, contact:
- Email: sandeshbellale2020@gmail.com 