<?php

/**
 * @param $key
 * @return string|string[]
 */
function userRoles ($key=null): array|string
{
    $data = [
        ROLE_ADMIN => 'Admin',
        ROLE_USER => 'User'
    ];

    return $key ? $data[$key] : $data;
}

/**
 * @param $length
 * @return string
 */
function randomNumber ($length = 10): string
{
    $x = '123456789';
    $c = strlen($x) - 1;
    $response = '';
    for ($i = 0; $i < $length; $i++) {
        $y = rand(0, $c);
        $response .= substr($x, $y, 1);
    }

    return $response;
}
