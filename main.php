<?php
    include "./listDB.php";

    if(!isset($_SESSION['userid'])){
        header ('Location: ./login.html');
    }

?>

<!doctype html>
<html lang="ko">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="UTF-8">
    <title> Notice Board </title>
    <link type="text/css" rel="stylesheet" href="./css/reset.css">
    <link type="text/css" rel="stylesheet" href="./css/main.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
<div class="main_wrap">
    <div class="header">
        <a href="./logout.php">Free Board</a>
    </div>
    <div id=makeSpace class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th id="ios5Padding" width="100">번호</th>
                <th id="ios5Padding" width="500">제목</th>
                <th id="ios5Padding" width="120">글쓴이</th>
                <th id="ios5Padding" width="100">작성일</th>
                <th id="ios5Padding" width="100">조회</th>
            </tr>
            </thead>

            <?php

                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }
                else{
                    $page = 1;
                }

                /*페이지,블록 개수*/
                $sql = mq("select * from board");
                $row_num = mysqli_num_rows($sql);
                $list = 10;
                $block_ct = 5;

                /*블록*/
                $block_num = ceil($page/$block_ct);
                $block_start = (($block_num - 1) * $block_ct) + 1;
                $block_end = $block_start + $block_ct - 1;

                $total_page = ceil($row_num / $list);
                if($block_end > $total_page) $block_end = $total_page;
                $total_block = ceil($total_page/$block_ct);
                $start_num = ($page-1) * $list;

                $sql2 = mq("select * from board order by no desc limit $start_num, $list");
                while($board = $sql2->fetch_array()){

                    $title = $board["title"];

                    $datetime = explode(' ', $board['date']);
                    $date = $datetime[0];
                    $time = $datetime[1];

                    if($date == Date('Y-m-d')){
                        $board['date'] = mb_substr($time,0,5);
                        $img = "<img src='./img/new-icon.png' width='20' height='20' alt='new' title='new' />";
                    }
                    else{
                        $board['date'] = mb_substr($date, 5,5);
                        $img ="";
                    }

                    if($board['file']!=null){
                        $img2 = "<img src='./img/disk-icon.png' width='20' height='20' alt='file' title='file' />";
                    }
                    else{
                        $img2 ="";
                    }

                    if(strlen($title)>30){
                        $title = str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]); //title이 30을 넘어서면 ...표시
                    }

                    $sql3 = mq("select * from reply where con_no='".$board['no']."'");
                    $rep_count = mysqli_num_rows($sql3);
            ?>
            <tbody>
                <tr>
                    <td width="70"><?php echo $board['no']; ?></td>
                    <td id="textLeft" width="500">
                        <a href="./read.php?no=<?php echo $board["no"];?>&page=<?php echo $page;?>">
                            <?php echo $title; ?>
                            <span class="re_ct">
                                [<?php echo $rep_count;?>]
                                <?php echo $img2; ?>
                                <?php echo $img; ?>
                            </span>
                        </a>
                    </td>
                    <td width="120"><?php echo $board['author']; ?></td>
                    <td id="#ios5Padding" width="100"><?php echo $board['date']; ?></td>
                    <td width="100"><?php echo $board['hit']?></td>
                </tr>
            </tbody>
            <?php } ?>
        </table>
        <div id="ios5" class="paging">
            <ul>
                <?php
                    /*페이징*/

                    if($page <= 1){
                        echo "<li class='lijs'>처음</li>";
                    }
                    else{
                        echo "<li class='lijs'><a  href='?page=1'>처음</a></li>";
                    }
                    if($page <= 1){}
                    else{
                        $pre = $page-1;
                        echo "<li class='lijs'><a href='?page=$pre'>이전</a></li>";
                    }

                    for($i=$block_start; $i<=$block_end; $i++){

                        if($page == $i){
                        echo "<li class='lijs'>[$i]</li>";
                        }
                        else{
                            echo "<li class='lijs'><a href='?page=$i'>[$i]</a></li>";
                        }
                    }

                    if($block_num >= $total_block){}
                    else{
                        $next = $page + 1;
                        echo "<li class='lijs'><a href='?page=$next'>다음</a></li>";
                    }

                    if($page >= $total_page){
                        echo "<li class='lijs'>마지막</li>";
                    }
                    else{
                        echo "<li class='lijs'><a href='?page=$total_page'>마지막</a></li>";
                    }
                ?>
            </ul>
        </div>

        <div id="search_box" class="search_part">
            <form action="./search_result.php" method="get">
                <select class="form-control" name="catgo">
                    <option value="title">제 목</option>
                    <option value="author">글쓴이</option>
                    <option value="content">내 용</option>
                </select>
                <input class="form-control" type="text" name="search" width="200" required="required" />
                <button class="btn btn-success"type="submit">검 색</button>
            </form>
        </div>


        <div class="goWrite">
            <button class="btn btn-success" onclick="location.href='write.php'"> 글 쓰 기 </button>
        </div>

        <div id="makeSpace2"></div>
    </div>

</div>
<script src="./js/main.js"></script>
</body>

</html>
