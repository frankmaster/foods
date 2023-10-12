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
        if($inputData['method']) {
            $data = $this->process($inputData);
            if($data) {
                $this->response($data);
            } else {
                header('HTTP/1.1 404 Not Found');
                exit();
            }
        }
    }
    
    function process($param) {
        if($param['method']== 'Status') {
            return $this->foods->getStatus();
        } else if($param['method'] == 'allData') {
            return $this->foods->getAllData();
        }else if($param['method'] == 'header') {
            return $this->foods->getHeader();
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
}

$api = new Api();
$api->handle();
