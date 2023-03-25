<?php

require_once 'CsvFileHandler.php';

class Parking extends CsvFileHandler
{
    //properties
    public $parkingArr = array();
    public $filePath;

    public $place;
    public $regNum;
    public $checkInTime;

    // public $place = $this->getRandomPlace();
    // public $regNum = 'R' . rand(100, 900);
    // public $checkInTime = time();




    // Constructor
    function __construct($filePath)
    {
        // echo 'Start of Class <br>';
        $this->filePath = $filePath;
        $this->parkingArr = $this->csvToArray($filePath);
    }

    // Destructor
    function __destruct()
    {
        // echo 'End of Class' . '<br>';
    }


    //Setter
    // Set All attributes
    function setAtt($animalName, $animalAge,  $animalColor)
    {
    }

    //Getter
    function getName()
    {
    }
    // Get all
    function getInfo()
    {
    }

    // Methods
    function parkNewVehicle($place, $regNum, $name, $vehicleType, $checkInTime)
    {
        try {
            // inserter to parking array
            $inserted = array([$place, $regNum, $name, $vehicleType, $checkInTime]);
            array_splice($this->parkingArr, $place, 1, $inserted); // splice in parkingArr
            // Save parkingArr Change to CVS File
            $this->arrayToCsv($this->parkingArr, $this->filePath);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    function Add($place, $regNum)
    {
        try {
            // inserter to parking array
            $inserted = array([$regNum]);
            array_splice($this->parkingArr, $place, 1, $inserted); // splice in parkingArr
            // Save parkingArr Change to CVS File
            $this->arrayToCsv($this->parkingArr, $this->filePath);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    function deliveryOfVehicle()
    {
    }

    function moveVehicle()
    {
    }

    function findVehicle()
    {
    }
    function getBill()
    {
    }

    // Methods

    public function getRandomPlace()
    {
        // Arr with all free places
        $freePlaceArr = array();
        for ($i = 1; $i < 11; $i++) {
            if ($this->parkingArr[$i][0] == 'free') {
                array_push($freePlaceArr, $i);
            }
        }
        // print_r($freePlaceArr);

        // Use array_rand function to returns random key
        $key = array_rand($freePlaceArr);

        // Display the random array element
        $randomPlace = $freePlaceArr[$key];
        // echo $randomPlace;
        return $randomPlace;
    }
}


// $p = new Parking('../../index.php');
// echo '<br>';
// var_dump($p->parkingArr);
// echo '<br>';
// echo $p->filePath;
