<?php

declare(strict_types=1);

class User
{
    function __construct(
        public int $id,
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $role,
        public bool $is_verified,
        public bool $is_banned
    ) {}
}