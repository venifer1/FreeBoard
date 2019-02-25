<?php

    include "./listDB.php";


    if(!isset($_SESSION['userid'])){
        header ('Location: ./login.html');
    }

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }



?>