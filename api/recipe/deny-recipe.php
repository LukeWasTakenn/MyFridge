<?php

declare(strict_types=1);
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require base_path('classes/PHPMailer/src/Exception.php');
require base_path('classes/PHPMailer/src/PHPMailer.php');
require base_path('classes/PHPMailer/src/SMTP.php');

global $pdo;

if (!isAdmin()) send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$id = $data['recipeId'] ?? '';
$reason = $data['reason'] ?? '';

if (!$id || !$reason) send_response(["error" => "invalid id"], 500);

$stmt = $pdo->prepare('UPDATE `recipes` SET `is_pending` = 0, `is_denied` = 1 WHERE `recipe_id` = ?');
$stmt->execute([$id]);

$stmt = $pdo->prepare('SELECT a.email, r.title FROM `recipes` r LEFT JOIN `accounts` a ON r.`creator_id` = a.`account_id` WHERE `recipe_id` = ?');
$stmt->execute([$id]);

$result = $stmt->fetch(PDO::FETCH_OBJ);

if (!$result->email || !$result->title) send_response(["error" => "No email for user found."], 500);

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = EMAIL['host'];
    $mail->SMTPAuth = true;
    $mail->Port = EMAIL['port'];
    $mail->Username = EMAIL['username'];
    $mail->Password = EMAIL['password'];

    $mail->setFrom('myfridge@oo.com', 'MyFridge');
    $mail->addAddress("$result->email");

    $mail->isHTML(true);
    $mail->Subject = "Recipe denied";
    $mail->Body = "The administrator has denied your recipe \"" . $result->title . "\", reason: " . $reason;
    $mail->AltBody = "The administrator has denied your recipe \"" . $result->title . "\", reason: " . $reason;;

    $mail->send();
} catch (\Exception $e) {
    send_response([
        "error" => "There was an error sending the email."
    ], 500);
}

send_response([
    "success" => true
]);