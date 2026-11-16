<?php

function ordinal(int $number) : string
{
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
        return $number . 'th';
    } else {
        return $number . $ends[$number % 10];
    }
}

/**
 * Flash a toastr message to display on the next page render.
 */
function flash_toastr(string $type, string $message) : void
{
    session()->flash('flash', ['type' => $type, 'message' => $message]);
}

function flash_success(string $message) : void
{
    flash_toastr('success', $message);
}

function flash_error(string $message) : void
{
    flash_toastr('error', $message);
}

function flash_info(string $message) : void
{
    flash_toastr('info', $message);
}

function flash_warning(string $message) : void
{
    flash_toastr('warning', $message);
}
