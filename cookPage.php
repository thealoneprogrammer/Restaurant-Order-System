<?php

session_start();

include('connection.php');

$email_address = $_SESSION['email_address'];
$sql = "SELECT * FROM users WHERE email_address = '$email_address' ";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
$user_id = $row['user_id'];

$sql = "SELECT * FROM cookcart WHERE status = 'inCart' ";
$result = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_array($result)) {
    
    $food_name = $rows['food_name'];
    $cart_id = $rows['cart_id'];
    $user_name = $rows['email_address'];

    $str_arr = preg_split("/\@/", $user_name);

    if (isset($_POST[$cart_id])) {

        $sql = "UPDATE cookcart SET status = 'outCart' WHERE cart_id = '$cart_id' ";
        mysqli_query($conn,$sql);

        $sql = "UPDATE managercart SET status = 'outCart' WHERE cart_id = '$cart_id' ";
        $results = mysqli_query($conn,$sql);

        if ($results) {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { sweetAlert("Success"," <b>' .$food_name. ' of user '.$str_arr[0].' is ready and request sent to manager.</b>","success");';
            echo '}, 500);</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { sweetAlert("Oops...","<b> Error while sending.Please check your internet coonection!</b>","error");';
            echo '}, 500);</script>';
        }

    }
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Page Title -->
    <title>Foodfun | Manager</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/animate-3.7.0.css">
    <link rel="stylesheet" href="assets/css/bootstrap-4.1.3.min.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/css/mdb.min.css" rel="stylesheet">
    <!-- sweetalert css cdn -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.11/dist/sweetalert2.min.css">

</head>

<body>

    <!-- Preloader Starts -->
    <div class="preloader">
        <div class="spinner"></div>
    </div>
    <!-- Preloader End -->

    <!-- Header Area Starts -->
    <header class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo-area">
                        <a href="#"><img src="assets/images/logo/logo.png" alt="logo"></a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="custom-navbar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    <div class="main-menu">
                        <ul>
                            <?php
                             $string = $_SESSION['email_address'];
                             $str_arr = preg_split("/\@/", $string);

                             $sql = "SELECT * FROM cookcart WHERE status = 'inCart' ";
                             $result = mysqli_query($conn,$sql);

                             $count = mysqli_num_rows($result);

                            echo '
                                <li style="font-size:20px;color:black;font-weight:bold;"> Cook Section</li>;
                                <li><button class="btn btn-warning fa fa-user"><i class="badge badge-danger ml-2">'.$count.'</i></button></li>
                                <li class="dropdown">
                                    <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $str_arr[0] . '</button>
                                    <div class="dropdown-menu dropdown-primary">
                                        <a class="dropdown-item" href="logout.php">logout</a>
                                    </div>
                                </li>';
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->

    <!-- Banner Area Starts -->
    <section class="banner-area text-center">

        <div class="alert alert-primary" role="alert" style='margin-left:5%;margin-right:5%;margin-top:-15%;font-size:18px;font-weight:bold;'>
            <b style="color:black;">All orders</b>
        </div><br><br>

        <?php 

        include('connection.php');

        $sql = "SELECT * FROM cookcart WHERE status = 'inCart' ";
        $result = mysqli_query($conn, $sql);

        echo "
        <div class='card' style='margin-left:5%;margin-right:5%;'>
            <h3 class='card-header text-center font-weight-bold text-uppercase py-4'>All Order list</h3>
            <div class='card-body'>
                <div id='table' class='table-editable'>
                    <table class='table table-bordered table-responsive-md table-striped text-center'>
                        <tr>
                            <th class='text-center'>food image</th>
                            <th class='text-center' style='font-weight:bold;font-size:18px;'>food name</th>
                            <th class='text-center' style='font-weight:bold;font-size:18px;'>customer name</th>
                            <th class='text-center' style='font-weight:bold;font-size:18px;'>quantity</th>
                            <th></th>
                        </tr>
        ";

        while ($row = mysqli_fetch_array($result)) {
            $qty = $row['qty'];
            $food_id = $row['food_id'];
            $food_image = $row['food_image'];
            $username = $row['email_address'];

            $str_arr = preg_split("/\@/", $username);

            echo "
                <form method='post' action='cookPage.php'>
                    <tr>
                        <td class='pt-3-half' ><img src='images/$food_image' style='width:60px;height:60px;'></td>
                        <td class='pt-3-half' style='font-weight:bold;font-size:16px;'>" . $row['food_name'] . "</td>
                        <td class='pt-3-half' style='font-weight:bold;font-size:16px;'>" . $str_arr[0] . "</td>
                        <td class='pt-3-half' style='font-weight:bold;font-size:16px;'>$qty</td>
                        <td>
                            <span><button type='submit' name='$cart_id' class='btn btn-success btn-rounded btn-sm my-0'>Ready <i class='fa fa-check'></i></button></span>
                        </td>
                    </tr>
                </form>      
            ";
        }
        echo "
                </table>
            </div>
        </div>
    </div>
";
        ?>

    </section>
    <!-- Banner Area End -->

    <!-- Footer Area Starts -->
    <footer class="footer-area" id="contact">
        <div class="footer-widget section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="single-widget single-widget1">
                            <a href="index.html"><img src="assets/images/logo/logo2.png" alt=""></a>
                            <p class="mt-3"> Food fun is a great place for everyone to have a great meal very easily.It provides a very quick delivery service and amazing bunch of dishes at cheap prices.Enjoy your meals at your own place of comfort!!</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="single-widget single-widget2 my-5 my-md-0">
                            <h5 class="mb-4">contact us</h5>
                            <div class="d-flex">
                                <div class="into-icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="info-text">
                                    <p>xyz road 2nd cross,xyz-575007</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="into-icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="info-text">
                                    <p>(+91) 9876543210</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="into-icon">
                                    <i class="fa fa-envelope"></i>
                                </div>
                                <div class="info-text">
                                    <p>foodfun@gmail.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="single-widget single-widget3">
                            <h5 class="mb-4">opening hours</h5>
                            <p>Monday ...................... Closed</p>
                            <p>Tue-Fri .............. 10 am - 12 pm</p>
                            <p>Sat-Sun ............... 8 am - 11 pm</p>
                            <p>Holidays ............. 10 am - 12 pm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <span>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#" target="_blank">foodfun</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></span>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="social-icons">
                            <ul>
                                <li class="no-margin">Follow Us</li>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.7.3/js/mdb.min.js"></script>
    <!-- sweetalert js cdn -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.11/dist/sweetalert2.min.js"></script>
    <script src="assets/js/vendor/wow.min.js"></script>
    <script src="assets/js/vendor/owl-carousel.min.js"></script>
    <script src="assets/js/vendor/jquery.datetimepicker.full.min.js"></script>
    <script src="assets/js/vendor/jquery.nice-select.min. js"></script>
    <script src="assets/js/main.js"></script>


</body>

</html> 