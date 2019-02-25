<!DOCTYPE html>
<html lang="ko">

<?php
session_start();
if(!isset($_SESSION['userid'])){
    header ('Location: ./login.html');
}
?>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta charset="UTF-8">
    <title>Write Page</title>
    <link type="text/css" rel="stylesheet" href="./css/reset.css?">
    <link type="text/css" rel="stylesheet" href="./css/write.css?">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            $("input[type='file']").on('change', function() {
                var input = $(this);
                var label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                $("#" + input.data("display-target")).val(label);
            });
        })
    </script>


</head>
<body>
<div class="main_wrap">
    <div class="header">
        <a href="./logout.php">Write Page</a>
    </div>
    <div class="container">
        <form action="./write_update.php" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <th id="mobile" width="100"><label for="title"> 제 목 </label></th>
                    <th><input type="text" class="form-control title" name="title"/></th>
                </tr>
                <tr>
                    <th id="mobile" width="100"><label for="author"> 작 성 자 </label></th>
                    <th id="textLeft"><label name="author"><?php echo $_SESSION['userid']?></label></th>
                </tr>
                <tr class="contentHeight">
                    <th id="mobile" width="100"><label id=contentLabel for="content"> 내 용 </label></th>
                    <th><textarea class="form-control content" name="content" rows="15"></textarea></th>
                </tr>
            </table>

            <div class="form-group filePart">
                <label for="inputContent" class="col-sm-2 control-label">첨부파일</label>
                <div class="col-sm-10">
                    <div class="input-group">
                        <label class="input-group-btn">
                            <span class="btn btn-default btn-file">
                                Browse <input type="file" name="file" data-display-target="attachFile">
                            </span>
                        </label>
                        <input type="text" class="form-control" readonly="" id="attachFile" placeholder="20MB 이하의 파일만 업로드 가능">
                    </div>
                </div>
            </div>


            <div class="writeBtn">
                <button type="submit" class="btn btn-primary"> 저 장 </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>