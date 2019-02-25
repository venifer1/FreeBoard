<?php

    session_start();
    $id = $_POST['id'];
    $pw = $_POST['pw'];
    $mysqli = mysqli_connect("localhost", "root", "111111", "test1");

    $check = "SELECT * FROM user_info WHERE userid='$id'";

    $result = $mysqli->query($check);

    if($result->num_rows == 1){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if($row['userpw'] == $pw){
            $_SESSION['userid'] = $id;
            if(isset($_SESSION['userid'])){
                header('Location: ./main.php?page=1');
            }
            else{
                echo "<script>alert(\"세션 저장 실패\"); location.replace('./login.html');</script>";
            }
        }
        else{

            echo "<script>alert(\"아이디나 패스워드를 잘못 입력하였습니다.\"); location.replace('./login.html');</script>";
        }
    }
    else{
        echo "<script>alert(\"아이디나 패스워드를 잘못 입력하였습니다.\"); location.replace('./login.html');</script>";
    }
?>