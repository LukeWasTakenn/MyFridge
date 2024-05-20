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