<?php

function permission($permission)
{
    return auth()->user()->permissions[$permission] == '0';
}

function isRole($role, $false = false, $true = true)
{
    if (auth()->user()->inRole($role)) {
        return $true;
    }
    return $false;
}
