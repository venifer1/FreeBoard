<?php

    include "./listDB.php";
    if(!isset($_SESSION['userid'])){
        header ('Location: ./login.html');
    }

    $no = $_GET['no'];
    $sql = mq("select * from board where no = '".$no."'");

    $board = $sql->fetch_array();

    $str = strcmp($_SESSION['userid'],$board['author']);

    if($str){
        echo "<script>alert(\"삭제할 권한이 없습니다.\");  </script>";
    }
    else{
        $delete= mysqli_query($db, "DELETE FROM board WHERE no='".$no."'");

        if($delete){
            echo "<script>alert(\"글 삭제를 완료하였습니다.\"); location.replace('./main.php');</script>";
        }
    }
?>