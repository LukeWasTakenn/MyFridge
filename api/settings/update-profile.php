<?php

declare(strict_types=1);
session_start();

$user = $_SESSION['user'];

if (!isset($user)) send_response(["error" => "unauthorized"], 401);

global $pdo;

$data = get_request_data();

$firstName = $data['firstName'] ?? "";
$lastName = $data['lastName'] ?? "";
$phoneNumber = $data['phoneNumber'] ?? "";

if (!$firstName || !$lastName || !$phoneNumber) {
    send_response(
        ["error" => "invalid inputs"],
    500);
}

$firstName = htmlspecialchars($firstName);
$lastName = htmlspecialchars($lastName);
$phoneNumber = htmlspecialchars($phoneNumber);

$stmt = $pdo->prepare('UPDATE `accounts` SET `first_name` = ?, `last_name` = ?, `phone_number` = ? WHERE `account_id` = ?');
$success = $stmt->execute([$firstName, $lastName, $phoneNumber, $user->id]);

if (!$success)
    send_response([
        "error" => "Something went wrong"
    ]);

$_SESSION['user']->first_name = $firstName;
$_SESSION['user']->last_name = $lastName;
$_SESSION['user']->phone_number = $phoneNumber;

send_response([
    "success" => true
]);