function getUrl() {
    const params = {};

    window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,
        function(str, key, value) {
            params[key] = value;
        }
    );
    return params;
}

document.addEventListener('DOMContentLoaded', () => {
    const params = getUrl();
    const view = document.querySelectorAll('#view');
    view.forEach((e) => {
        e.addEventListener('click', () => {
            location.href = "./view.php?idx=" + e.dataset.idx;
        });
    });
    const btn = document.getElementById("btn");
    btn.addEventListener("click", () => {
        const sh = document.getElementById("search");
        const sh_txt = document.getElementById("search_text");
        if(sh_txt.value === '') return alert('검색어를 입력해 주세요.');

        location.href='./list.php?page=' + params['page'] + '&sh=' + sh.value + '&sh_txt=' + sh_txt.value;
    })
});

