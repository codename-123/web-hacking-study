<?php

include './server/db.php';

$idx = (isset($_GET['idx']) && $_GET['idx'] != '') ? $_GET['idx'] : null;


$sql = "UPDATE board SET hit=hit+1 WHERE idx=:idx";
$stmt = $db->prepare($sql);
$stmt->bindParam(':idx', $idx);
$stmt->execute();


$sql = "SELECT * FROM board WHERE idx=:idx";
$stmt = $db->prepare($sql);
$stmt->bindParam(':idx', $idx);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$row = $stmt->fetch();

if(!$row){
    echo "<script>alert('게시물이 없습니다.'); 
    history.go(-1);
    </script>";
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 글보기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./js/view.js"></script>
    <link rel="stylesheet" href="./css/view.css">
</head>
<body>
    <div class="container">
        <div class="title"><?=$row['title']?></div>
        <div class="info">
            <span>작성자: <?=$row['name']?></span>
            <span>조회수: <?=$row['hit']?></span>
            <span>작성일: <?=$row['date']?></span>
        </div>
        <div class="content" id="bbs_content">
            <?=$row['content']?>
        </div>
        <div class="buttons">
            <div>
                <button class="button back" onclick="location.href='list.php'">뒤로 가기</button>
            </div>
            <div>
                <button class="button update" data-bs-toggle="modal" data-bs-target="#modal" id="update">수정</button>
                <button class="button delete" data-bs-toggle="modal" data-bs-target="#modal" id="delete">삭제</button>
            </div>
        </div>
    </div>

    <div class="modal" id="modal" tabindex="-1">
        <div class="modal-dialog">
            <form method="post" name="modal_form">
                <input type="hidden" name="mode" value="">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header border-bottom-0">
                        <input type="hidden" id="idx" value="<?=$row['idx']?>">
                        <h5 class="modal-title text-white" id="modal_title"></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="password" class="form-control bg-secondary text-white border-0" name="password" id="password" placeholder="비밀번호 입력">
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-primary" id="submit">확인</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
