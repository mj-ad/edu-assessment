<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/Config.php';


class Mailer
{
    public static function sendWelcome(string $toEmail, string $toName, string $regNo): bool
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = Config::MAIL_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = Config::MAIL_USER;
            $mail->Password = Config::MAIL_PASS;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = Config::MAIL_PORT;


            $mail->setFrom(Config::MAIL_FROM, Config::MAIL_FROM_NAME);
            $mail->addAddress($toEmail, $toName);


            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Our School';
            $mail->Body = '<p>Dear ' . htmlspecialchars($toName) . ',</p>' .
                '<p>Welcome! Your registration number is <strong>' . htmlspecialchars($regNo) . '</strong>.</p>' .
                '<p>Best regards,<br>Admin</p>';


            return $mail->send();
        } catch (Exception $e) {
            error_log('Mail error: ' . $e->getMessage());
            return false;
        }
    }
}
