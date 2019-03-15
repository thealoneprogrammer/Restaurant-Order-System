<?php

    $conn = mysqli_connect('localhost','root','','foodfun');

    if(!$conn){
        echo "Error While connecting to server please try again..!!!".mysqli_error($conn);
    }


?>