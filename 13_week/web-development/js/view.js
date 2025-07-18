document.addEventListener('DOMContentLoaded', () => {
    const update = document.getElementById('update')
    const del = document.getElementById('delete')
    const idx = document.getElementById('idx')
    const modal_title = document.getElementById('modal_title')
    const modal_form = document.modal_form
    const submit = document.getElementById('submit')
    const password = document.getElementById('password')

    update.addEventListener('click', () => {
        modal_title.textContent = '수정하기'
        modal_form.mode.value = "update"
    })
    del.addEventListener('click', () => {
        modal_title.textContent = '삭제하기'
        modal_form.mode.value = "delete"
    })
    
    submit.addEventListener('click', async () => {
        if(!password.value) return alert('비밀번호를 입력해주세요.')
        
        if (modal_form.mode.value == 'delete') {
            const userChoice = confirm('정말 삭제하시겠습니까?');
            if (!userChoice) return
        }
        const formData = new FormData()
        formData.append('idx', idx.value)
        formData.append('password', password.value)
        formData.append('mode', modal_form.mode.value)

        const res = await fetch('./server/process.php', {
            method: 'POST',
            body: formData
        })

        const data = await res.json()

        if (data.result == 'update_success') {
            location.href = './update.php?idx=' + idx.value;
        } else if (data.result == 'delete_success') {
                alert('삭제 되었습니다.')
                location.href = './list.php'
            }
         else if (data.result == 'password_false') {
            alert('비밀번호가 틀립니다.')
            password.value = ''
        }
    })
})

