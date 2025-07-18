<?php

include './server/db.php';
include './server/lib.php';

$page = (isset($_GET['page']) && $_GET['page'] != '') ? $_GET['page'] : 1;
$sh = (isset($_GET['sh']) && $_GET['sh'] != '') ? $_GET['sh'] : null;
$sh_txt = (isset($_GET['sh_txt']) && $_GET['sh_txt'] != '') ? $_GET['sh_txt'] : null;    

$where = '';
$params = [];

if ($sh && $sh_txt !== '') {
    switch($sh) {
        case 1: 
            $where = "WHERE title LIKE :title";
            $params[':title'] = '%' . $sh_txt . '%';
            break;
        case 2: 
            $where = "WHERE idx = :idx" ;
            $params[':idx'] = (int)$sh_txt;
            break;
        case 3: 
            $where = "WHERE name LIKE :name";
            $params[':name'] = '%' . $sh_txt . '%';
            break;
    }
}

$limit = 8;
$page_limit = 5;

$page = (isset($_GET['page']) && $_GET['page'] != '' && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$sql = "SELECT COUNT(*) cnt FROM board $where";
$stmt = $db->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute($params);
$row = $stmt->fetch();
$total = $row['cnt'];

$sql = "SELECT * FROM board $where ORDER BY idx DESC LIMIT $start, $limit";
$stmt = $db->prepare($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute($params);
$rs = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판 목록</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="./js/list.js"></script>
</head>
<body class="bg-gray-900 text-white p-6">
    <div class="max-w-6xl mx-auto bg-gray-800 shadow-lg rounded-xl p-8">
        <h2 class="text-3xl font-bold text-center text-white mb-6"> 게시판 목록</h2>

        <table class="w-full table-auto border-collapse border border-gray-700 text-base">
            <colgroup>
                <col width="10%">
                <col width="15%">
                <col width="45%">
                <col width="20%">
                <col width="10%">
            </colgroup>
            <thead class="bg-gray-700">
                <tr>
                    <th class="border border-gray-600 p-3">번호</th>
                    <th class="border border-gray-600 p-3">글쓴이</th>
                    <th class="border border-gray-600 p-3">제목</th>
                    <th class="border border-gray-600 p-3">날짜</th>
                    <th class="border border-gray-600 p-3">조회수</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($rs as $row): ?>
                <tr class="hover:bg-gray-700 border-b border-gray-700 cursor-pointer" id="view" data-idx="<?= $row['idx']; ?>">
                    <td class="border-gray-600 p-3 text-center"><?= $row['idx'] ?></td>
                    <td class="border-gray-600 p-3 text-center"><?= $row['name'] ?></td>
                    <td class="border-gray-600 p-3 text-center"><?= $row['title'] ?></td>
                    <td class="border-gray-600 p-3 text-center"><?= $row['date'] ?></td>
                    <td class="border-gray-600 p-3 text-center"><?= $row['hit'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="flex justify-center items-center space-x-2 mt-6">
            <select class="bg-gray-900 text-white border border-gray-600 p-2 rounded" id="search">
                <option value="1">제목</option>
                <option value="2">번호</option>
                <option value="3">글쓴이</option>
            </select>
            <input type="text" class="bg-gray-900 text-white border border-gray-600 p-2 rounded" id="search_text">
            <button class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-semibold" id="btn">검색</button>
        </div>


        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
            <div class="flex space-x-3 mb-4 sm:mb-0">
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold" onclick="location.href='./board.php'">글쓰기</button>
                <button class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md font-semibold" onclick="location.href='./index.php'">홈으로</button>
            </div>
            <div class="text-white">
                <?php echo my_pagination($total, $limit, $page_limit, $page); ?>
            </div>
        </div>
    </div>
</body>
</html>
