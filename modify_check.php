<?php

    include "./listDB.php";
    if(!isset($_SESSION['userid'])){
        header ('Location: ./login.html');
    }

    $no = $_GET['no'];

    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }
    else{
        $page = 1;
    }

    $sql = mq("select * from board where no = '".$no."'");

    $board = $sql->fetch_array();

    $str = strcmp($_SESSION['userid'],$board['author']);

    if($str){
        echo "<script>alert(\"수정할 권한이 없습니다.\"); window.history.go(-1); </script>";
    }
    else{
        echo "<script>location.replace('./modify.php?no=".$board['no']."&page=".$page."');</script>";
    }

?>
