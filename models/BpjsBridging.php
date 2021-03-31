<?php

namespace app\models;

use Yii;
use linslin\yii2\curl\Curl;

class BpjsBridging
{
    public $base_url, $final_url;
    public $header, $option, $method, $response;
    public $id, $password, $timestamp;
    public $error_msg, $error_code;
    function __construct()
    {
        date_default_timezone_set('UTC');
        $this->base_url = Yii::$app->params['bpjs']['url'];
        $this->id = Yii::$app->params['bpjs']['id'];
        $this->password = Yii::$app->params['bpjs']['password'];
        $this->timestamp = strval(time() - strtotime('1970-01-01 00:00:00'));
        $this->signature = base64_encode(hash_hmac('sha256', $this->id . "&" . $this->timestamp, $this->password, true));
        $this->header = [
            "Content-Type" => 'Application/x-www-form-urlencoded',
            "X-cons-id" => $this->id,
            "X-timestamp" => $this->timestamp,
            "X-signature" => $this->signature,
        ];
        $this->option = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_CIPHER_LIST => 'DEFAULT:!DH',
        ];
    }
    function setHeader($header = [])
    {
        if (count($header) > 0) {
            $this->header = array_merge($header, $this->header);
        }
    }
    function setOption($option = [])
    {
        if (count($option) > 0) {
            $this->option = array_merge($option, $this->option);
        }
    }
    function setUp($url, $data = [], $method = 'GET')
    {
        if (is_array($url)) {
            $url = implode('/', $url);
        }
        $this->final_url = str_replace(' ', '%20', Yii::$app->params['bpjs']['url'] . DIRECTORY_SEPARATOR . $url);
        $this->method = $method;
        $this->parameter = json_encode($data);
        return $this;
    }
    function exec()
    {
        $this->response = json_decode($this->run());
        return $this->validate();
    }
    function run()
    {
        $curl = new Curl();
        $curl->setHeaders($this->header);
        $curl->setOptions($this->option);

        if (in_array($this->method, ['POST', 'PUT', 'DELETE'])) {
            $curl->setRequestBody($this->parameter);
        } else if ($this->method == 'GET') {
            $curl->setGetParams($this->parameter);
        } else {
            throw new InvalidParamException('Invalid Method Value on Class' . self::className());
        }

        if ($this->method == 'POST') {
            $response = $curl->post($this->final_url);
        } else if ($this->method == 'GET') {
            $response = $curl->get($this->final_url);
        } else if ($this->method == 'PUT') {
            $response = $curl->put($this->final_url);
        } else if ($this->method == 'DELETE') {
            $response = $curl->delete($this->final_url);
        }

        return $response;
    }
    function validate()
    {
        if (!isset($this->response->metaData)) {
            $this->error_msg = 'Tidak dapat menghubungkan dengan server BPJS';
            $this->error_code = 500;
            return false;
        } else {
            if ($this->response->metaData->code == 200) {
                $this->error_code = null;
                $this->error_msg = null;
                return true;
            } else {
                $this->errorCode = $this->response->metaData->code;
                $this->error_msg = $this->response->metaData->message;
                return false;
            }
        }
    }
    public function getResponse()
    {
        if (!empty($this->response)) {
            if (!empty($this->response->response)) {
                if (empty($this->error_code)) {
                    return $this->response->response;
                }
            }
        }
        return null;
    }
}
