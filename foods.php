<?php
include_once('./csv.php');

class FoodFacilityModel {
    private $csvModel = null;
    private $csvData = null;
    function __construct()  {
        $this->csvModel = new CSVModel();
        $this->csvData = $this->csvModel->loadData();
    }

    function status($params) {
        $array = ['APPROVED', 'REQUESTED', 'EXPIRED', 'ISSUED'];
        return $array;
    }
    
    function allData($params) {
     return $this->csvData;
    }
    
    function header($params) {
        return $this->csvModel->dataHeader();
    }

    function filterData($params) {
        $filterArray = [];
        if($params['filter']) {
            foreach ($this->csvData as $key => $item) {
                if(strpos(strtolower($item['FoodItems']), strtolower($params['filter'])) !== false) {
                    $filterArray[] = $item;
                }
            }
        } else {
            $filterArray = $this->csvData;
        }
        return $filterArray;
    }
}
