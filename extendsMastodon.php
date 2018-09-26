<?php
require_once(__DIR__ . "/vendor/autoload.php");

class mediaMastodon extends \theCodingCompany\Mastodon {
    //メンバ変数
    protected $accessToken;
    //コンストラクタ
    public function __construct($accessToken) {
        $this->accessToken = $accessToken;
    }
    //メディア送信メソッド
    public function PostMedia($imgPath = null) {
        if($imgPath){
            //mime_type
            $mimeType = $this->mimeTypeExtension($imgPath);
            //CurlFile PHP5.5～
            $cfile = curl_file_create($imgPath, $mimeType, 'file');
            //Posturl
            $url = $this->getApiURL() . "/api/v1/media";
            $headers = array(
                "Content-Type" => "multipart/form-data"
            );
            $postField = array(
                'access_token'  => $this->accessToken,
                'file'  => $cfile
            );
            //Curlの設定
            $options = array(
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postField,
            );
            $curlHandle = curl_init();
            curl_setopt_array($curlHandle, $options);
            $response = curl_exec($curlHandle);
            curl_close($curlHandle);
            $response = json_decode($response, true);
            return $response;
        }
    }
    //メディア付きトゥートメソッド
    public function postStatuses($text = "", $mediaId = "", $visibility = "public") {
        var_dump($this->accessToken);
        if(!empty($this->accessToken)) {
            $headers = $this->getHeaders();
            $http = \theCodingCompany\HttpRequest::Instance($this->getApiURL());
            if(empty($mediaId)) { //メディアなし
                $status = $http::Post(
                    "api/v1/statuses",
                    array(
                        "status"        => $text,
                        "visibility"    => $visibility
                    ),
                    $headers
                );
            }
            else {
                $status = $http::Post(
                    "api/v1/statuses",
                    array(
                        "status"        => $text,
                        "visibility"    => $visibility,
                        "media_ids"     => array($mediaId)
                    ),
                    $headers
                );
            }
            return $status;
        }
        return false;
    }

    //mime type設定
    public function mimeTypeExtension($imgPath = null) {
        if($imgPath){
            $size = @getimagesize($imgPath);
            switch($size['mime']){
                //jpeg
                case IMAGETYPE_JPEG:
                    return "image/jpg";
                    break;
                //png
                case IMAGETYPE_PNG:
                    return "image/png";
                    break;
                //gif
                case IMAGETYPE_GIF:
                    return "image/gif";
                    break;
            }
        }
        return '';
    }
}