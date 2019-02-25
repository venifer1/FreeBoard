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

    if(isset($_POST['content'])){
        $content = $_POST['content'];
    }
    else{
        echo '안됨';
    }

    $no = $_GET['no'];
    $con_no = $_GET['no'];
    $author = $_SESSION['userid'];
    $date = date('Y/m/d H:i:s');

    $sql2 = mq("insert into reply(con_no,author,content,date) values ('$no','$author','$content','$date');");


    if($sql2){
        echo "<script>location.replace('./read.php?no=".$no."&page=".$page."');</script>";
    }

?>