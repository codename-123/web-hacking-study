# 웹해킹 스터디 4주차 과제: 첫 웹 CTF 문제 풀이

## 개요

- 이 레포지토리는 웹 인증 우회 관련 CTF 문제들을 풀이한 기록입니다.  
- 각 문제는 로그인 로직, 세션 처리, SQL 쿼리 구조의 허점을 활용하여 flag를 획득합니다.

## CTF 문제 풀이 정리

### PIN CODE by pass

- 이 문제는 세 단계로 구성된 미사일 발사 페이지로 구성되어 있다:
  - `step1.php` : 준비 단계
  - `step2.php` : 비밀번호 입력
  - `step3.php` : 미사일 발사

- 정상적으로는 **step2에서 비밀번호를 입력**해야만 발사가 가능하다.
- 하지만 보안 검증이 클라이언트 단에서만 이루어지고 있어,
- **URL을 직접 `step3.php`로 접근**하면 비밀번호를 입력하지 않아도 미사일이 발사된다.
- 이 구조적 취약점을 이용해 **flag를 획득**할 수 있었다.

![PIN CODE by pass FLAG](.screenshots/pin_code_by_pass.png)

--- 

### Admin is Mine

- 우선 문제에서 제공된 아이디와 비밀번호를 입력한 후 Burp Suite를 통해 서버의 응답을 확인해보았다.

![정상적인 로그인](.screenshots/success_login.png)

> 정상적인 로그인

![틀린 로그인](.screenshots/fall_login.png)

> 틀린 로그인

- 이처럼 정상적인 로그인을 시도하면 서버로부터 `{"result":"ok"}`라는 응답이 반환된다.
- 아이디나 비밀번호가 틀릴 경우 `{"result":"fail"}`이라는 응답이 반환된다.

- 이 구조를 이용해 **서버의 응답을 조작하면 로그인 우회가 가능한 문제**로 보인다.
- **Intercept를 활성화한 뒤**, 서버의 응답을 `{"result":"ok"}`로 수정하면 로그인에 성공할 수 있다.

![Admin is Mine FLAG](.screenshots/server_deceive.png)

- 이런 식으로 **flag를 획득**하였다.

---

### Pin Code Crack

- 이 문제는 `0000`부터 `9999`까지의 PIN 번호 중 정답을 찾아야 하는 문제인 것 같다.

우선 그냥 아무 핀 번호로 시도를 하면

![Pin Code Crack CTF](.screenshots/pin_code_crack_ctf.png)

- 요청이 **GET 방식**으로 전달되는 것을 확인할 수 있다.
- PIN 번호가 틀릴 경우, 응답에는 `alert('Login Fail...');` 스크립트가 포함되어 있다.

- 이를 통해 **응답 내용을 기준으로 Brute Force 공격이 가능**하다고 판단할 수 있다.

![파이썬 브루트포스 스크립트](.screenshots/python_brute_porce.png)

- Python으로 자동화 Brute Force 스크립트를 작성하여 PIN 번호를 순차적으로 시도했다.
- 작성한 스크립트 파일은 `brute_force.py`에 포함되어 있다.

[brute_force.py](./brute_force.py)

![브루트포스 성공](.screenshots/brute_force_success.png)

**핀 번호를 찾았다!**

이걸 이용해 핀 번호를 치면

![Pin Code Crack FLAG](.screenshots/pin_code_crack_flag.png)

- **flag를 획득**하였다.

---

### Login Bypass 2

- 문제에서 제공된 ID와 PW를 입력한 뒤 Burp Suite로 서버 응답을 확인했다.
- 로그인에 성공하면 서버는 **HTTP 302 리다이렉트** 응답을 반환하고,
- 로그인에 실패하면 **HTTP 200 OK** 응답을 반환한다.
- `OR` 조건은 작동하지 않지만, `AND` 조건과 주석(`--` 또는 `#`)은 정상 작동하는 것으로 보인다.
- 이를 통해 **아이디와 비밀번호가 하나의 SQL문 안에서 함께 처리**된다는 것을 추측할 수 있었다.

 ```http
 UserId=normaltic2' # &Password=dol1234&Submit=Login 
 ```

![Login Bypass 2 Flag](.screenshots/login_bypass2_flag.png)

- **flag를 획득**하였다.

---

### Login Bypass 3

- 이전 문제들과 마찬가지로 `OR` 조건은 작동하지 않고, `AND` 조건과 주석 처리는 정상적으로 동작한다.
- 하지만 동일한 방식으로 `id=normaltic3`을 대상으로 시도했을 때는 로그인 우회가 되지 않았다.

- 이를 통해 **ID와 PW가 각각 별도의 로직(예: if 조건문 등)으로 처리되는 구조**, 즉 **식별/인증 분리형 구조**로 추정할 수 있었다.

- 먼저 컬럼의 개수를 파악하기 위해 `order by` 문을 시도하였다.
 ```http
 UserId=doldol' order by 2 # &Password=dol1234&Submit=Login
 ```
- `order by 3`부터는 200 OK 응답이 오는 것으로 보아, **컬럼 수는 2개**로 추정 (`id`, `password`).

- 이후 `union select` 문으로 가상의 행을 만들어 로그인 우회를 시도하였다.
 ```http
 UserId=' union select 'normaltic3','dol1234' # &Password=dol1234&Submit=Login
 ```

![Login Bypass 3 Flag](.screenshots/login_bypass3_flag.png)

- **flag를 획득**하였다.

---

### Login Bypass 4

- `OR` 조건은 여전히 무효화되고, `AND` 조건·주석 처리는 정상적으로 작동한다.
- 동일한 방식으로 `id=normaltic3`을 대상으로 시도했지만 **예상대로 우회되지 않았다**.

- 먼저 `order by` 구문으로 SELECT 절의 컬럼 수를 확인하였다.

  ```http
  UserId=doldol' order by 2 # &Password=dol1234&Submit=Login
  ```
- `order by 3` 부터 **HTTP 200 OK**가 반환된 것으로 보아, 컬럼 수는 2개(`id`, `password`)로 추정했다.

- 이전과 같이 `union select`로 가짜 행을 만들어 로그인 우회를 시도했으나 **실패**했다.

- **비밀번호 해시 검증 로직**이 추가된 것으로 판단하여,
SQL 내장 해시 함수 `MD5()`, `SHA1()`, `SHA2()` 등을 적용해 테스트하였다.

- 최종적으로 다음 페이로드에서 **HTTP 302 리다이렉트**가 발생하며 로그인 우회에 성공, **flag를 획득**했다.

![Login Bypass 4 Flag](.screenshots/login_bypass4_flag.png)

---

### Login Bypass 5

- 이 문제는 Burp Suite를 통해 요청과 응답을 확인하며 분석하였다.

![Login Bypass 5 Cookie](.screenshots/login_bypass5_cookie.png)

- 요청 헤더에는 **`Cookie` 값**이 포함되어 있었고,
- 응답 헤더에는 **`Set-Cookie` 값**이 전달되는 것을 확인할 수 있었다.

- 이때 `session` 값을 제거하고, 대신 `loginUser=normaltic5`로 수정하여 요청을 전송해보았다.

![Login Bypass 5 Flag](.screenshots/login_bypass5_flag.png)

- 그 결과, 별도의 인증 절차 없이 **로그인에 성공하며 flag를 획득**할 수 있었다.

---

## 느낀 점

이번이 나에게는 **첫 웹 해킹 CTF 문제풀이 경험**이었다.

처음엔 단순한 로그인 화면과 입력 폼처럼 보였지만, 그 안에는  
**SQL Injection, 인증 우회, 브루트포싱, 클라이언트 신뢰 취약점** 등  
다양한 보안 허점이 숨어 있었다는 게 인상 깊었다.

특히 Burp Suite를 사용해서 **요청/응답을 직접 캡처하고 조작**해보는 과정은,  
웹 서비스가 실제로 어떻게 동작하고, **어떤 부분이 공격 지점이 되는지**를  
직접 체험하게 해줘서 흥미로웠다.

단순히 정답을 찾는 것 이상의 재미가 있었고,  
"웹 해킹"이라는 분야가 단순 기술이 아닌 **논리와 분석의 싸움**이라는 것도 느꼈다.

이번 경험을 바탕으로,  
앞으로 더 다양한 실전 문제에 도전해보고 **보안적으로 더 깊은 이해**를 쌓고 싶다.
