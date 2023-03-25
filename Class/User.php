<?php

require_once 'CsvFileHandler.php';


class User extends CsvFileHandler
{
    //properties
    public $filePath;
    public $userArr = array();


    // User properties
    public $userName;
    public $userIndex;
    public $userPassword;
    public $userEmail;


    // Vehicle properties
    public $regNum;
    public $vehicleType;
    public $checkInTime;
    public $place;
    // public $regNum = 'R' . rand(100, 900);
    // public $checkInTime = time();


    // Constructor
    function __construct($filePath)
    {
        $this->filePath = $filePath;
        $this->userArr = $this->csvToArray($filePath);
    }

    // Destructor
    function __destruct()
    {
        // echo 'End of Class' . '<br>';
    }


    // Setter ---------------------------------------------
    // Set All attributes
    private function setAtt()
    {
        $userArray = $this->userArr;
        $userArrayLength = count($userArray);

        for ($i=1; $i < $userArrayLength -1; $i++) { 
            if ($userArray[$i][1] == $this->userEmail) {
                $this->userName = $userArray[$i][0];
                if (isset($userArray[$i][3])) {
                    $this->regNum = $userArray[$i][3];
                    // $this->place = $userArray[$i][3];
                    $this->vehicleType = $userArray[$i][4];
                    $this->checkInTime = $userArray[$i][5];
                }
            }
        }
    }
    function setEmail($email)
    {
        //Set UserEmail
        $this->userEmail = $email;
    }
    private function setUserName()
    {
        $email = $this->userEmail;
        for ($row = 0; $row < count($this->userArr) - 1; $row++) {
            if ($email == $this->userArr[$row][1]) {
                // $userName = $this->userArr[$row][0];
                // echo $userName . '<br>';
                $this->userName = $this->userArr[$row][0];
                break;
            }
        }
    }
    public function setUserIndex($email)
    {
        // $email = $this->userEmail;
        for ($row = 0; $row < count($this->userArr) - 1; $row++) {
            if ($email == $this->userArr[$row][1]) {
                // $userName = $this->userArr[$row][0];
                // echo $userName . '<br>';
                $this->userIndex = $row;
                break;
            }
        }
    }

    // Getter ---------------------------------------------
    function getName()
    {
        return $this->userName;
    }

    // User Methods ---------------------------------------------

    // Login User
    public function login($email, $password)
    {
        // START SESSION
        session_start();
        
        //Set UserEmail
        $this->userEmail = $email;

        //Set userPassword
        $this->userPassword = $password;

        //Set Att
        $this->setAtt();

        //Set SESSION
        $_SESSION["userName"] = $this->userName;
        $_SESSION["userEmail"] = $this->userEmail;
        $_SESSION["userPassword"] = $this->userPassword;
        $_SESSION["regNum"] = $this->regNum;
        $_SESSION["vehicleType"] = $this->vehicleType;
        $_SESSION["checkInTime"] = $this->checkInTime;

        redirect('account/profile.php?signed=1');
    }

    // Register new User 
    public function register($name, $email, $password)
    {
        // START SESSION
        session_start();

        //Append Data To CVS
        // $this->appendData($name, $email, $password, $filePath);
        $this->appendData($name, $email, $password, $this->filePath);

        //Set SESSION
        $_SESSION["userName"] = $name;
        $_SESSION["userEmail"] = $email;
        $_SESSION["userPassword"] = $password;

        redirect('account/Profile.php?registered=1');
    }


    // Vehicle Methods ---------------------------------------------
    // Add Vehicle to user Row
    public function parkNewVehicle($regNum, $vehicleType, $checkInTime)
    {
        try {
            // inserter to user array
            $index =$this->userIndex;
            $row = $this->userArr[$index];
            $inserted = [$regNum, $vehicleType, $checkInTime];

            // splice in $row
            array_splice($row , 3, 3, $inserted); 
            // dd($newArr);
            
            // splice row in userArr
            array_splice($this->userArr, $index, 1, array($row) ); 
            //  echo '<hr>';
            // dd($this->userArr);

            // Save userArr Change to CVS File
            $this->arrayToCsv($this->userArr, $this->filePath);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // Remove Vehicle from user Row
    public function deliveryOfVehicle($regNum)
    {
        try {
            // inserter to user array
            $index =$this->userIndex;
            $row = $this->userArr[$index];
            $inserted = array([$row[0], $row[1],$row[2]]);


            // splice row in userArr
            array_splice($this->userArr, $index, 1, $inserted ); 
            // echo '<hr>';
            // dd($this->userArr);

            // Save userArr Change to CVS File
            $this->arrayToCsv($this->userArr, $this->filePath);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
