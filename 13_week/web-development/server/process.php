<?php

$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : null;
$password = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : null;
$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : null;

include 'db.php';

$sql = "SELECT password FROM board WHERE idx = :idx";
$stmt = $db->prepare($sql);
$stmt->bindParam(':idx', $idx);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$row = $stmt->fetch();

if (password_verify($password, $row['password'])) {
    if ($mode == 'delete') {
        $sql = "DELETE FROM board WHERE idx = :idx";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':idx', $idx);
        $stmt->execute();

        $arr = ['result' => 'delete_success'];
    } else if ($mode == 'update') {
        session_start();
        $_SESSION['update_idx'] = $idx;

        $arr = ['result' => 'update_success'];
    }

    die(json_encode($arr));
} else {
    $arr = ['result' => 'password_false'];
    die(json_encode($arr));
}
?>
