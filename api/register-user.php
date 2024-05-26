<?php

declare(strict_types=1);

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

    //    TODO: send email
    send_response([
        "success" => true
    ]);
} catch (PDOException $exception) {
    send_response([
        "error" => "Something went wrong while creating the account.",
        "code" => $exception->getCode(),
        "message" => $exception->getMessage()
    ], 500);
}
