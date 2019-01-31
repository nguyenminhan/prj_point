<?php

namespace App\Library;

class APIHelper
{
    protected $url;
    protected $contract_id;
    protected $access_token;


    public function __construct()
    {

        $this->url = env('URL_POINT');
        $this->contract_id = env('CONTRACT_ID');
        $this->access_token = env('ACCESS_TOKEN');
    }

    public function getApi($params=array())
    {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded;charset=UTF-8',
            'X_access_token:'. $this->access_token,
            'X_contract_id:'.$this->contract_id
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($params));  //Post Fields
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

}