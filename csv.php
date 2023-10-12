<?php

class CSVModel {
    private string $csvFile = './static/Mobile_Food_Facility_Permit.csv';
    private $header = [];
    function __construct()  {
        
    }

    function loadData() {
        $file = fopen($this->csvFile, 'r');
        $csvHeader = [];
        $csvContents = [];
        $fileLine = 0;
        while($data = fgetcsv($file)) {
            if ($fileLine === 0) {
                $csvHeader = $this->getHeader($data);
                $this->header = $csvHeader;
            } else {
                $csvContents[] = $this->getLine($data);
            }
            $fileLine++;
        }
        fclose($file);
        $data = $this->buildLogicData($csvHeader, $csvContents);
        // print_r( $data);
        return $data;
    }
    
    function dataHeader() {
        return $this->header;
    }

    private function getHeader($data) {
        $headers = [];
        foreach ($data as $key => $value) {
            $headers[] = $value;
        }
        return $headers;
    }

    private function getLine($data) {
        $line = [];
        foreach ($data as $key => $value) {
            $line[] = $value;
        }
        return $line;
    }

    private function buildLogicData($csvHeader, $csvContents) {
        $data = [];
        foreach ($csvContents as $lineArray) {
            $dataWithHead = array_combine($csvHeader, $lineArray);
            // foreach ($lineArray as $key => $value) {
            //     if ($csvHeader[$key]) {
            //         $dataWithHead[$csvHeader[$key]] = $value;
            //     } else {
            //         // maybe error for no columns
            //     }
            // }
            if ($dataWithHead['FoodItems']) { // make FoodItems as array.
                $dataWithHead['FoodItemsArr'] = explode(': ', $dataWithHead['FoodItems']);
            }
            $data[] = $dataWithHead;
        }
        return $data;
    }
}
