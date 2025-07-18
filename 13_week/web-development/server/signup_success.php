<?php

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script>alert('잘못된 접근입니다.'); 
    location.href='index.php';
    </script>";
}

header('Content-Type: application/json');
$post = json_decode(file_get_contents("php://input"), true);

include 'db.php';

$id = (isset($post['id']) && $post['id'] != '') ? htmlspecialchars(trim($post['id']), ENT_QUOTES, 'UTF-8') : null;
$password = (isset($post['password']) && $post['password'] != '') ? $post['password'] : null;
$name = (isset($post['name']) && $post['name'] != '') ? htmlspecialchars(trim($post['name']), ENT_QUOTES, 'UTF-8') : null;


$sql = "SELECT * FROM user WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $data = ['result' => 'fail']; 
    die(json_encode($data));
}

$hash_ps = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO user (id, name, password) VALUES (:id, :name, :password)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':password', $hash_ps);

if ($stmt->execute()) {
    $data = ['result' => 'success'];
    die(json_encode($data));
}

?>
