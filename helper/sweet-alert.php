<!-- Måndag 02-13 -->
<!-- 

-->

<?php

// declare(strict_types=1); // strict requirement

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Document</title>
</head>

<body>

    <h3></h3>


    <?php
    $num = 23;
    $title = 'title Oops...';
    $save = 'Saved!!!!!';
    $saveNot = 'Changes are not saved';
    ?>

    <!-- <script>
        var title = "<?php echo $title; ?>";
        // var title = 'Oops...';
        Swal.fire({
            icon: 'error',
            title: "<?php echo $title; ?>",
            text: 'Something went wrong!',
            footer: '<a href="">Why do I have this issue?</a>'
        })
    </script> -->

    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })


        Swal.fire({
            title: 'Do you want to save the changes?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: '<a href="index1.php">Save</a>',
            denyButtonText: `Don't save`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Toast.fire({
                    icon: 'success',
                    title: 'Signed in successfully'
                })
            } else if (result.isDenied) {
                Toast.fire({
                    icon: 'error',
                    title: ' Signed Noe successfully'
                })
            }
        })
    </script>

        <a href="index1.php"></a>
    <hr>

</body>

</html>