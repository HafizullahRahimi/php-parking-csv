<?php
//require Files
require_once '../functions/helpers.php';
require_once '../Class/User.php';

// -------------------------------------------------------
$filePath = '../files/users.csv';
$user = new User($filePath);  // Object from User Class



$nameErr = $emailErr = $passwordErr = $err = "";
$name = $email = $password = "";
$registerStatus = false;

// REQUEST_METHOD POST
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
                // for ($row = 0; $row < $arrLength - 1; $row++) {
                //     //echo $csvArray[$row][1];
                //     if ($email == $csvArray[$row][1]) {
                //         $err = "The email has already been taken!!";
                //         break;
                //     } else $err = '';
                // }
                # Email Test End
                # 3- Password Test Start
                if ($err == '') {
                    if (empty($_POST["password"])) {
                        $passwordErr = "Password is required";
                        # Password Test End
                    } else {
                        $password = test_input($_POST["password"]);
                        $user->register($name, $email, $password); // Run register()
                        $registerStatus = true;
                    }
                }
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Head  -->
    <?php require_once '../layouts/head.php' ?>
    <title>Register</title>
</head>

<body onload="">

    <!-- Header Start -->
    <header>
        <!-- Navbar -->
        <?php //require_once '../layouts/navbar.php' ?>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main>
        <div class=" container">
            <br>
            <br>
            <section class="mx-auto mt-3" style="width: 300px;">
                <h1>Register</h1>
                <!-- Form register -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 row gx-3 gy-2 align-items-center">
                    <span class=" text-danger "><?php echo $err ?></span>
                    <div class="mb-1">
                        <label class="mb-1" for="specificSizeInputName">Name</label>
                        <input type="name" name="name" class="form-control" id="specificSizeInputName" placeholder="Your name" value="<?php if (!$registerStatus) {
                                                                                                                                            echo $name;
                                                                                                                                        } ?>">
                        <span class=" text-danger "><?php echo  $nameErr ?></span>
                    </div>
                    <div class="mb-1">
                        <label class="mb-1" for="specificSizeInputEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="specificSizeInputEmail" placeholder="Your email" value="<?php if (!$registerStatus) {
                                                                                                                                                echo $email;
                                                                                                                                            } ?>">
                        <span class=" text-danger "><?php echo  $emailErr ?></span>
                    </div>
                    <div class="mb-1">
                        <label class="mb-1" for="specificSizeInputPassword">Password</label>
                        <input type="password" name="password" class="form-control" id="specificSizeInputPassword" placeholder="Your Password" value="<?php if (!$registerStatus) {
                                                                                                                                                            echo $password;
                                                                                                                                                        } ?>">
                        <span class=" text-danger "><?php echo  $passwordErr ?></span>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </div>
                    <div class="mt-4">
                        Already a user <a href="<?= asset('/auth/login.php') ?>" class="text-black">LOGIN</a>
                    </div>
                    <div class="mt-4 " >
                        <a href="<?= asset('index.php') ?>" class="btn  btn-outline-secondary  w-100">Go Home</a>
                    </div>

                </form>
            </section>
        </div>
    </main>
    <!-- Main End -->

    <script src="<?= asset('assets/js/bootstrap.js') ?>"></script>
    <script src="<?= asset('assets/js/main.js') ?>"></script>
</body>

</html>