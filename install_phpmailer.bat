@echo off
echo Installing PHPMailer...

:: Create directories
mkdir vendor\phpmailer 2>nul

:: Download PHPMailer files
echo Downloading PHPMailer files...
powershell -Command "& {Invoke-WebRequest -Uri 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/PHPMailer.php' -OutFile 'vendor\phpmailer\PHPMailer.php'}"
powershell -Command "& {Invoke-WebRequest -Uri 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/SMTP.php' -OutFile 'vendor\phpmailer\SMTP.php'}"
powershell -Command "& {Invoke-WebRequest -Uri 'https://raw.githubusercontent.com/PHPMailer/PHPMailer/v6.8.0/src/Exception.php' -OutFile 'vendor\phpmailer\Exception.php'}"

:: Check if files were downloaded
if exist vendor\phpmailer\PHPMailer.php (
    echo PHPMailer installed successfully!
    echo Now you can test your email functionality.
) else (
    echo Failed to download PHPMailer files. Please check your internet connection.
)

pause 