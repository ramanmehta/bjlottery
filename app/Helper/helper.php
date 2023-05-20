<?php

use Illuminate\Support\Facades\Storage;

use function PHPUnit\Framework\returnSelf;

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

function withdrawalStatus($val,$res=false)
{
    if ($res) {
        
        switch ($val) {
            case str_contains('withraw requested', $val):
                return 1;
                break;
            case str_contains('admin deposited', $val):
                return 2;
                break;
            case str_contains('admin rejected', $val):
                return 3;
                break;
            default:
                return $val;
        }
    }else{
        switch ($val) {
            case 1:
                return 'Withraw Requested';
                break;
            case 2:
                return 'Admin Deposited';
                break;
            case 3:
                return 'Admin Rejected';
                break;
        }
    }
}