<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require base_path('classes/PHPMailer/src/Exception.php');
require base_path('classes/PHPMailer/src/PHPMailer.php');
require base_path('classes/PHPMailer/src/SMTP.php');

global $pdo;

$token = createToken(20);

$data = get_request_data();

$email = $data['email'];

$stmt = $pdo->prepare('SELECT 1 FROM `accounts` WHERE `email` = ?');
$stmt->execute([$email]);

if (!$stmt->fetchColumn(0)) {
    send_response([
        "error" => "No account with this email found"
    ]);
}

$stmt = $pdo->prepare('UPDATE `accounts` SET `forgotten_password_token` = ?, `forgotten_password_expires` = CURRENT_TIMESTAMP() + INTERVAL 15 MINUTE WHERE `email` = ?');
$success = $stmt->execute([$token, $email]);

if (!$success) {
    send_response([
        "error" => "Something went wrong."
    ]);
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = EMAIL['host'];
    $mail->SMTPAuth = true;
    $mail->Port = EMAIL['port'];
    $mail->Username = EMAIL['username'];
    $mail->Password = EMAIL['password'];

    $mail->setFrom(EMAIL['from'], 'MyFridge');
    $mail->addAddress("$email");

    $mail->isHTML(true);
    $mail->Subject = "Reset your password";
    $mail->Body = "You can reset your password by clicking <a href='" . SITE . "reset?token=" . $token . "'>here</a>.<br/>The reset link expires in 1 day.";
    $mail->AltBody = "You can reset your password here: " . SITE . "reset?token=" . $token . " The reset link expires in 1 day.";

    $mail->send();
} catch (\Exception $e) {
    send_response([
        "error" => "There was an error sending the email."
    ], 500);
}

send_response([
    "success" => true
]);