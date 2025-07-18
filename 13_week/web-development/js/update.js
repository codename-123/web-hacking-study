document.addEventListener('DOMContentLoaded', () => {
     $('#content').summernote({
        placeholder: "내용 입력",
        height: 300,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'fontsize']],
            ['color', ['color']],
            ['para', ['paragraph']],
            ['height', ['height']]
        ],
        callbacks: {
            onMediaDelete: (target) => { target.remove(); }
        }
    });
    const submit = document.getElementById('submit');
    const title = document.getElementById('title');
    const pw = document.getElementById('pw');
    const idx = document.getElementById('idx');
    const file = document.getElementById('file_upload');
    submit.addEventListener('click', async () => {
        const content = $('#content').summernote('code');
        const text = $('<div>').html(content).text().trim();

        if(!pw.value) return alert('비밀번호를 입력해주세요.');
        if(!title.value) return alert('제목을 입력해주세요.');
        if(text.length === 0) return alert("내용을 입력해주세요.");
      
        const f1 = new FormData();
        f1.append('title', title.value);
        f1.append('password', pw.value);
        f1.append('idx', idx.value);
        f1.append('content', content);
        f1.append('file_upload', file.files[0]);

        const res = await fetch('./server/update_success.php', {
            method: 'POST',
            body: f1
        });

        const data = await res.json();

        if (data.result === 'success') {
            alert('글이 성공적으로 수정됐습니다.');
            location.href = 'list.php';
        } else if (data.result === 'error') return alert('실패했습니다.');
        else if(data.result === 'fail') {
            document.getElementById('msg').textContent = data.msg
        }
        
    });
});