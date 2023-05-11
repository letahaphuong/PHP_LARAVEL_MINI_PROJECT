<?php

use App\Models\Groups;

function isUppercase($value, $message, $fail)
{
    if ($value != strtoupper($value)) {
        $fail($message);
    }
}

function getAllGroups()
{
    $groups = new Groups;
    return $groups->getAll();
}
