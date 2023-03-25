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

// START SESSION
session_start();

//-----------------------------------------------------------
// echo  $_SESSION["regNum"];

?>

<!-- POST -->
<?php
$place = $name = $email = $password = $regNum = $vehicleType = $checkInTime = $checkOutTime = $time = $bill = "";
$deliveryStatus = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $regNum = $_POST["regNumber"];
    // echo $regNum;
    // exit;

    //-----------------------------------------------------------
    // 1- User Class
    $filePathUsers =  '../files/users.csv'; // users.csv File Path
    $u = new User($filePathUsers); // New Object from User Class
    $u->setUserIndex($_SESSION["userEmail"]);

    $userArr = $u->userArr;
    $userArrLength = count($userArr);
    // dd($userArr);
    // echo $userArr[3][3];
    // echo $userArrLength;

    // 2- Parking Class
    $filePathParking =  '../files/parking.csv'; // parking.csv File Path
    $p = new Parking($filePathParking); // New Object from Parking Class
    // $p->setUserIndex($_SESSION["userEmail"]);

    $parkingArr = $p->parkingArr;
    $parkingArrLength = count($parkingArr);

    // dd($parkingArr);


    for ($row = 1; $row < $userArrLength - 1; $row++) {
        // echo '<br>';
        // echo $userArr[$row][3];
        if (isset($userArr[$row][3])) {
            if ($userArr[$row][3] == $regNum) {
                $name = $userArr[$row][0];
                $email = $userArr[$row][1];
                $password = $userArr[$row][2];
                $vehicleType = $userArr[$row][4];
                $checkInTime = $userArr[$row][5];
                $deliveryStatus = true;
                // continue;
            }
        }
    }

    //  dd($deliveryStatus);

    if ($deliveryStatus) {
        //-----------------------------------------------------------
        // inserter to parking array
        // $inserted = array(["Place", "Reg number", "Name", "Vehicle type", "Check-in time"]);
        $checkOutTime = time();
        // $time = $checkInTime - $checkOutTime;

        $datetime_1 = date($format, $checkInTime);
        $datetime_2 = date($format, $checkOutTime);
        $from_time = strtotime($datetime_1);
        $to_time = strtotime($datetime_2);
        // $diff_minutes = round(abs($from_time - $to_time) / 60 / 60,2)  . " minutes";
        $diff_minutes = round(abs($from_time - $to_time) / 60 / 60);
        $time = $diff_minutes;

        if ($vehicleType == 'MC') {
            $bill = $time * 15 . ' kr';
        }
        if ($vehicleType == 'Car') {
            $bill = $time * 25 . ' kr';
        }

        // Remove from userArr
        $deliveryOfVehicle = $u->deliveryOfVehicle($regNum);

        // Remove Vehicle from parkingArr
        $removeVehicle;
        if ($vehicleType == 'Car') {
            $removeVehicle = $p->removeCar($regNum);
        }
        if ($vehicleType == 'MC') {
            $removeVehicle = $p->removeCar($regNum);
        }

        if ($deliveryOfVehicle && $removeVehicle) {
            //Unset SESSION
            session_destroy();
            unset($_SESSION);

            //Set SESSION
            session_start();
            $_SESSION["userName"] = $name;
            $_SESSION["userEmail"] = $email;
            $_SESSION["userPassword"] = $password;
            
            $_SESSION["dRegNum"] = $regNum ;
            $_SESSION["dVehicleType"] = $vehicleType ;
            $_SESSION["dCheckIn"] = date($format, $checkInTime);
            $_SESSION["dCheckOut"] = date($format, $checkOutTime);
            $_SESSION["dTime"] = $time . ' hours';
            $_SESSION["dBill"] = $bill;


            //Redirect profile.php
            redirect('account/profile.php?delivered=1');
        }
    }
}




?>



<?php ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../layouts/head.php' ?>
    <title>Delivery of vehicle</title>
</head>

<body onload="">

    <!-- Header Start -->
    <header>
        <!-- Navbar -->
        <?php require_once './layouts/navbar.php' ?>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main>
        <div class=" container">
            <br>
            <br>
            <h1 class="mx-auto w-50">Delivery of vehicle</h1>
            <section class="w-75 m-auto">
                <!-- Form register -->
                <?php if (!$deliveryStatus) { ?>
                    <div class="bg-light p-5 rounded mt-5">
                        <div class="col-10 mx-auto">
                            <?php if (isset($_SESSION["regNum"])) echo '<h4 class="text-info">Vehicle Info</h4>' ?>
                            <hr>
                            <p>
                                <?php if (isset($_SESSION["regNum"])) echo 'Reg Number: ' . $_SESSION["regNum"] ?> <br>
                                <?php if (isset($_SESSION["vehicleType"])) echo 'vehicle type: ' . $_SESSION["vehicleType"] ?> <br>
                            </p>
                            <hr>
                            <!-- Form -->
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 row gx-3 gy-2 align-items-center">
                                <div class="">
                                    <!-- <p>Registration number:</p> -->
                                    <!-- <input type="text" name="regNumber" class="form-control" value="<?= $_SESSION["regNum"] ?>" readonly> -->
                                    <input type="hidden" name="regNumber" class="form-control" placeholder="Your reg-number" value="<?= $_SESSION["regNum"] ?>" readonly>
                                </div>
                                <div class=" ms-auto w-auto mt-3">
                                    <button type="submit" class="btn btn-primary">Leave</button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>

                <!--  Bill Info -->
                <?php if ($deliveryStatus) { ?>
                    <br>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Bill</h4>
                        <p>
                            Reg number: <?= $regNum ?> <br>
                            Name: <?= $name ?> <br>
                            Email: <?= $email ?> <br>
                            Password: <?= $password ?> <br>
                            Vehicle Type: <?= $vehicleType ?> <br>
                            Check-in time: <?= date($format, $checkInTime) ?> <br>
                            Check-out time: <?= date($format, $checkOutTime) ?> <br>
                            Time: <?= $time ?> hours<br>
                            Bill: <?= $bill ?> <br>
                        </p>
                        <hr>
                    </div>
                <?php } ?>
            </section>
        </div>
    </main>
    <!-- Main End -->


    <!-- SweetAlert -->
    <script>
        // Swal.fire({
        //         icon: 'question',
        //         iconHtml: '<i class="fa-solid fa-vial-circle-check">',
        //         iconHtml: '<i class="fa-solid fa-road-lock"></i>',
        //         title: 'Are you sure?',
        //         // title: '<h1 class="title">Are you sure?</h1>',
        //         text: 'Something went wrong!',
        //         footer: '<a href="">Why do I have this issue?</a>',
        //         focusConfirm: false,
        //         showCloseButton: true,
        //         showCancelButton: true,

        //         confirmButtonText: '<i class="fa-solid fa-floppy-disk"></i> Save',
        //         cancelButtonText: '<i class="fa-solid fa-xmark"></i> Cancel',

        //         // Custom Class for Buttons
        //         buttonsStyling: false,
        //         customClass:{
        //             title: 'card-title',
        //             confirmButton:'btn btn-success me-2',
        //             cancelButton: 'btn btn-danger',
        //         }
        //     })
    </script>

    <!-- script src -->
    <?php require_once '../layouts/script-src.php' ?>
</body>

</html>