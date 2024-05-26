<?php

$data = get_request_data();

$firstName = $data['firstName'];
$lastName = $data['lastName'];
$email = $data['email'];
$phoneNumber = $data['phoneNumber'];
$password = $data['password'];
$confirmPassword = $data['confirmPassword'];

// TODO: register user

send_response([
    "status" => "ok!",
    "data" => $data
]);

//echo json_encode("");

?>