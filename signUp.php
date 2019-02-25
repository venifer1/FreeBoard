<?php
    $id = $_POST['id'];
    $pw = $_POST['pw'];
    $pwc = $_POST['pwc'];
    $name = $_POST['name'];
    $email = $_POST['email'];


    /*id*/
    if(mb_strlen($id, 'utf-8') > 25){
        echo "<script>alert(\"아이디는 25자 이상 입력할 수 없습니다.\"); window.history.go(-1);</script>";
        exit();
    }
    if(preg_match("/[!#$%^&*()?+=\/]/", $id) || strpos($id, " ") !== false){
        echo "<script>alert(\"아이디에 특수문자나 공백이 포함될 수 없습니다.\"); window.history.go(-1);</script>";
        exit();
    }

    if(preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $id)){
        echo "<script>alert(\"아이디에 한글은 포함될 수 없습니다.\"); window.history.go(-1);</script>";
        exit();
    }


    /*pw*/
    if(mb_strlen($pw, 'utf-8') < 6 || mb_strlen($pw, 'utf-8') > 12){
        echo "<script>alert(\"6~12자리 비밀번호만 가능합니다.\"); window.history.go(-1);</script>";
        exit();
    }

    if(preg_match("/[!#$%^&*()?+=\/]/", $pw) || strpos($pw, " ") !== false){
        echo "<script>alert(\"비밀번호에 특수문자나 공백이 포함될 수 없습니다.\"); window.history.go(-1);</script>";
        exit();
    }

    if($pw != $pwc){
        echo "<script>alert(\"패스워드와 패스워드 재입력란이 불일치합니다.\"); window.history.go(-1);</script>";
        exit();
    }

    /*name*/
    if(preg_match("/[!#$%^&*()?+=\/]/", $name) || preg_match('/[0-9]/', $name)){
        echo "<script>alert(\"이름에 특수문자나 숫자는 포함될 수 없습니다.\"); window.history.go(-1); </script>";
        exit();
    }

    /*email*/
    $check_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if($check_email == false){
        echo "<script>alert(\"잘못된 이메일 형식입니다.\"); window.history.go(-1);</script>";
        exit();
    }

    if($id == NULL || $pw == NULL || $name == NULL || $email == NULL){
        echo "<script>alert(\"누락된 항목이 존재합니다.\"); window.history.go(-1);</script>";
        exit();
    }


    /*id exist check*/
    $mysqli = mysqli_connect("localhost","root","111111","test1");
    $check = "SELECT * FROM user_info where userid='$id'";
    $result = $mysqli->query($check);

    if($result->num_rows == 1){
        echo "<script>alert(\"ID가 이미 존재합니다.\"); window.history.go(-1);</script>";
        exit();
    }


    /*id signUp success*/
    $signup = mysqli_query($mysqli, "INSERT INTO user_info (userid,userpw,name,email) VALUES ('$id','$pw','$name','$email')");

    if($signup){
        echo "<script>alert(\"회원가입이 완료되었습니다.\"); location.replace('./login.html');</script>";
    }
?>