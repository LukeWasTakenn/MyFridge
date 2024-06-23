<?php

declare(strict_types=1);

global $pdo;

$data = get_request_data();

$password = $data['password'];
$confirmPassword = $data['confirmPassword'];
$token = $data['token'];

$stmt = $pdo->prepare('SELECT 1 FROM `accounts` WHERE `forgotten_password_token` = ? AND `forgotten_password_expires` >= CURRENT_TIMESTAMP()');
$stmt->execute([$token]);

if (!$stmt->fetchColumn(0))
    send_response([
        "error" => "Invalid token or token expired"
    ]);



if ($password !== $confirmPassword)
    send_response([
        "error" => "Passwords do not match"
    ]);

$stmt = $pdo->prepare('UPDATE `accounts` SET `password` = ?, `forgotten_password_token` = ?, `forgotten_password_expires` = ? WHERE `forgotten_password_token` = ?');
$success = $stmt->execute([password_hash($password, PASSWORD_BCRYPT), null, null, $token]);

if (!$success) {
    send_response([
        "error" => "Something went wrong"
    ]);
}

send_response([
    "success" => true
]);
