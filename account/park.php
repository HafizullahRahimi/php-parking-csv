<?php
//require Files
require_once '../functions/helpers.php';
require_once '../Class/User.php';
require_once '../Class/Parking.php';

//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

//Time Zone Sweden
date_default_timezone_set("Europe/Stockholm");
$format = "Y/m/d H:i:s"; //2023/02/07 18:48:54

// echo ' Park new vehicle page';

// START SESSION
session_start();

?>

<?php


//-----------------------------------------------------------
// Date and Time
// echo "The time is " . date("h:i:sa");
// echo '<br>';
// $timestamp = time();
// $timestampStart = 1675792134;

// echo "timestamp: " . $timestamp;
// echo '<br>';
// $format = "Y/m/d H:i:s"; //2023/02/07 18:48:54
// echo "date: " . date($format, $timestamp);
// echo '<br>';
// echo "date Start: " . date($format, $timestampStart);

// $datetime_1 = date($format, $timestampStart);
// $datetime_2 = date($format, $timestamp);

// $from_time = strtotime($datetime_1);
// $to_time = strtotime($datetime_2);
// $diff_minutes = round(abs($from_time - $to_time) / 60, 2) . " minutes";

// echo '<br>';
// echo "diff_minutes: " . $diff_minutes;



//-----------------------------------------------------------




?>




<!-- POST -->
<?php
$vehicleTypeErr = $nameErr = $err = "";
$place = $regNum = $name = $vehicleType = $checkInTime = "";

$parkStatus = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_SESSION["userName"];

    # vehicleType Test Start
    if (empty($_POST["vehicleType"])) {
        $vehicleTypeErr = "vehicleType is required";
    } else {
        $vehicleType = test_input($_POST["vehicleType"]);

        //-----------------------------------------------------------
        // 1- User Class
        $filePathUsers =  '../files/users.csv'; // users.csv File Path
        $u = new User($filePathUsers); // New Object from User Class
        $u->setUserIndex($_SESSION["userEmail"]);

        // Add To User Arr
        $regNum = 'R' . rand(100, 900);
        $checkInTime = time();
        $parked = $u->parkNewVehicle($regNum, $vehicleType, $checkInTime);
        
        //-----------------------------------------------------------
        // 2- Parking Class
        $filePathParking = '../files/parking.csv'; // users.csv File Path
        $p = new Parking($filePathParking); // New Object from Parking Class
        
        // vehicleType = Car
        if ($parked && $vehicleType == 'Car') {
            $freeCarArr = $p->getFreePlacesForCar();
            $place = $p->getRandomPlace($freeCarArr);
            
            // Add to parking Arr
            $added = $p->addCar($place, $regNum);
            
            if ($added) $parkStatus = true;
        }
        // vehicleType = MC
        if ($parked && $vehicleType == 'MC') {
            $freeMCArr = $p->getFreePlacesForMC();
            $RandomPlace = $p->getRandomPlace($freeMCArr);

            $place = $RandomPlace[0];
            $part = $RandomPlace[1];

            // echo 'Place: '.$place;
            // echo '  Part: '. $part;
            
            // Add to parking Arr
            $added = $p->addMC($place, $part,$regNum);

            
            if ($added) $parkStatus = true;
        }

    }
    # vehicleType Test End

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../layouts/head.php' ?>
    <?php //require_once '../layouts/head.php' 
    ?>
    <title>Park new vehicle</title>
</head>

<body onload="">

    <!-- Header Start -->
    <header>
        <!-- Navbar -->
        <?php //require_once './layouts/navbar.php' 
        ?>
    </header>
    <!-- Header End -->


    <!-- Main Start -->
    <main>
        <div class=" container">
            <br>
            <br>
            <h1 class="mx-auto w-50">Park new vehicle</h1>
            <section class="w-50 m-auto">
                <!-- Form register -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 row gx-3 gy-2 align-items-center">
                    <span class=" text-danger "><?php echo $err ?></span>
                    <div class="">
                        <label class="" for="specificSizeInputName">Name:</label>
                        <input type="name" name="name" class="form-control" id="specificSizeInputName" value="<?php echo $_SESSION["userName"]; ?>" disabled readonly>
                        <span class=" text-danger "><?php echo  $nameErr ?></span>
                    </div>

                    <div class="">
                        <!-- <p>Vehicle Type:</p> -->
                        <label>Vehicle Type:</label>
                        <br>
                        <input class="form-check-input" type="radio" name="vehicleType" id="inlineRadio1" value="Car" checked>
                        <label class="form-check-label" for="inlineRadio1">Car</label>

                        <input class="form-check-input" type="radio" name="vehicleType" id="inlineRadio2" value="MC">
                        <label class="form-check-label" for="inlineRadio2">MotorC</label>
                    </div>

                    <div class=" ms-auto w-auto">
                        <button type="submit" class=" btn btn-primary ">Park Now</button>
                    </div>
                </form>
                <br>
                <!--  Bill Info -->
                <?php if ($parkStatus) { ?>
                    <br>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Park done!</h4>
                        <p>
                            Place: <?= $place ?> <br>
                            Reg-num: <?= $regNum ?> <br>
                            Name: <?= $name ?> <br>
                            Vehicle Type: <?= $vehicleType ?> <br>
                            Check-in time: <?= date($format, $checkInTime) ?> <br>
                        </p>
                        <hr>
                        <a class="" href="./index.php" class="alert-link mr-auto">Go To Home</a>
                    </div>

                    <!-- SweetAlert -->
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Vehicle Parked!',
                            footer: '<a class="" href="./index.php" class="alert-link mr-auto">Go To Home</a>',
                            focusConfirm: false,
                            showCloseButton: true,
                            showCancelButton: false,
                        })
                    </script>
                <?php } ?>
            </section>
        </div>
    </main>
    <!-- Main End -->



    <!-- script src -->
    <?php require_once '../layouts/script-src.php' ?>
</body>

</html>