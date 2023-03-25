<?php
//require Files
require_once './functions/helpers.php';

//The Current Page Filename
$current_page_name = basename($_SERVER['PHP_SELF'], 'php');

// echo 'Find a vehicle page';

?>


<!-- POST -->
<?php
$nameErr = $emailErr = $passwordErr = $err = "";
$name = $email = $password = "";
$registerStatus = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # 1- Name Test Start
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }
        # Name Test End
        # 2- Email Test Start
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            } else {
                for ($row = 0; $row < $arrLength - 1; $row++) {
                    //echo $csvArray[$row][1];
                    if ($email == $csvArray[$row][1]) {
                        $err = "The email has already been taken!!";
                        break;
                    } else $err = '';
                }
                # Email Test End
                # 3- Password Test Start
                if ($err == '') {
                    if (empty($_POST["password"])) {
                        $passwordErr = "Password is required";
                        # Password Test End
                    } else {
                        $password = test_input($_POST["password"]);
                        append_input_data($name, $email, $password);
                        $registerStatus = true;
                    }
                }
            }
        }
    }
}

//Append input data to the users.csv 
function append_input_data($name, $email, $password)
{
    // 4- Append data
    $data = array($name, $email, $password);
    // Open file in append mode
    $fp = fopen('./files/users.csv', 'a');
    // Append input data to the file  
    fputcsv($fp, $data, ';');
    // close the file
    fclose($fp);
}
?>









<?php ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once './layouts/head.php' ?>
    <title>Find a vehicle</title>
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
            <h1 class="mx-auto w-50">Find a vehicle</h1>
            <section class="w-50 m-auto">
                <!-- Form register -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 row gx-3 gy-2 align-items-center">
                    <span class=" text-danger "><?php echo $err ?></span>
                    <div class="">
                        <p>Registration number:</p>
                        <input type="name" name="regNumber" class="form-control" id="specificSizeInputName" placeholder="Your reg-number" value="<?php if (!$registerStatus) {
                                                                                                                                            echo $name;
                                                                                                                                        } ?>">
                        <span class=" text-danger "><?php echo  $nameErr ?></span>
                    </div>

                    <div class=" ms-auto w-auto mt-3">
                        <button type="submit" class="btn btn-primary">Find</button>
                    </div>
                </form>
                <br>
                <!--  User Info -->
                <?php if ($registerStatus) { ?>
                    <br>
                    <div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">Register done!</h4>
                        <p>Name: <?php echo $name ?> <br>
                            Email: <?php echo $email ?> <br>
                            Password: <?php echo $password ?>
                        </p>
                        <hr>
                        <a class="" href="./index.php" class="alert-link mr-auto">Go To Home</a>
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

    <!-- Bootstrap js -->
    <script src="<?= asset('assets/js/bootstrap.js') ?>"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js" integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD" crossorigin="anonymous"></script> -->

    <script src="<?= asset('assets/js/main.js') ?>"></script>
</body>

</html>