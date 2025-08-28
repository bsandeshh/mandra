#!/bin/bash

# Create necessary directories
mkdir -p vendor/phpmailer

# Download PHPMailer files
echo "Downloading PHPMailer files..."
curl -s https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/PHPMailer.php -o vendor/phpmailer/PHPMailer.php
curl -s https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/SMTP.php -o vendor/phpmailer/SMTP.php
curl -s https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/Exception.php -o vendor/phpmailer/Exception.php

# Check if files were downloaded successfully
if [ -f vendor/phpmailer/PHPMailer.php ] && [ -f vendor/phpmailer/SMTP.php ] && [ -f vendor/phpmailer/Exception.php ]; then
    echo "PHPMailer installed successfully!"
    echo "Now you can test your email functionality."
else
    echo "Failed to download some PHPMailer files. Please check your internet connection."
fi 