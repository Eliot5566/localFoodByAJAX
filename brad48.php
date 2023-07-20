<?php
    //brad.47 AJAX 48
    //if 沒傳 page  退出
    if(!isset($_GET['page'])) return;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $mysqli = new mysqli('localhost', 'root', '', 'iii', 3307);
    $mysqli->set_charset('utf8');
    //定義 一頁顯示幾筆資料
    // define('RPP',10);
    $rpp = 10 ;
    // $page = $_GET['page'];
    //從第幾頁開始 要顯示的資料
    $start = ($page - 1 ) * $rpp; 

    //只要是變數 都填入 ? 搭配prepare  儲存結果  bind_parma綁定結果
    $sql = 'SELECT * FROM food ORDER BY id LIMIT ?, ?';
    $stmt  = $mysqli->prepare($sql);
    //綁定 整數 整數
    $stmt->bind_param('ii',$start,$rpp);
    //執行
    $stmt->execute();
    //取得result
    $result = $stmt->get_result();
    $root = [];
    //使用物件 fetch-object() 取得資料
    //把取得的物件 放到root array
    while($row = $result->fetch_object()){
        // echo "{$row->id} : {$row->name} <br>";
        $root [] = $row;

    };
    //把後端接取到的資料 編碼為JSON格式
    $json = json_encode($root);
    echo $json;
?>