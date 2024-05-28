<?php

declare(strict_types=1);
session_start();

global $pdo;

$data = get_request_data();

$email = $data['email'];
$password = $data['password'];

$stmt = $pdo->prepare('SELECT `account_id`, `first_name`, `last_name`, `email`, `role`, `password`, `is_verified`, `is_banned` FROM `accounts` WHERE `email` = ?');
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_OBJ);

if (!$user) {
    send_response([
        "error" => "account_not_exists"
    ]);
}

if (!password_verify($password, $user->password)) {
    send_response([
        "error" => "incorrect_password"
    ]);
}

if (!$user->is_verified) send_response(["error" => "unverified"]);
if ($user->is_banned) send_response(["error" => "banned"]);

$_SESSION['user'] = new User(
    $user->account_id,
    $user->first_name,
    $user->last_name,
    $user->email,
    $user->role,
    (boolean) $user->is_verified,
    (boolean) $user->is_banned
);

send_response(["status" => "ok"]);