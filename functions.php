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
function get_request_data() {
    return array_merge(empty($_POST) ? array() : $_POST, (array) json_decode(file_get_contents('php://input'), true), $_GET);
}

function send_response($response, $code = 200) {
    http_response_code($code);
    die(json_encode($response));
}

function createToken(int $length): ?string
{
    try {
        return bin2hex(random_bytes($length));
    } catch (\Exception $e) {
        error_log("****************************************");
        error_log($e->getMessage());
        error_log("file:" . $e->getFile() . " line:" . $e->getLine());
        return null;
    }
}

function isAdmin(): bool {
    $user = $_SESSION['user'];

    if (!$user || $user->role !== 'admin') {
        return false;
    }

    return true;
}

// https://stackoverflow.com/questions/15153776/convert-base64-string-to-an-image-file
function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' );

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp );

    return $output_file;
}