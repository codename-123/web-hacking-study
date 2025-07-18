<?php

include 'db.php';

$name = (isset($_POST['name']) && $_POST != '') ? htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8') : '';
$password = (isset($_POST['password']) && $_POST != '') ? $_POST['password'] : '';
$title = (isset($_POST['title']) && $_POST != '') ? htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8') : '';
$content = (isset($_POST['content']) && $_POST != '') ? htmlspecialchars(trim($_POST['content']), ENT_QUOTES, 'UTF-8') : '';

$hash_ps = password_hash($password, PASSWORD_DEFAULT);

if (isset($_FILES['file_upload']) && $_FILES['file_upload']['error'] === UPLOAD_ERR_OK) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        die(json_encode(['result' => 'fail', 'msg' => '허용되지 않은 파일 형식입니다']));
    }

    $save_file = "../photo/" . $_FILES['file_upload']['name'];
    copy($_FILES['file_upload']['tmp_name'], $save_file);

    $content = $content . '<img src="' . $save_file . '">';
}

$sql = "INSERT INTO board (name, password, title, content, date) 
VALUES (:name, :password, :title, :content, NOW())";

$stmt = $db->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':password', $hash_ps);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':content', $content);
$stmt->execute();

$arr = ['result' => 'success'];
die(json_encode($arr));


?>