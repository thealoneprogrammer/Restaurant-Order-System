<?php

session_start();
include('connection.php');

$email_address = $_SESSION['email_address'];
$sql = "SELECT * FROM users WHERE email_address = '$email_address' ";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_array($result);
$user_id = $row['user_id'];

if(isset($_POST['checkout'])){

    $sql = "INSERT INTO managercart SELECT * FROM cart WHERE user_id = '$user_id' AND status = 'inCart' ";
    $results = mysqli_query($conn, $sql);

    $sql = "SELECT * FROM managercart WHERE user_id = '$user_id' AND status = 'inCart' ";
    $result = mysqli_query($conn,$sql);

    while( $row = mysqli_fetch_array($result)){

        $cart_id = $row['cart_id'];

        $sql = "UPDATE cart SET status = 'process' WHERE cart_id = '$cart_id' ";
        $results = mysqli_query($conn, $sql);

    }

        if ($results) {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { sweetAlert("sent"," <b>A request has been sent to the manager please wait to the manager reply</b>","success");';
            echo '}, 500);</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { sweetAlert("Oops...","<b> Error while ordering.Please check your internet coonection!</b>","error");';
            echo '}, 500);</script>';
        }

    }

$sql = "SELECT * FROM foods ORDER BY food_id ASC";
$result = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_array($result)) {
    $food_id = $rows['food_id'];
    if (isset($_POST[$food_id])) {

        $sql = "SELECT * FROM cart WHERE food_id = '$food_id' AND user_id = '$user_id' and status = 'inCart' ";
        $results = mysqli_query($conn, $sql);

        if (mysqli_num_rows($results) > 0) {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { sweetAlert("Warning","<b> You have already added this item to cart!!...</b>","error");';
            echo '}, 500);</script>';
        } else {

            $sql = "SELECT * FROM foods WHERE food_id = '$food_id' ";
            $results = mysqli_query($conn, $sql);

            $row = mysqli_fetch_array($results);
            $food_id = $row['food_id'];
            $food_name = $row['food_name'];
            $price = $row['price'];
            $food_image = $row['food_image'];
            $cat_id = $row['cat_id'];

            $sql = "INSERT INTO cart(`cat_id`,`food_id`,`user_id`,`email_address`,`food_name`,`food_image`,`price`,`status`) VALUES('$cat_id','$food_id','$user_id','$email_address','$food_name','$food_image','$price','inCart') ";
            $results = mysqli_query($conn, $sql);
            if ($results) {
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () { sweetAlert("Added"," <b>You added ' . $food_name . ' to cart</b>","success");';
                echo '}, 500);</script>';
            } else {
                echo '<script type="text/javascript">';
                echo 'setTimeout(function () { sweetAlert("Oops...","<b> Error while adding.Please check your internet coonection!</b>","error");';
                echo '}, 500);</script>';
            }
        }
    }
}

$sql = "SELECT * FROM cart ORDER BY cart_id ASC";
$result = mysqli_query($conn, $sql);

while ($rows = mysqli_fetch_array($result)) {
    $cart_id = $rows['cart_id'] + 100;
    if (isset($_POST[$cart_id])) {
        $cart_id = $cart_id - 100;

        $sql = "SELECT * FROM cart WHERE cart_id = '$cart_id' ";
        $results = mysqli_query($conn, $sql);

        $row = mysqli_fetch_array($results);
        $cart_id = $row['cart_id'];
        $food_name = $row['food_name'];

        $sql = "DELETE FROM cart WHERE cart_id = '$cart_id' ";
        $results = mysqli_query($conn, $sql);

        if ($results) {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { sweetAlert("Removed"," <b>' . $food_name . ' is removed from your cart</b>","success");';
            echo '}, 500);</script>';
        } else {
            echo '<script type="text/javascript">';
            echo 'setTimeout(function () { sweetAlert("Oops...","<b> Error while deleting.Please check your internet coonection!</b>","error");';
            echo '}, 500);</script>';
        }
    }
}

if (isset($_POST['update'])) {

    $sql = "SELECT * FROM cart WHERE status = 'inCart' AND user_id = '$user_id' ORDER BY cart_id ASC";
    $result = mysqli_query($conn, $sql);

    while ($rows = mysqli_fetch_array($result)) {
            
            $cart_id = $rows['cart_id'] + 100;

            $price = $_POST["price-$cart_id"];
            $qty = $_POST["qty-$cart_id"];

            $total_ammount = $price * $qty;
            $tempCart_id = $cart_id-100;
            $sql = "UPDATE cart SET qty = '$qty', price = '$price',total_amount = '$total_ammount' WHERE cart_id = '$tempCart_id' AND status = 'inCart' ";

            $results = mysqli_query($conn,$sql) or die(mysqli_error($conn));

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
    <title>Foodfun | Order</title>

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

    <style>
        .col-md-3 {
            margin-top: 2%;
            margin-bottom: 20%;
            width: 140px;
            height: 160px;
        }

        .cover {
            object-fit: cover;
        }
    </style>

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
                        <a href="index.html"><img src="assets/images/logo/logo.png" alt="logo"></a>
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
                            <li class="active"><a href="index.php">home</a></li>
                            <li><a href="#about">about</a></li>
                            <li><a href="#contact">contact</a></li>
                            <?php 

                            $string = $_SESSION['email_address'];
                            $str_arr = preg_split("/\@/", $string);
                            $sql = "SELECT * FROM cart WHERE user_id = '$user_id' AND status = 'inCart' ";
                            $resultCount = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($resultCount);

                            echo '
                                <li><button class="btn btn-warning" data-toggle="modal" data-target="#cart">cart<span class="badge badge-danger ml-2">' . $count . '</span></button></li>
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
        <!--Dropdown primary-->
        <div class="row" style="margin-top:-20%;margin-left:35%;">
            <div style="width:60%;padding-right:0px;margin-top:-1%;">
                <div class="dropdown">

                    <!--Trigger-->
                    <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">select category</button>

                    <!--Menu-->
                    <div class="dropdown-menu dropdown-primary">
                        <a class="dropdown-item" href="?veg" name="veg">veg</a>
                        <a class="dropdown-item" href="?nonveg" name="nonveg">non-veg</a>
                    </div>
                </div>
            </div>
            <!--/Dropdown primary-->
            <div style="width:40%;padding-left:0px;">
                <form class="form-inline mr-auto" action="order.php" method="post">
                    <div class="row">
                        <div style="width:60%;">
                            <input class="form-control" type="text" name="keyword" placeholder="search">
                        </div>
                        <div style="width:40%;">
                            <button class="btn btn-warning" name="search" href="?search" style="width:10px;height:38px;margin-top:0%;" type="submit"><i class="fa fa-search" style="font-size:15px;" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?php

        if (isset($_GET['veg'])) {
            displayVeg();
        } else if (isset($_GET['nonveg'])) {
            displayNonVeg();
        } else if (isset($_POST['search'])) {
            displaySearch();
        } else {
            displayAll();
        }

        function displayVeg()
        {

            include('connection.php');
            $sql = "SELECT * FROM foods WHERE cat_id = '1' ORDER BY food_id ASC";
            $result = mysqli_query($conn, $sql);

            echo "
        <div class='container'>
            <div class='card-deck'>
                <div class='row' style='width:100%;'>
    ";

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $food_id = $row['food_id'];
                    $food_name = $row['food_name'];
                    $food_image = $row['food_image'];
                    $price = $row['price'];
                    $dep_cost = $row['dep_cost'];

                    echo "
                <div class='col-md-3'>
                <form action='order.php' method='post'>                
                <div class='card mb-4'>
                    <div class='view overlay'>
                        <img class='card-img-top cover img-thumbnail img-fluid' style='height:180px;' src='images/$food_image' alt='Card image cap'>
                        <a href='#!'>
                            <div class='mask rgba-white-slight'></div>
                        </a>
                    </div>
                    <div class='card-body'>
                        <h5 style='color:black;font-weight:bold;text-align:left;'>$food_name</h5>
                        <div class='row'><div class='col'><p class='card-text'><del>&#8377;$dep_cost</del></p></div><div class='col'><p class='card-text'>&#8377;<b>$price</b></p></div></div>
                        <button type='submit' class='btn btn-light-blue btn-md' name='$food_id'>Add to cart <i class='fa fa-cart-arrow-down'></i></button>
                    </div>
                </div>
                </form>
                </div>";
                }
            }
            echo "</div>
        </div>
            </div>
    ";
        }

        function displayNonVeg()
        {

            include('connection.php');

            $sql = "SELECT * FROM foods WHERE cat_id = '2' ORDER BY food_id ASC";
            $result = mysqli_query($conn, $sql);

            echo "
            <div class='container'>
                <div class='card-deck'>
                    <div class='row' style='width:100%;'>
        ";

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $food_id = $row['food_id'];
                    $food_name = $row['food_name'];
                    $food_image = $row['food_image'];
                    $price = $row['price'];
                    $dep_cost = $row['dep_cost'];

                    echo "
                    <div class='col-md-3'>
                    <form action='order.php' method='post'>
                    <div class='card mb-4'>
                        <div class='view overlay'>
                            <img class='card-img-top cover img-thumbnail img-fluid' style='height:180px;' src='images/$food_image' alt='Card image cap'>
                            <a href='#!'>
                                <div class='mask rgba-white-slight'></div>
                            </a>
                        </div>
                        <div class='card-body'>
                            <h5 style='color:black;font-weight:bold;text-align:left;'>$food_name</h5>
                            <div class='row'><div class='col'><p class='card-text'><del>&#8377;$dep_cost</del></p></div><div class='col'><p class='card-text'>&#8377;<b>$price</b></p></div></div>
                            <button type='submit' class='btn btn-light-blue btn-md' name='$food_id'>Add to cart <i class='fa fa-cart-arrow-down'></i></button>
                        </div>
                    </div>
                    </form>
                    </div>";
                }
            }
            echo "</div>
            </div>
                </div>
        ";
        }

        function displaySearch()
        {
                include('connection.php');

                $keyword = $_POST['keyword'];

                $sql = "SELECT * FROM foods WHERE food_name LIKE '%$keyword%'";
                $result = mysqli_query($conn, $sql);

                echo "
            <div class='container'>
                <div class='card-deck'>
                    <div class='row' style='width:100%;'>
            ";

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $food_id = $row['food_id'];
                        $food_name = $row['food_name'];
                        $food_image = $row['food_image'];
                        $price = $row['price'];
                        $dep_cost = $row['dep_cost'];

                        echo "
                    <div class='col-md-3'>
                    <form action='order.php' method='post'>
                    <div class='card mb-4'>
                        <div class='view overlay'>
                            <img class='card-img-top cover img-thumbnail img-fluid' style='height:180px;' src='images/$food_image' alt='Card image cap'>
                            <a href='#!'>
                                <div class='mask rgba-white-slight'></div>
                            </a>
                        </div>
                        <div class='card-body'>
                            <h5 style='color:black;font-weight:bold;text-align:left;'>$food_name</h5>
                            <div class='row'><div class='col'><p class='card-text'><del>&#8377;$dep_cost</del></p></div><div class='col'><p class='card-text'>&#8377;<b>$price</b></p></div></div>
                            <button type='submit' class='btn btn-light-blue btn-md' name='$food_id'>Add to cart <i class='fa fa-cart-arrow-down'></i></button>
                        </div>
                    </div>
                    </form>
                    </div>";
                    }
                }
                echo "</div>
            </div>
                </div>
            ";
        }

        function displayAll()
        {

            include('connection.php');

            $sql = "SELECT * FROM foods ORDER BY food_id ASC";
            $result = mysqli_query($conn, $sql);

            echo "
                <div class='container'>
                    <div class='card-deck'>
                        <div class='row'>
            ";

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $food_id = $row['food_id'];
                    $food_name = $row['food_name'];
                    $food_image = $row['food_image'];
                    $price = $row['price'];
                    $dep_cost = $row['dep_cost'];

                    echo "
                        <div class='col-md-3'>
                        <form action='order.php' method='post'>
                        <div class='card mb-4'>
                            <div class='view overlay'>
                                <img class='card-img-top cover img-thumbnail img-fluid' style='height:180px;' src='images/$food_image' alt='Card image cap'>
                                <a href='#!'>
                                    <div class='mask rgba-white-slight'></div>
                                </a>
                            </div>
                            <div class='card-body'>
                                <h5 style='color:black;font-weight:bold;text-align:left;'>$food_name</h5>
                                <div class='row'><div class='col'><p class='card-text'><del>&#8377;$dep_cost</del></p></div><div class='col'><p class='card-text'>&#8377;<b>$price</b></p></div></div>
                                <button type='submit' class='btn btn-light-blue btn-md' name='$food_id'>Add to cart <i class='fa fa-cart-arrow-down'></i></button>
                            </div>
                        </div>
                        </form>
                        </div>";
                }
            }
            echo "</div>
                </div>
                    </div>
			";
        }
        ?>


    </section>
    <!-- Banner Area End -->

    <!-- Cart Modal -->
    <div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Your cart</h5>
                </div>
                <div class="modal-body">
                    <form id="updateForm" action="order.php" method="post"></form>
                    <table class="table">
                        <thead class="black white-text">
                            <tr>
                                <th scope="col">Food image</th>
                                <th scope="col">food name</th>
                                <th scope="col">price</th>
                                <th scope="col">quantity</th>
                                <th scope="col">total</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>

                        <?php
                        $sql = "SELECT * FROM cart WHERE user_id = '$user_id' AND status = 'inCart' ORDER BY cart_id ASC";
                        $result = mysqli_query($conn, $sql);

                        $grandTotal = 0;
                        
                        echo "<tbody>";

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) {

                                $cart_id = $row['cart_id'];
                                $food_image = $row['food_image'];
                                $food_name = $row['food_name'];
                                $price = $row['price'];
                                $qty = $row['qty'];

                                $total = $price * $qty;

                                $grandTotal += $total;

                                $cart_id = $cart_id + 100;

                                echo "
                                <tr class='item-row'>
                                    <td><img src='images/$food_image' style='width:60px;height:60px;' ></td>
                                    <td><b style='color:black;'>" . $food_name . "</b></td>
                                    <td><b style='color:black;'><input name='price-$cart_id' form='updateForm' class='form-control price' type='text' style='width:70px' value='$price' readonly></b></td>
                                    <td><b style='color:black;'><input name='qty-$cart_id' form='updateForm' class='form-control qty' type='text' style='width:70px' value='$qty' ></b></td>
                                    <td><b style='color:black;'><input form='my_form' class='form-control total'type='text' style='width:70px' value='$total' disabled/></b></td>
                                    <td><form method='post' action='order.php'><button type='submit' class='btn btn-danger' name='$cart_id'><i class='fa fa-trash'></i></a></form></td>
                                </tr>
                            ";
                            }
                        }

                        echo "</tbody>";

                        $sql = mysqli_query($conn,"SELECT * FROM cart WHERE user_id = '$user_id' AND status = 'inCart' ");

                        $result = mysqli_num_rows($sql);

                        if($result>0){
                            echo"
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b style='color:black;font-size:18px;'>Total amount</b><input type='text' class='form-control grandTotal' style='width:70px;' value='$grandTotal' disabled/></td>
                                    <td><button type='submit' form='updateForm' name='update' class='btn btn-success'>update</button></td>
                                    <td><form action='order.php' method='post'><button type='submit' name='checkout' class='btn btn-success'><b style='color:black;'>order</b></button></form></td>
                                </tr>
                            </tfoot>
                        </table>";
                        }else{

                            echo"
                                <tfoot>
                                <tr>
                                <th>
                                <b style='font-size:20px;text-align:center;'>cart is empty</b>                                                                                            
                                </th>
                                </tr>
                                </tfoot>
                                </tbody>
                                </table>";
                        }

                        ?>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

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
    <script>
        $(document).ready(function(){
            $(".qty").keyup(function(){
                var qty = parseInt($(this).val());

                var itemRow = $(this).parents('.item-row')[0];
                var priceField = $(itemRow).find('.price')[0];
                var totalField = $(itemRow).find('.total')[0];

                var price = $(priceField).val();

                qty = (qty == null || qty == "" || isNaN(qty)) ? 0 : qty;
                price = (price == null || price == "" || isNaN(price)) ? 0 : price;
                
                total = qty * price;
                $(totalField).val(total);
                
                grandTotal();
            })

            function grandTotal() {
                var totalFields = $('.total');
                var total = 0;
                totalFields.each(function(i, e) {
                    total += parseInt($(e).val());
                });
                $('.grandTotal').val(total);
            }
        })
    </script>

</body>

</html> 