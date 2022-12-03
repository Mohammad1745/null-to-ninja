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
