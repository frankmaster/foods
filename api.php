<?php

error_reporting(E_ALL);
include_once('./foods.php');

class Api {
    private $foods = null;
 
    function __construct() {
        $this->foods = new FoodFacilityModel();
    }
    
    function handle() {
        $inputData = $this->getInput();
        if($inputData && $inputData['method']) {
            $data = $this->process($inputData);
            if($data !== null) {
                $this->response($data);
            } else {
                $this->exit();
            }
        } else {
            $this->exit();
        }
    }
    
    function process($param) {
        if($param['method']) {
            return call_user_func(array($this->foods, $param['method']), $param);
        }
       return null;
    }
    
    function getInput() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        return $data;
    }
    
    function response($data) {
        header('Content-Type:application/json');
        echo json_encode($data,JSON_UNESCAPED_UNICODE);
    }

    function exit() {
        header('HTTP/1.1 404 Not Found');
        exit();
    }
}

$api = new Api();
$api->handle();
