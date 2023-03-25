<?php
//require Files
require_once './functions/helpers.php';
require_once './Class/Parking.php';

//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

//Time Zone Sweden
date_default_timezone_set("Europe/Stockholm");
$format = "Y/m/d H:i:s"; //2023/02/07 18:48:54


//-----------------------------------------------------------
$pathFile = './files/parking.csv';
$p = new Parking($pathFile);
$parkingArr = $p->parkingArr;
$arrLength = count($parkingArr);


// CSV file to read into an Array
// $parkingArr = csvToArray($pathFile);
// $arrLength = count($parkingArr);

// echo $pathFile;
//-----------------------------------------------------------
// session_start();

if (isset($_SESSION["userName"])) {

    echo $_SESSION["userName"];
    echo $_SESSION["userEmail"];
}

?>
<?php ?>


<!-- Prague parking HTML-->
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once './layouts/head.php' ?>
    <title>Home</title>
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
            <h1>Places:</h1>
            <section class="d-flex flex-wrap flex-row w-100 mx-auto">
                <!-- Place card -->
                <?php for ($row = 1; $row < $arrLength - 1; $row++) { ?>
                    <div class=" col-lg-3 col-md-4 col-sm-6 ">
                        <div class="card mx-1 my-2  <?php if ($parkingArr[$row][0] !== 'free') echo 'text-bg-info' ?>">
                            <!-- <img src="./assets/images/robot.jpg" class="card-img-top" alt="..."> -->
                            <div class="card-body">
                                <h5 class="card-title"><?= $row ?> </h5>
                                <p class="card-text">
                                    Name: <?= $parkingArr[$row][2] ?> <br>
                                    RegNum: <?= $parkingArr[$row][1] ?>
                                </p>
                                <!-- <a href="<?= 'admin/index.php?user_id=' . $row ?>" class="btn btn-primary">Go somewhere</a> -->
                            </div>
                        </div>
                    </div>
                <?php } ?>


                <!-- test -->
                <div class=" col-lg-3 col-md-4 col-sm-6 ">
                    <div class="card mx-1 my-2 pt-0">
                        <h4 class="ms-2 mt-1">
                            <span class="badge bg-dark-subtle">10 </span>
                            <span class="badge bg-info">1 <i class="fa-solid fa-car-side"></i></span>
                            <span class="badge bg-info">2 <i class="fa-solid fa-motorcycle"></i></span>
                        </h4>
                        <div class="card-body">
                            <div class="list-group ">
                                <a href="#" class="list-group-item list-group-item-action bg-info" aria-current="true">
                                    <div class="d-flex w-100 justify-content-between ">
                                        <h5 class="mb-1">1 </h5>
                                        <button class="btn border position-relative text-white ">
                                            Ali Rahimi
                                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle d-none"></span>
                                        </button>
                                        <!-- Active User -->
                                        <!-- <button class="btn border position-relative  text-white border-0 bg-primary">
                                            Ali Rahimi
                                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                                        </button> -->
                                    </div>
                                    <p class="mt-3 d-none">RegNum: R500 </p>
                                </a>
                                <!-- Free Place Part -->
                                <a href="#" class="list-group-item list-group-item-action " aria-current="true">
                                    <div class="d-flex w-100 justify-content-between ">
                                        <h5 class="mb-1">2</h5>
                                        <button class="btn border position-relative bg-primary text-white border-0 d-none">
                                            Ali Rahimi
                                            <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                                        </button>
                                    </div>
                                    <!-- <p class="mt-4">RegNum: R500 </p> -->
                                    <p class="mt-4">Free </p>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

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
    <?php require_once './layouts/script-src.php' ?>
</body>

</html>