<?php
session_start();
$ses_name = $_SESSION['ses_name'] ?? null;
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <link rel="stylesheet" href="./css/index.css">
</head>
<body>

  <a href="#main-content" class="skip-link">Skip to main content</a>

  <button id="open-sidebar-button" onclick="openSidebar()" aria-label="open sidebar" aria-expanded="false" aria-controls="navbar">
    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#c9c9c9"><path d="M165.13-254.62q-10.68 0-17.9-7.26-7.23-7.26-7.23-18t7.23-17.86q7.22-7.13 17.9-7.13h629.74q10.68 0 17.9 7.26 7.23 7.26 7.23 18t-7.23 17.87q-7.22 7.12-17.9 7.12H165.13Zm0-200.25q-10.68 0-17.9-7.27-7.23-7.26-7.23-17.99 0-10.74 7.23-17.87 7.22-7.13 17.9-7.13h629.74q10.68 0 17.9 7.27 7.23 7.26 7.23 17.99 0 10.74-7.23 17.87-7.22 7.13-17.9 7.13H165.13Zm0-200.26q-10.68 0-17.9-7.26-7.23-7.26-7.23-18t7.23-17.87q7.22-7.12 17.9-7.12h629.74q10.68 0 17.9 7.26 7.23 7.26 7.23 18t-7.23 17.86q-7.22 7.13-17.9 7.13H165.13Z"/></svg>
  </button>

  <nav id="navbar">
    <ul>
      <li>
        <button id="close-sidebar-button" onclick="closeSidebar()" aria-label="close sidebar">
          <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#c9c9c9"><path d="m480-444.62-209.69 209.7q-7.23 7.23-17.5 7.42-10.27.19-17.89-7.42-7.61-7.62-7.61-17.7 0-10.07 7.61-17.69L444.62-480l-209.7-209.69q-7.23-7.23-7.42-17.5-.19-10.27 7.42-17.89 7.62-7.61 17.7-7.61 10.07 0 17.69 7.61L480-515.38l209.69-209.7q7.23-7.23 17.5-7.42 10.27-.19 17.89 7.42 7.61 7.62 7.61 17.7 0 10.07-7.61 17.69L515.38-480l209.7 209.69q7.23 7.23 7.42 17.5.19 10.27-7.42 17.89-7.62 7.61-17.7 7.61-10.07 0-17.69-7.61L480-444.62Z"/></svg>
        </button>
      </li>
      <?php if($ses_name == '') { ?>
      <li class="home-li"><a>비회원입니다.</a></li>
      <li><a href="./user/login.php">로그인</a></li>
      <li><a href="./user/signup.php">회원가입</a></li>
      <?php } else {?>
      <li class="home-li"><a><?=$ses_name.' 님 반갑습니다'?></a></li>
      <li><a href="board.php">게시판</a></li>
      <li><a href="./user/mypage.php">회원정보 수정</a></li>
      <li><a href="./user/logout.php">로그아웃</a></li>
      <?php }?>
    </ul>
  </nav>
  
  <div id="overlay" onclick="closeSidebar()" aria-hidden="true"></div>

  <main>
    <h1>HOME</h1>
    <?php if($ses_name == '') { ?>
    <p>:)</p>
    <?php } else {?>
    <p><?php echo '당신의 이름 : '.$ses_name;?></p>
    <?php }?>
  </main>
  
</body>
</html>