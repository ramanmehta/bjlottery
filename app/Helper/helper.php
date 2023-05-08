<?php

use Illuminate\Support\Facades\Storage;

function getImage($path)
{
    return Storage::disk('public')->url('images'.$path);
}