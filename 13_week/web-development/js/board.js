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
        ]
    });
    const submit = document.getElementById('submit');
        submit.addEventListener('click', async () => {
            const name = document.getElementById('name');
            const pw = document.getElementById('pw');
            const title = document.getElementById('title');
            const content = $('#content').summernote('code');
            const text = $('<div>').html(content).text().trim();
            const file = document.getElementById('file_upload');
            if(!pw.value) return alert('비밀번호를 입력해주세요.');
            if(!title.value) return alert('제목을 입력해주세요.');
            if(text.length === 0) return alert("내용을 입력해주세요.");
            
            const f1 = new FormData();
            f1.append('name', name.value);
            f1.append('password', pw.value);
            f1.append('title', title.value);
            f1.append('content', content);
            f1.append('file_upload', file.files[0]);

            const res = await fetch('./server/write.php', {
                method: 'POST',
                body: f1
            });

            const data = await res.json();

            if (data.result === 'success') {
                location.href = 'list.php';
            }
            else {
                document.getElementById("msg").textContent = data.msg;
                return false;
            }
    })
})
