<html>
<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="wrapper">
      <p><a href="index.php">HOME</a> </p>
      <h1>로그인</h1>
      <p id="error-message"></p>
      <form id='form' method='post' action="../server/login_success.php">
        <div>
          <label for="email-input">
            <span>ID</span>
          </label>
          <input type="text" name="id" id="id" placeholder="ID">
        </div>
        <div>
          <label for="password-input">
            <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z"/></svg>
          </label>
          <input type="password" name="password" id="password" placeholder="Password">
        </div>
        <button type="button" id="btn">Login</button>
      </form>
      <p>계정이 없나요? <a href="signup.php">회원가입 하러 가기</a></p>
      <a href="../index.php" class="home-link">HOME 으로 가기</a>
    </div>
    <script src="../js/login.js" defer></script>
  </body>
</html>