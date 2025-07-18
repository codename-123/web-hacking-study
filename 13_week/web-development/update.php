<?php

session_start();

$ses_name = (isset($_SESSION['ses_name']) && $_SESSION['ses_name'] != '') ? $_SESSION['ses_name'] : null;
$session_idx = (isset($_SESSION['update_idx']) && $_SESSION['update_idx'] != '') ? $_SESSION['update_idx'] : null;
$get_idx = (isset($_GET['idx']) && $_GET['idx'] != '') ? $_GET['idx'] : null;

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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> 
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>
    <script src="./js/update.js"></script>
    <title>글 수정</title>
</head>
<body class="min-h-screen bg-gray-900 text-white py-10">
  <div class="container max-w-[1100px] w-full mx-auto bg-gray-800 text-white p-12 shadow-lg rounded-lg">

    <div class="mb-14 flex flex-col items-center gap-2">
      <h1 class="text-5xl font-bold text-white text-center tracking-tight"><?= $row['idx'] ?>번의 게시판</h1>
      <input type="hidden" id="idx" value="<?=$row['idx']?>">
    </div>

    <div class="mb-4 flex gap-4">
      <input type="text" name="name" class="form-control w-1/2 border border-gray-700 placeholder-gray-400 bg-gray-700 text-white rounded focus:text-white focus:bg-gray-700 focus:ring-0" id="name" readonly style="background-color: #374151 !important; color: white !important;" value="<?=$ses_name ?>" placeholder="글쓴이" autocomplete="off">

      <input type="password" name="pw" class="form-control w-1/2 border border-gray-700 placeholder-gray-400 bg-gray-700 text-white rounded focus:text-white focus:bg-gray-700 focus:ring-0" id="pw" placeholder="비밀번호">
    </div>

    <div class="mb-4">
      <input type="text" name="title" id="title" value="<?= $row['title']?>" class="form-control bg-gray-700 text-white border border-gray-700 placeholder-gray-400 rounded focus:text-white focus:bg-gray-700 focus:ring-0" placeholder="제목">
    </div>

    <div class="mb-4">
      <div id="summernote-container" class="bg-white text-black rounded">
        <textarea name="content" id="content" class="form-control" rows="10" placeholder="내용 입력"><?= $row['content']?></textarea>
      </div>
    </div>

    <div class="mb-6 flex flex-col gap-2">
      <label class="block mb-2 text-3xl font-bold text-gray-200" for="file_upload">파일 업로드</label>

      <input type="file" name="file_upload" id="file_upload" class="block w-[500px] text-2xl text-white file:mr-4 file:py-5 file:px-8 file:rounded-lg file:border-0 file:text-xl file:font-extrabold file:bg-blue-600 file:text-white hover:file:bg-blue-700 bg-gray-700 border border-gray-700 placeholder-gray-400 focus:text-white focus:bg-gray-700 rounded-lg">

      <div id="msg" class="text-red-400 mt-2 text-2xl"></div>
    </div>

    <div class="flex justify-end gap-4">
      <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg" id="submit">확인</button>
      <button class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg" onclick="history.go(-1)">뒤로 가기</button>
    </div>
  </div>
</body>