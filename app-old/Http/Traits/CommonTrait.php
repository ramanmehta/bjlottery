<?php
namespace App\Http\Traits;


trait CommonTrait {
    public function filepath() {
        // Fetch all the students from the 'student' table.
        // $filePath = [
        //     // 'url' => env('APP_URL').'/storage/app/public/images',
        //     'root' => storage_path('app').'/public/images',
        // ];
    
        // $filePath = env('APP_URL').'/storage/app/public/images';
        $filePath = 'public/images';
        return $filePath;
    }

    public function fileurl() {
        // Fetch all the students from the 'student' table.
        // $filePath = [
        //     // 'url' => env('APP_URL').'/storage/app/public/images',
        //     'root' => storage_path('app').'/public/images',
        // ];
    
        // $filePath = env('APP_URL').'/storage/app/public/images';
        $filePath = asset('storage/app/public/images/');
        return $filePath;
    }
    
    public function referalCode() {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $code;
    }
}