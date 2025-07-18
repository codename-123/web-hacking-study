<?php

session_start();

$ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : '';
$session_idx = (isset($_SESSION['update_idx']) && $_SESSION['update_idx'] != '') ? $_SESSION['update_idx'] : '';
$get_idx = (isset($_GET['idx']) && $_GET['idx'] != '') ? $_GET['idx'] : '';

if($session_idx != $get_idx) {
    echo "<script>
    alert('잘못된 경로입니다.')
    history.go(-1)
    </script>";
}

include './server/db.php';

$sql = "SELECT * FROM board WHERE idx=:idx";
$stmt = $db->prepare($sql);
$stmt->bindParam(':idx', $session_idx);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$row = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script src="../js/update.js"></script>
    <title>글 수정</title>
</head>
<body>
    <div class="container">
        <div class="mt-4 mb-3">
            <span class="h2"><?=$row['idx']?>번의 게시판</span>
        </div>
        <div class="mb-2 d-flex gap-2">
            <input type="text" name="name" class="form-control w-25" id="name" readonly value="<?=$ses_name ?>" placeholder="글쓴이" autocomplete="off">
            <input type="password" name="pw" class="form-control w-25" id="pw" placeholder="비밀번호">
            <input type="hidden" id="idx" value="<?=$row['idx']?>">
        </div>
        <div>
            <input type="text" name="title" id="title" value="<?= $row['title']?>" class="form-control mb-2" placeholder="제목">
        </div>
        <div class="mb-2">
            <textarea name="content" id="content" class="form-control" rows="15" placeholder="내용 입력"><?= $row['content']?></textarea>
        </div>

        <div class="mt-2 d-flex gap-2 justify-content-end">
            <button class="btn btn-primary" id="submit">확인</button>
            <button class="btn btn-secondary" onclick="history.go(-1)">뒤로 가기</button>
        </div>
    </div>
</body>
</html>
