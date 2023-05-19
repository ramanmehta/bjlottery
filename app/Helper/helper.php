<?php

use Illuminate\Support\Facades\Storage;

function getImage($path)
{
    if ($path == null) {
        
        return null;
    }
    return Storage::disk('public')->url('images/'.$path);
}

function status($type)
{
    switch ($type) {
        case 1:
            return 'Claim';
            break;
        case 2:
            return 'Submit';
            break;
        case 3:
            return 'Approved';
            break;
        case 4:
            return 'Reject';
            break;
    }
}