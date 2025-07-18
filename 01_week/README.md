# 웹해킹 스터디 1주차: 로그인 페이지 구현

## 주요 코드

### index.html

```html
<html>
    <head lang="ko">
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>
	<body>
        <main class="form-signin d-flex justify-content-center align-items-center vh-100">
          <form class="w-100" style="max-width: 400px;" method="GET" action="login_success.php">
            <img class="mb-4 d-block mx-auto" src="./pngegg.png" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal text-center">로그인 해주세요</h1>

            <div class="form-floating">
              <input type="text" class="form-control" id="id" name="id" placeholder="ID">
              <label for="floatingInput">아이디</label>
            </div>
            <div class="form-floating">
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              <label for="floatingPassword">비밀번호</label>
            </div>
            <button class="btn btn-primary w-100 py-2" id="btn" type="button">로그인</button>
            <p class="mt-5 mb-3 text-body-secondary text-center">&copy;</p>
          </form>
        </main>
        <script>
            const id = document.getElementById('id')
            const ps = document.getElementById('password')
            const btn = document.getElementById('btn')
            btn.addEventListener('click', () => {
            if(id.value == '') {
                alert('아이디 입력') 
                return;
            }
            if(ps.value == '') {
                alert('비밀번호 입력')
                return;
            }
			document.querySelector("form").submit()
    		})

         </script>
    </body>
</html>
```

### login_success.php

```php
<?php
    $getid = $_GET['id'];
    $getps = $_GET['password'];

    if($getid != "admin" or $getps != "admin1234") {
        echo "<script>alert('존재하지 않는 사용자.')
        location.href = 'name.php'
        </script>";
    }else{
        echo '로그인 완료';
    }
?>
```

## 요약

- HTML, JavaScript, Bootstrap을 활용하여 로그인 페이지를 구현하였습니다.
- 사용자가 아이디 또는 비밀번호를 입력하지 않을 경우, 알림 창을 통해 입력을 유도합니다.
- 로그인 시, 입력된 정보를 GET 방식으로 `login_success.php`에 전달하여 인증을 수행합니다.

