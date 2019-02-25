<?php

    session_start();

    if(!isset($_SESSION['userid'])){
        header ('Location: ./login.html');
    }

    $title = $_POST['title'];
    $author = $_SESSION['userid'];
    $content = $_POST['content'];

    $date = date('Y/m/d H:i:s');

    $tmpfile =  $_FILES['file']['tmp_name'];
    $o_name = $_FILES['file']['name'];
    $filename = iconv("UTF-8", "EUC-KR",$_FILES['file']['name']);
    $folder = "./upload/".$filename;

    move_uploaded_file($tmpfile,$folder);



    /*title*/
    if(mb_strlen($title, 'utf-8') == 0){
        echo "<script>alert(\"게시판 제목을 입력하세요.\"); window.history.go(-1); </script>";
        exit();
    }

    if(mb_strlen($title, 'utf-8') > 100){
        echo "<script>alert(\"게시판 제목은 100자 이상 입력할 수 없습니다.\"); window.history.go(-1); </script>";
        exit();
    }

    $mysqli = mysqli_connect("localhost","root","111111","test1");
    $write_update = mysqli_query($mysqli, "INSERT INTO board (no,title,author,content,date,hit,file) VALUES (null,'$title','$author','$content','$date','0','$o_name')");

    if($write_update){
        echo "<script>alert(\"글 작성을 완료하였습니다.\"); location.replace('./main.php');</script>";
    }

?>