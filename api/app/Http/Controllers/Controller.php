<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendNotification(string $encodedData) {

        $authKey = env('FCM_SERVER_KEY');
        $url =  "https://fcm.googleapis.com/fcm/send";

        $headers = [
            'Authorization:key=' . $authKey,
            'Content-Type: application/json',
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url );
        curl_setopt($curl, CURLOPT_POST, true );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0 );
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($curl, CURLOPT_POSTFIELDS, $encodedData );

        curl_exec($curl);

        curl_close($curl);

    }

    public function uploadImage($file) {

        $this->cloudinary = Configuration::instance();
        $this->cloudinary->cloud->cloudName = 'douzspxoy';
        $this->cloudinary->cloud->apiKey = '363893891244229';
        $this->cloudinary->cloud->apiSecret = 'R7RAOvXUyvG78tAEMMegjnQHiLs';
        $this->cloudinary->url->secure = true;

        $data = $file;
        $cloudder = (new UploadApi())->upload($data,[
            'folder' => 'smart-tourism',
            'transformation' => [
                      'quality' => "auto",
                      'fetch_format' => "auto"
     ]
]);
        $file_url = $cloudder["secure_url"];
        return $file_url;
    }




}
