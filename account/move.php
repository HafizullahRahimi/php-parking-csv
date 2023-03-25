<?php
//require Files
require_once '../functions/helpers.php';
require_once '../Class/User.php';
require_once '../Class/Parking.php';

//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

// START SESSION
session_start();

// echo 'Move a vehicle page';
?>


<?php ?>



<?php
//-----------------------------------------------------------
$vehicleType = $_SESSION["vehicleType"];
$freePlaceArr = array();

$regNum = $place = $part ="";
$moveStatus = false;

// Parking Class
$filePathParking = '../files/parking.csv'; // users.csv File Path
$p = new Parking($filePathParking); // New Object from Parking Class
$freeCarArr = $p->getFreePlacesForCar();
$freeMCArr = $p->getFreePlacesForMC();

if ($vehicleType == 'Car') {
    $freePlaceArr =  $p->getFreePlacesForCar();
} else {
    $freePlaceArr =  $p->getFreePlacesForMC();
}

// dd($freePlaceArr);

// REQUEST_METHOD = POST 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // echo 'ttttt' ;
    if (!empty($_POST["regNum"])) {
        $regNum = test_input($_POST["regNum"]);
        if ($vehicleType == 'Car') {
            $place = test_input($_POST["place"]);
            $p->moveCar($regNum, $place);
        } else {
            $index = test_input($_POST["index"]);

            $place = $freePlaceArr[$index][0];
            $part = $freePlaceArr[$index][1];

            $p->moveMC($regNum,$place,$part);

        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../layouts/head.php' ?>
    <title>Move a vehicle</title>
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
            <h1 class="mx-auto w-50">Move a vehicle</h1>
            <section class="w-100 m-auto">
                <h3 class="mt-4 ">New Place:</h3>
                <!-- Form register -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class=" row gx-3 gy-2 align-items-center">
                    <input type="hidden" name="regNum" class="form-control" id="specificSizeInputName" placeholder="Your reg-number" value="<?= $_SESSION["regNum"] ?>">

                    <!-- Radio toggle buttons  -->
                    <?php if ($vehicleType == 'Car') {
                        foreach ($freePlaceArr as $key) {
                    ?>
                            <input type="radio" class="btn-check" name="place" id="option<?= $key ?>" autocomplete="off" value="<?= $key ?>">
                            <label class="btn btn-outline-primary col-3" for="option<?= $key ?>">place <?= $key ?></label>
                        <?php }
                    } else {
                        for ($i = 0; $i < count($freePlaceArr); $i++) {  ?>
                            <input type="radio" class="btn-check" name="index" id="option<?= $freePlaceArr[$i][0] . $freePlaceArr[$i][1] ?>" autocomplete="off" value="<?= $i ?>">
                            <label class="btn btn-outline-primary col-2" for="option<?= $freePlaceArr[$i][0] . $freePlaceArr[$i][1] ?>">place <?= $freePlaceArr[$i][0] . '-' . $freePlaceArr[$i][1] ?></label>
                    <?php }
                    } ?>

                    <br>
                    <div class="ms-auto w-25 mt-3 mt-4">
                        <button type="submit" class="btn btn-primary col-12">Move</button>
                    </div>
                </form>
                <br>


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