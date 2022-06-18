<?php

namespace App;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;
use App\Exceptions\CustomException;
use Illuminate\Support\Carbon;

class Helper
{
    const IS_NOL = 0;

    static function responseData($data = false, $paginate = null)
    {
        if ($paginate == null) {
            $response = [
                "meta" => ['code' => EC::HTTP_OK, 'message' => EM::HTTP_OK],
                "data" => $data
            ];

            if ($data === false) unset($response['data']);
        } else {
            $response = [
                "meta" => ['code' => EC::HTTP_OK, 'message' => EM::HTTP_OK, 'page' => $paginate],
                "data" => $data
            ];
        }

        return response()->json($response, 200);
    }

    static function responseFreeCustom($EC, $EM, $data = false)
    {
        $response = [
            "meta" => ['code' => $EC, 'message' => $EM],
            "data" => $data
        ];

        if ($data === false) unset($response['data']);

        return response()->json($response, 200);
    }

    static function responseDataReport($data = false, $paginate = null, $header = null, $footer = null)
    {
        if ($paginate == null) {
            $response = [
                "meta" => ['error' => EC::NOTHING, 'message' => EM::NONE],
                "data" => $data
            ];

            if ($data === false) unset($response['data']);
        } else {
            $response = [
                "meta" => ['error' => EC::NOTHING, 'message' => EM::NONE, 'page' => $paginate],
                "data" => $data, "header" =>  $header, "footer" =>  $footer
            ];
        }

        return response()->json($response, 200);
    }

    static function createResponse($EC, $EM, $data = false)
    {
        if (!$data && [] !== $data) $data = json_decode("{}");

        $data = [
            "meta" => ['code' => $EC, 'message' => $EM],
            "data" => $data
        ];

        if ($EC > 0 || is_string($EC)) unset($data['data']);
        return response()->json($data, 200);
    }


    static function responseDownload($pathToFile, $filename)
    {
        $headers = [
            'Access-Control-Allow-Origin'      => '*',
            'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age'           => '86400',
            'Access-Control-Allow-Headers'     => 'Content-Type, Accept, Authorization, X-Requested-With, Application, Origin, Authorization, APIKey, Timestamp, AccessToken',
            'Content-Disposition' => 'attachment',
            'Pragma' => 'public',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Type' =>   self::getContentType($pathToFile),
            'Content-Length' => filesize($pathToFile)
        ];

        return response()->download($pathToFile, $filename, $headers);
    }

    static function getContentType($fileName)
    {
        $path_parts = pathinfo($fileName);
        $ext = strtolower($path_parts["extension"]);
        $mime = [
            'doc' => 'application/msword',
            'dot' => 'application/msword',
            'sfdt' => 'application/json',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
            'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
            'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
            'xls' => 'application/vnd.ms-excel',
            'xlt' => 'application/vnd.ms-excel',
            'xla' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
            'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
            'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
            'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pot' => 'application/vnd.ms-powerpoint',
            'pps' => 'application/vnd.ms-powerpoint',
            'ppa' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
            'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
            'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
            'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
            'potm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
            'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
            'pdf' => 'application/pdf',
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpg'
        ];

        return isset($mime[$ext]) ? $mime[$ext] : 'application/octet-stream';
    }
}
