document.addEventListener('DOMContentLoaded', () => {
    const id = document.getElementById('id');
    const ps = document.getElementById('password');
    const btn = document.getElementById('btn');


    btn.addEventListener('click', async () => {
        if (!id.value) return alert('아이디를 입력해 주세요.');
        if (!ps.value) return alert('비밀번호 입력해 주세요.');

        const result = await user_login(id.value, ps.value);   

        if (result === 'success') {
            location.href = '../index.php';
        } else if (result === 'fail') {
            alert('아이디와 비밀번호를 다시 입력해 주세요.');
            id.value = '';
            ps.value = '';
            id.focus();
            return;
        };
    });
});

async function user_login(id, ps) {
    const f = { id: id, password: ps };
    
    const res = await fetch('../server/login_success.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(f)
    });

    const data = await res.json();
    return data.result;
}