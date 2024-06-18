<?php

declare(strict_types=1);
session_start();

$user = $_SESSION['user'];

global $pdo;

if (!isset($user))
    send_response(["error" => "unauthorized"], 401);

$data = get_request_data();

$currentPassword = $data['currentPassword'] ?? "";
$password = $data['password'] ?? "";
$confirmPassword = $data['confirmPassword'] ?? "";

if (!$password || !$confirmPassword || !$currentPassword) {
    send_response(["error" => "invalid inputs"], 500);
}

if ($password !== $confirmPassword) {
    send_response(["error" => "Passwords do not match."]);
}

$stmt = $pdo->prepare("SELECT `password` FROM `accounts` WHERE `account_id` = ?");
$stmt->execute([$user->id]);

$passwordsMatch = password_verify($currentPassword, $stmt->fetchColumn(0));

if (!$passwordsMatch) {
    send_response([
        "error" => "Current password is incorrect!"
    ]);
}

$passwordHash = password_hash($password, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("UPDATE `accounts` SET `password` = ? WHERE `account_id` = ?");
$success = $stmt->execute([$passwordHash, $user->id]);

if (!$success) {
    send_response(["error" => "Something went wrong."]);
}

send_response([
    "success" => true
]);