<?php

function permission($permission){
    return auth()->user()->permissions[$permission] == '0';
}
