<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require base_path('classes/PHPMailer/src/Exception.php');
require base_path('classes/PHPMailer/src/PHPMailer.php');
require base_path('classes/PHPMailer/src/SMTP.php');

global $pdo;

$data = get_request_data();

$firstName = htmlspecialchars($data['firstName']);
$lastName = htmlspecialchars($data['lastName']);
$email = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
$phoneNumber = htmlspecialchars($data['phoneNumber']);
$password = $data['password'];

$stmt = $pdo->prepare("SELECT 1 FROM `accounts` WHERE `email` = ?");
$stmt->execute([$email]);

if (count($stmt->fetchAll()) > 0)
    // FIXME: Potentially allows people to attack emails they know are in use?
    send_response([
        "error" => "Email is already in use.",
        "field" => "email"
    ], 500);

$password = password_hash($password, PASSWORD_BCRYPT);
$token = createToken(20);

try {
    $stmt = $pdo->prepare("INSERT INTO `accounts` (`first_name`, `last_name`, `email`, `password`, `phone_number`, `registration_token`) VALUES (?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([$firstName, $lastName, $email, $password, $phoneNumber, $token]);

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '7b824115aa42ea';
        $mail->Password = 'abebc6ba1b5515';

        $mail->setFrom('myfridge@oo.com', 'MyFridge');
        $mail->addAddress("$email");

        $mail->isHTML(true);
        $mail->Subject = "Activate your account.";
        $mail->Body = "You can activate your account by clicking <a href='" . SITE . "verify?token=" . $token . "'>here</a>.<br/>The activation link expires in 1 day.";
        $mail->AltBody = "You can activate your account here: " . SITE . "verify?token=" . $token . " The activation link expires in 1 day.";

        $mail->send();

//      TODO: Create verify.php to verify members
    } catch (\Exception $e) {
        send_response([
            "error" => "There was an error sending the email."
        ], 500);
    }

    send_response([
        "success" => true
    ]);
} catch (PDOException $exception) {
    send_response([
        "error" => "Something went wrong while creating the account.",
    ], 500);
}
