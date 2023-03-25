<?php
require_once '../functions/helpers.php';
// require_once '../Class/User.php';
//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], '.php');


// START SESSION
session_start();

// // New Object from User Class
// $filePathUsers = '../users.csv'; // users.csv File Path
// $u = new User($filePathUsers);

// // $u->setAtt();


$signedAlert = false;
$registeredAlert = false;
$deliveredAlert = false;

// REQUEST_METHOD GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {

    if (empty($_GET['signed'])) $signedAlert  = false;
    else  $signedAlert  = true;

    if (empty($_GET['registered'])) $registeredAlert = false;
    else  $registeredAlert = true;

    if (empty($_GET['delivered'])) $deliveredAlert = false;
    else  $deliveredAlert = true;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../layouts/head.php' ?>
    <title>Profile</title>
</head>

<body>
    <!-- Header Start -->
    <header>
        <?php if ($signedAlert || $registeredAlert || $deliveredAlert) {
            echo '<div class="Header-top col-8 mx-auto"><h1 class="my-4 w-25 mx-auto ">Profile</h1></div>';
        } ?>

        <?php ?>
        <!-- Navbar -->
        <?php require_once './layouts/navbar.php' ?>
    </header>
    <!-- Header End -->
    <div class=" container">
        <!--  User Info -->
        <div class=" mt-5">
            <div class="col-10 mx-auto">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <a type="button" class="btn btn-primary position-relative">
                                    Info
                                    <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                                        <span class="visually-hidden">New alerts</span>
                                    </span>
                                </a>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="bg-light p-5 rounded mt-1">
                                    <div class="col-10 mx-auto">
                                        <h1 class="text-info">User Info</h1>
                                        <hr>
                                        <p>
                                            Name: <?= $_SESSION["userName"]; ?> <br>
                                            Email: <?= $_SESSION["userEmail"] ?> <br>
                                            Password: <?= $_SESSION["userPassword"] ?>
                                        </p>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed position-relative" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <a type="button" class="btn btn-primary ">
                                    Vehicle<span class="badge text-bg-secondary ms-2"> <i class="fa-solid fa-motorcycle "></i></span>
                                </a>
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="bg-light p-5 rounded mt-1">
                                    <div class="col-10 mx-auto">
                                        <?php if (isset($_SESSION["regNum"])) { ?>
                                            <h4 class="text-info">Vehicle Info</h4>
                                            <hr>
                                            <p>
                                                <?php if (isset($_SESSION["regNum"])) echo 'Reg Number: ' . $_SESSION["regNum"] ?> <br>
                                                <?php if (isset($_SESSION["vehicleType"])) echo 'vehicle type: ' . $_SESSION["vehicleType"] ?> <br>
                                                <?php if (isset($_SESSION["place"])) echo 'Place: ' . $_SESSION["place"] ?> <br>
                                                <?php if (isset($_SESSION["part"])) echo 'Part: ' . $_SESSION["part"] ?>
                                            </p>
                                        <?php } ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item ">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <a type="button" class="btn btn-primary position-relative">
                                    Bill
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill  bg-danger">
                                        99+
                                        <span class="visually-hidden">unread messages</span>
                                    </span>
                                </a>
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="bg-light p-5 rounded mt-1">
                                    <div class="col-10 mx-auto">
                                        <?php if (isset($_SESSION["dRegNum"])) { ?>
                                            <hr>
                                            <h4 class="text-info">Bill Info</h4>
                                            <p>
                                                Reg Number: <?= $_SESSION["dRegNum"] ?> <br>
                                                VehicleType: <?= $_SESSION["dVehicleType"] ?> <br>
                                                CheckIn: <?= $_SESSION["dCheckIn"] ?> <br>
                                                CheckOut: <?= $_SESSION["dCheckOut"] ?> <br>
                                                Time: <?= $_SESSION["dTime"] ?> <br>
                                                Bill: <?= $_SESSION["dBill"] ?> <br>
                                            </p>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>



    <!-- Sweet Alert Script -->
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-start',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })


        function showSignedAlert() {
            Toast.fire({
                icon: 'success',
                title: 'Signed in successfully'
            })
        }

        function showRegisteredAlert() {
            Toast.fire({
                icon: 'success',
                title: 'Registered in successfully'
            })
        }

        function showDeliveredAlert() {
            Toast.fire({
                icon: 'success',
                title: 'Delivered in successfully'
            })
        }
    </script>
    <!-- Sweet Alert Control -->
    <?php
    if ($signedAlert) {
        echo '<script>showSignedAlert()</script>';
    }
    if ($registeredAlert) {
        echo '<script>showRegisteredAlert()</script>';
    }

    if ($deliveredAlert) {
        echo '<script>showDeliveredAlert()</script>';
    }
    ?>
    <!-- <script>ShowAlert()</script> -->


    <!-- script src -->
    <?php require_once '../layouts/script-src.php' ?>
</body>

</html>