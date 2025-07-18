document.addEventListener('DOMContentLoaded', () => {
    const id = document.getElementById('id');
    const ps = document.getElementById('password');
    const name = document.getElementById('name');
    const btn = document.getElementById('btn');
    const re_ps = document.getElementById('re_password');
    btn.addEventListener('click', async () => {
        if(!id.value) return alert('아이디를 입력해 주세요.');
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
        
        const data = await user_file(id.value, ps.value, name.value);
        if(data.result === 'success') {
            alert('회원가입 성공!');
            location.href = './login.php';
        } else if(data.result === 'fail') {
            alert('사용중인 아이디 입니다.');
            id.value = '';
            id.focus();
            return;
        }
    });
});

async function user_file(id, ps, name) {
    const f = { id: id, name: name, password: ps };
    
        const res = await fetch('../server/signup_success.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(f)
        });
        const data = await res.json();
        return data;
};



