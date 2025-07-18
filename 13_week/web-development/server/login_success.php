<?php 

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    echo "<script>alert('??'); 
    location.href='index.php';
    </script>";
    exit();
}

header('Content-Type: application/json');
$post = json_decode(file_get_contents("php://input"), true);

include 'db.php';

$id = (isset($post['id']) && $post['id'] != '') ? $post['id'] : null;
$password = (isset($post['password']) && $post['password'] != '') ? $post['password'] : null;


$sql = "SELECT * FROM user WHERE id=:id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

if ($stmt->rowCount() == 1) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (password_verify($password, $user['password'])) {
        $data = ['result' => 'success'];

        session_start();
        $_SESSION['ses_name'] = $user['name'];
        $_SESSION['ses_id'] = $user['id'];

        die(json_encode($data));
    } else {
        $data = ['result' => 'fail'];
        die(json_encode($data));
    }
} else {
    $data = ['result' => 'fail'];
    die(json_encode($data));
}

?>