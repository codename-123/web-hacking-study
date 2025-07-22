<?php

$title = (isset($_POST['title']) && $_POST['title'] != '') ? htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8') : null;
$password = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : null;
$content = (isset($_POST['content']) && $_POST['content'] != '') ? htmlspecialchars(trim($_POST['content']), ENT_QUOTES, 'UTF-8') : null;
$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : null;
$file = (isset($_FILES['file_upload']) && $_FILES['file_upload'] != '') ? $_FILES['file_upload'] : null;

if ($file && $file['error'] == 0) {
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
    $ext = strtolower(pathinfo($_FILES['file_upload']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowed_ext)) {
        die(json_encode(['result' => 'fail', 'msg' => '허용되지 않은 파일 형식입니다']));
    }

    $save_file = "../photo/" . $_FILES['file_upload']['name'];
    copy($_FILES['file_upload']['tmp_name'], $save_file);

    $content = $content . '<img src="' . $save_file . '">';
}



include 'db.php';

if($idx != '') {
    $hash_ps= password_hash($password, PASSWORD_DEFAULT);


    $sql = "UPDATE board SET title=:title, password=:password, content=:content WHERE idx=:idx";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':password', $hash_ps);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':idx', $idx);
    $stmt->execute();
    $row_count = $stmt->rowCount();

    if($row_count != 0) {
        $arr = ['result' => 'success'];
        die(json_encode($arr));
    } else {
        $arr = ['result' => 'fail'];
        die(json_encode($arr));
    }
           
} else {
    $arr = ['result' => 'error'];
    die(json_encode($arr));
}
?>
