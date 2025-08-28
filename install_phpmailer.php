<?php
// Installation script for PHPMailer

// Create vendor directory if it doesn't exist
if (!is_dir('vendor')) {
    mkdir('vendor', 0755, true);
    echo "Created vendor directory.<br>";
}

// URLs for PHPMailer files
$files = [
    'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/PHPMailer.php' => 'vendor/phpmailer/PHPMailer.php',
    'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/SMTP.php' => 'vendor/phpmailer/SMTP.php',
    'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/Exception.php' => 'vendor/phpmailer/Exception.php'
];

// Create phpmailer directory inside vendor
if (!is_dir('vendor/phpmailer')) {
    mkdir('vendor/phpmailer', 0755, true);
    echo "Created PHPMailer directory.<br>";
}

// Download each file
foreach ($files as $url => $path) {
    $content = file_get_contents($url);
    if ($content === false) {
        echo "Failed to download: $url<br>";
        continue;
    }
    
    if (file_put_contents($path, $content) === false) {
        echo "Failed to save file: $path<br>";
    } else {
        echo "Successfully downloaded: $path<br>";
    }
}

echo "<br><strong>Installation complete!</strong><br>";
echo "PHPMailer has been installed. Your email forms should now work properly.<br>";
echo "<br><a href='test_smtp.php'>Test SMTP Configuration</a>";
?> 