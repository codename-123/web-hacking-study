<?php 

session_start();
$ses_name = $_SESSION['ses_name'] ?? null;
$ses_id = $_SESSION['ses_id'] ?? null;

if($ses_name == '' || $ses_id == '') {
    echo "<script>
    alert('로그인 회원만 입장 가능합니다.')
    location.href = 'login.php'
    </script>";
}
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="../css/style.css">
  <script src="../js/mypage.js"></script>
</head>
<body>
  
  <div class="wrapper">
    <h1>개인 정보 수정</h1>
    <p id="error-message"></p>
    <form id="form" action="../server/signup_success.php" method="post">
      <div class="form-row">
        <div class="input-wrapper">
            <label for="id"><span>ID</span></label>
            <input type="text" id="id" readonly value='<?=$ses_id;?>'>
        </div>
        <div class="error-msg"></div>
      </div>
      <div>
        <label for="name">
        <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z"/></svg>
        </label>
        <input type="name" name="name" id="name" placeholder="Username" value='<?=$ses_name;?>'>
      </div>
      <div>
        <label for="password">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/></svg>
        </label>
        <input type="password" name="password" id="password" placeholder="Password">
      </div>
      <div>
        <label for="re_password">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/></svg>
        </label>
        <input type="password" name="re_password" id="re_password" placeholder="Repeat Password">
      </div>
      <button type="button" id="btn">UPDATE</button>
    </form>
    <a href="../index.php" class="home-link">HOME 으로 가기</a>
  </div>
</body>
</html>