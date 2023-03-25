<?php
//require Files
require_once '../functions/helpers.php';
require_once '../Class/User.php';

// (A) START SESSION
session_start();
// (C) REDIRECT TO HOME PAGE IF SIGNED IN - SET YOUR OWN !
if (isset($_SESSION["userName"])) {
    redirect('index.php');
}


// -------------------------------------------------------
$filePath = '../files/users.csv';
$user = new User($filePath);

// CSV file to read into an Array
$userArray = $user->userArr;
$userArrayLength = count($userArray);



// -------------------------------------------------------
// REQUEST_METHOD POST FORM
$emailErr = $passwordErr = $err = "";
$email = $password = $name = "";
$loginStatus = false;

// REQUEST_METHOD POST FORM TEST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    # 1- Email Test Start
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            for ($row = 0; $row < $userArrayLength - 1; $row++) {
                if ($email == $userArray[$row][1]) {
                    $err = "";
                    break;
                }
                $err = 'Email or Password is false!!';
            }
            # 2- Password Test Start
            if ($err == '') {
                if (empty($_POST["password"])) {
                    $passwordErr = "Password is required";
                } else {
                    $password = test_input($_POST["password"]);

                    for ($row = 0; $row < $userArrayLength - 1; $row++) {
                        if ($password == $userArray[$row][2]) {
                            $user->login($email, $password);
                            $name = $user->getName();
                            $err = "";
                            break;
                        }
                        $err = "Email or Password is false!!";
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
    <title>Login</title>
</head>

<body onload="">

    <!-- Header Start -->
    <header>
        <!-- Navbar -->
        <?php //require_once '../layouts/navbar.php' 
        ?>
    </header>
    <!-- Header End -->

    <!-- Main Start -->
    <main>
        <div class=" container">
            <br>
            <br>
            <!-- Form Login -->
            <section class="mx-auto mt-3" style="width: 300px;">
                <h1 class="">Login</h1>

                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4 row gx-3 gy-2 align-items-center">
                    <span class=" text-danger "><?php echo $err ?></span>
                    <div class="">
                        <label class="visually-hidden" for="specificSizeInputEmail">Email</label>
                        <input type="email" name="email" class="form-control" id="specificSizeInputEmail" placeholder="Your email" value="<?php if (!$loginStatus) {
                                                                                                                                                echo $email;
                                                                                                                                            } ?>">
                        <span class=" text-danger "><?php echo  $emailErr ?></span>
                    </div>
                    <div class="">
                        <label class="visually-hidden" for="specificSizeInputPassword">Password</label>
                        <input type="password" name="password" class="form-control" id="specificSizeInputPassword" placeholder="Your Password" value="<?php if (!$loginStatus) {
                                                                                                                                                            echo $password;
                                                                                                                                                        } ?>">
                        <span class=" text-danger "><?php echo  $passwordErr ?></span>
                    </div>
                    <div class="">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="autoSizingCheck2">
                            <label class="form-check-label" for="autoSizingCheck2">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="w-100 btn btn-primary">Login</button>
                    </div>
                </form>
                <div class="mt-2 ms-auto " style="width: 130px;">
                    <a href="" class="text-black-50">Forget Password?</a>
                </div>
                <div class="mt-4">
                    Need an account? <a href="<?= asset('/auth/register.php') ?>" class="text-black">SING UP</a>
                </div>
                <div class="mt-4 ">
                    <a href="<?= asset('index.php') ?>" class="btn  btn-outline-secondary  w-100">Go Home</a>
                </div>

            </section>
        </div>
    </main>
    <!-- Main End -->





</body>

</html>