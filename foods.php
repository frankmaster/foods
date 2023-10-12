<?php
include_once('./csv.php');

class FoodFacilityModel {
    private $csvModel = null;
    private $csvData = null;
    function __construct()  {
        $this->csvModel = new CSVModel();
        $this->csvData = $this->csvModel->loadData();
    }

    function getStatus() {
        $array = ['APPROVED', 'REQUESTED', 'EXPIRED', 'ISSUED'];
        return $array;
    }
    
    function getAllData() {
     return $this->csvData;
    }
    
    function getHeader() {
        return $this->csvModel->dataHeader();
    }
}
