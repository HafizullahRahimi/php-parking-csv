<?php

require_once 'CsvFileHandler.php';

class Parking extends CsvFileHandler
{
    // properties
    public $parkingArr = array();
    public $filePath;

    public $regNum;
    public $place;
    public $part;

    // Constructor
    function __construct($filePath)
    {
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
    function setPlace($regNum)
    {
        $arr = $this->parkingArr;
        for ($row = 1; $row < count($arr) - 1; $row++) {
            if ($arr[$row][1] == $regNum || $arr[$row][2] == $regNum) {
                $this->place = $arr[$row][0];
            }
            if ( $arr[$row][1] == $regNum) {
                $this->place = $arr[$row][0];
                $this->part = 1;
            }
            if ($arr[$row][2] == $regNum) {
                $this->place = $arr[$row][0];
                $this->part = 2;
            }
        }
    }

    //Getter
    function getName()
    {
    }


    // Methods ----------------------------------------
    //Add Car
    function addCar($place, $regNum)
    {
        try {
            $oldArr = $this->parkingArr[$place];

            // inserter to parking array
            $inserted = array([$oldArr[0], $regNum, $regNum]);
            array_splice($this->parkingArr, $place, 1, $inserted); // splice in parkingArr

            // Save parkingArr Change to CVS File
            $this->arrayToCsv($this->parkingArr, $this->filePath);

            //Set SESSION
            $_SESSION["regNum"] = $regNum;
            $_SESSION["place"] = $place;

            //Redirect profile.php
            redirect('account/profile.php');

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    // Add MC
    function addMC($place, $part, $regNum)
    {
        try {
            $oldArr = $this->parkingArr[$place];

            echo "{$place} {$part} {$regNum}";
            // inserter to parking array
            if ($part == '1') {
                $inserted = array([$place, $regNum, $oldArr[2]]);
            }
            if ($part == '2') {
                $inserted = array([$place, $oldArr[1], $regNum]);
            }
            array_splice($this->parkingArr, $place, 1, $inserted); // splice in parkingArr

            // Save parkingArr Change to CVS File
            $this->arrayToCsv($this->parkingArr, $this->filePath);

            //Set SESSION
            $_SESSION["regNum"] = $regNum;
            $_SESSION["place"] = $place;
            $_SESSION["part"] = $part;

            //Redirect profile.php
            redirect('account/profile.php');

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // Remove Car
    function removeCar($regNum)
    {
        $this->setPlace($regNum);
        $place = $this->place;
        try {
            $oldArr = $this->parkingArr[$place];

            // inserter to parking array
            $inserted = array([$oldArr[0], 'free', 'free']);
            array_splice($this->parkingArr, $place, 1, $inserted); // splice in parkingArr

            // Save parkingArr Change to CVS File
            $this->arrayToCsv($this->parkingArr, $this->filePath);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
    // Remove MC
    function removeMC($regNum)
    {
        $this->setPlace($regNum);
        $place = $this->place;
        $part = $this->part;
        try {
            $oldArr = $this->parkingArr[$place];
            // inserter to parking array
            $inserted = array();
            if ($part == 1) {
                $inserted = array([$oldArr[0], 'free', $oldArr[2]]);
            } else{
                $inserted = array([$oldArr[0],$oldArr[1], 'free']);
            }
            array_splice($this->parkingArr, $place, 1, $inserted); // splice in parkingArr

            // Save parkingArr Change to CVS File
            $this->arrayToCsv($this->parkingArr, $this->filePath);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // Move Car
    function moveCar($regNum, $newPlace)
    {
        $this->removeCar($regNum);
        $this->addCar($newPlace,$regNum);
    }
    // Move MC
    function moveMC($regNum, $newPlace, $newPart)
    {
        $this->removeMC($regNum);
        $this->addMC($newPlace,$newPart,$regNum);
    }



    // Helper Methods ----------------------------------------

    // get Random Place from Arr
    public function getRandomPlace($arr)
    {
        // Use array_rand function to returns random key
        $key = array_rand($arr);

        // Display the random array element
        $randomPlace = $arr[$key];
        // dd($randomPlace);
        return $randomPlace;
    }

    // Array Of Free Places For Car
    public function getFreePlacesForCar()
    {
        $freePlaceForCarArr = array();
        for ($i = 1; $i < 11; $i++) {

            if ($this->parkingArr[$i][1] == 'free' && $this->parkingArr[$i][2] == 'free') {
                // echo 'Arr:' . $this->parkingArr[$i][0];
                // echo ' : ' . $this->parkingArr[$i][1];
                // echo ' : ' . $this->parkingArr[$i][2];
                // echo '<br>';
                array_push($freePlaceForCarArr, $this->parkingArr[$i][0]);
            }
        }
        // dd($freePlaceForCarArr);
        return $freePlaceForCarArr;
    }

    // Array Of Free Places For MC
    public function getFreePlacesForMC()
    {
        $freePlaceForMCArr = array();
        for ($i = 1; $i < 11; $i++) {

            if ($this->parkingArr[$i][1] == 'free') {
                // echo 'Arr:' . $this->parkingArr[$i][0];
                // echo ' : ' . $this->parkingArr[$i][1];
                // echo ' : ' . $this->parkingArr[$i][2];
                // echo '<br>';

                $inserted = [$this->parkingArr[$i][0], '1'];
                array_push($freePlaceForMCArr, $inserted);
            }
            if ($this->parkingArr[$i][2] == 'free') {

                $inserted = [$this->parkingArr[$i][0], '2'];
                array_push($freePlaceForMCArr, $inserted);
            }
        }
        // dd($freePlaceForMCArr);
        return $freePlaceForMCArr;
    }
}
