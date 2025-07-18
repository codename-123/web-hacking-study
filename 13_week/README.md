# 웹 해킹 스터디 13주차: Web Development

파일 업로드, 게시판 기능, 로그인/회원가입 등 주요 기능 구현

---

## 주요 기능

- 회원가입 및 로그인
- 사용자 정보 수정 (이름, 비밀번호 등)
- 게시판 CRUD (작성, 읽기, 수정, 삭제)
- 게시판 검색
- 이미지 파일 업로드 기능
- 관리자 권한 없이도 동작 가능 (권한별 기능 제한 없음)

---

## 보안 적용 내역

| 적용 항목 | 설명 |
|-----------|------|
|  XSS 대응 | 게시판, 프로필 수정 등 모든 출력값에 대해 `htmlspecialchars()` 등 필터링 적용 |
|  SQL Injection 대응 | `Prepared Statement(준비된 쿼리)` 사용 |

> 추후 CSRF 대응, 세션 보안 설정, 파일 업로드 필터링 등 추가적인 시큐어 코딩 적용 예정

---

## 사용 기술

- Language: PHP (백엔드), HTML/CSS, JavaScript (프론트)
- DB: MySQL
- 웹 서버: Apache
- 기타: Burp Suite



