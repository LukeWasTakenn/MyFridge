<?php

declare(strict_types=1);

function dd(mixed $var): void
{
    die(var_dump($var));
}

function base_path(string $path): string
{
    return BASE_PATH . $path;
}


// https://gomakethings.com/how-to-create-your-own-api-endpoints-with-php/
function get_request_data () {
    return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

function send_response ($response, $code = 200) {
    http_response_code($code);
    die(json_encode($response));
}