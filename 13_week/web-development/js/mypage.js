document.addEventListener('DOMContentLoaded', () => {
    const id = document.getElementById('id');
    const ps = document.getElementById('password');
    const name = document.getElementById('name');
    const btn = document.getElementById('btn');
    const re_ps = document.getElementById('re_password');
    id.addEventListener('click', () => {
       const msg = document.querySelector('.error-msg');
       msg.textContent = 'ID는 변경할 수 없습니다.';
       setTimeout(() => { msg.textContent = ''; }, 2000);
    })
    btn.addEventListener('click', async () => {
        if(!name.value) return alert('이름을 입력해 주세요.');
        if(!ps.value) return alert('비밀번호를 입력해 주세요.');
        if(!re_ps.value) return alert('비밀번호 확인란을 입력해 주세요.');
        if(ps.value !== re_ps.value) {
            alert('비밀번호가 맞지 않습니다.');
            ps.value = '';
            re_ps.value = '';
            ps.focus();
            return;
        }
        
        const f = { id: id.value, name: name.value, password: ps.value };
    
        const res = await fetch('../server/mypage_update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(f)
        });

        const data = await res.json();
        if(data.result === "success") {
            alert('수정이 완료 되었습니다.');
            location.href = '../index.php';
        } else {
        alert('변경 된 내용이 없습니다.');
        }

    })
})