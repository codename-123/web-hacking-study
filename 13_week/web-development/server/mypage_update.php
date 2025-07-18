<?php
    
header('Content-Type: application/json');
$post = json_decode(file_get_contents("php://input"), true);

$id = (isset($post['id']) && $post['id'] != '') ? htmlspecialchars(trim($post['id']), ENT_QUOTES, 'UTF-8') : null;
$name = (isset($post['name']) && $post['name'] != '') ? htmlspecialchars(trim($post['name']), ENT_QUOTES, 'UTF-8') : null;
$password = (isset($post['password']) && $post['password'] != '') ? $post['password'] : null;

$hash_ps = password_hash($password, PASSWORD_DEFAULT);

include "./db.php";

$sql = "UPDATE user SET name=:name, password=:password WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':password', $hash_ps);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':id', $id);
$stmt->execute();
$row_count = $stmt->rowCount();

if($row_count != 0) {
    $arr = ['result' => 'success'];
    session_start();
    session_destroy();
    die(json_encode($arr));
} else {
    $arr = ['result' => 'fail'];
    die(json_encode($arr));
}

?>