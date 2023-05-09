<?php

use Illuminate\Support\Facades\Storage;

function getImage($path)
{
    return Storage::disk('public')->url('images'.$path);
}

function status($type)
{
    switch ($type) {
        case 1:
            return 'Claim';
            break;
        case 2:
            return 'Pending';
            break;
        case 3:
            return 'Approved';
            break;
        case 4:
            return 'Reject';
            break;
    }
}