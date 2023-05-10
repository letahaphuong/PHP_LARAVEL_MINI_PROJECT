<?php
function isUppercase($value, $message, $fail)
{
    if ($value != strtoupper($value)) {
        $fail($message);
    }
}
