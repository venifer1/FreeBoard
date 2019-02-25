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

    $title = $_POST['title'];
    $author = $_SESSION['userid'];
    $content = $_POST['content'];


    $tmpfile =  $_FILES['file']['tmp_name'];
    $o_name = $_FILES['file']['name'];
    $filename = iconv("UTF-8", "EUC-KR",$_FILES['file']['name']);
    $folder = "./upload/".$filename;

    move_uploaded_file($tmpfile,$folder);


    $board = $sql->fetch_array();


    if(mb_strlen($title, 'utf-8') == 0){
        echo "<script>alert(\"게시판 제목을 입력하세요.\"); window.history.go(-1); </script>";
        exit();
    }

    if(mb_strlen($title, 'utf-8') > 100){
        echo "<script>alert(\"게시판 제목은 100자 이상 입력할 수 없습니다.\"); window.history.go(-1); </script>";
        exit();
    }

    $modify_update = mysqli_query($db, "UPDATE board SET title='".$title."', content='".$content."', file='".$o_name."' WHERE no='".$board['no']."'");

    if($modify_update){
        echo "<script>alert(\"글 수정을 완료하였습니다.\"); location.replace('./read.php?no=".$board['no']."&page=".$page."'); </script>";
    }

?>