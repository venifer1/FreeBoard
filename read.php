<?php

include "./listDB.php";
if(!isset($_SESSION['userid'])){
    header ('Location: ./login.html');
}

?>

<!DOCTYPE html>
<html lang="ko">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="UTF-8">
    <title>Read Page</title>
    <link type="text/css" rel="stylesheet" href="./css/reset.css">
    <link type="text/css" rel="stylesheet" href="./css/read.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <script>
        $(function(){
            $(".dat_edit_bt").click(function() {

                $("#dialog").dialog({
                    modal: false,
                    title: "댓글 수정",
                    height: 220,
                    position: {
                        my: "center",
                        at: "center",
                        of: ".replyView"
                    }
                });
            });

        });
    </script>


</head>
<body>
<div class="main_wrap">
    <div class="header">
        <a href="logout.php">Read Page</a>
    </div>
    <div id="cotainer" class="container">
        <table class="table table-striped">
            <?php

                if(isset($_GET['page'])){
                    $page = $_GET['page'];
                }
                else{
                    $page = 1;
                }

                $no = $_GET['no'];
                $hit = mysqli_fetch_array(mq("select * from board where no='".$no."'"));
                $hit = $hit['hit'] + 1;
                $fet = mq("update board set hit = '".$hit."' where no = '".$no."'");
                $sql = mq("select * from board where no = '".$no."'");

                $board = $sql->fetch_array();
            ?>
            <tr>
                <td align="center"><p><b><?php echo $board['title']; ?></b></p></td>
            </tr>
        </table>
        <table class="table table-striped">
            <tr>
                <td class="labelPart" width="100" align="center"><label>글 쓴 이</label></td>
                <td><p><?php echo $board['author']; ?></p></td>

            </tr>
        </table>
        <table class="table table-striped">
            <tr>
                <td class="labelPart" align="center"><label>작 성 일</label></td>
                <td class="dPart"><p><?php echo $board['date']; ?></p></td>
                <td class="labelPart" align="center"><label>조 회 수</label></td>
                <td class="pPart"><p><?php echo $board['hit']; ?></p></td>
            </tr>
        </table>
        <table class="table table-striped">
            <tr>
                <td>
                    <p>
                        <?php
                            echo nl2br($board['content']);
                        ?>
                    </p>
                </td>
            </tr>
        </table>
        <div id="makeSpace2"></div>
        <table class="table table-striped">
            <tr class="success">
                <td>
                    <div>
                        파 일 : <a href="../../upload/<?php echo $board['file'];?>" download><?php echo $board['file']; ?></a>
                    </div>
                </td>
            </tr>
        </table>
        <div class="btnPart">
            <button class="btn btn-info" onclick="location.href='./modify_check.php?no=<?php echo $board['no']; ?>&page=<?php echo $page;?>'"> 수 정 </button>
            <button class="btn btn-info" onclick="location.href='./delete.php?no=<?php echo $board['no']; ?>'"> 삭 제 </button>
            <button class="btn btn-info" onclick="location.href='./main.php?page=<?php echo $page;?>'"> 목 록 </button>
        </div>
        <div id=makeSpace class="replyPart">
            <div class="replyInput">
                <form action="./reply.php?no=<?php echo $no;?>&page=<?php echo $_GET['page'];?>" method="post">
                    <div>
                        <textarea class="form-control" name="content" rows="4"></textarea>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-info">쓰 기</button>
                    </div>
                </form>
            </div>
            <div class="replySpace"></div>

            <?php

                $sql3 = mq("SELECT * FROM reply where con_no='".$no."' order by no asc");
                while($reply = $sql3->fetch_array()){

            ?>

            <div class="replyView">
                <div class="space"></div>
                <input type="hidden" value="<?php echo $reply['no']; ?>">
                <div><b><?php echo $reply['author']; ?></b></div>
                <div><?php echo nl2br($reply['content']); ?></div>
                <div><?php echo $reply['date']; ?></div>

                <?php
                    if(!strcmp($reply['author'], $_SESSION['userid'])){
                ?>

                        <div>
                            <a class="dat_edit_bt" href="#">[수 정]</a>
                            <a>[삭 제]</a>
                        </div>

                        <?php
                            $sql4 = mq("SELECT * FROM reply where no='".$reply['no']."'");
                            $reply2 = $sql4->fetch_array();
                            if(!strcmp($reply['no'],$reply2['no'])){
                        ?>

                        <div id="dialog" class="replyModify">
                            <form action="./reply_modify.php" method="post">
                                <input type="hidden" value="<?php echo $reply['no']; ?>">
                                <div>
                                    <textarea class="form-control" name="content" rows="4"><?php echo $reply['content']; ?></textarea>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-info modifyBtn"><b>수 정</b></button>
                                </div>
                            </form>
                        </div>

                        <?php  } ?>

                <?php
                    } else {}
                ?>
                <div class="space"></div>
            </div>
            <?php } ?>

            <div class="replySpace"></div>
        </div>
    </div>
</div>
</body>
</html>