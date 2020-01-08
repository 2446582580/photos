<?php

session_start();
if (!(isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['role'] == '管理员')) {
    header('location:./login.php');
    die();
}

if (!isset($_GET['id'])) {
    header('location:./user.php');
    die();
}

$id = $_GET['id'];
if (!is_numeric($id)) {
    header('location:./user.php');
    die();
}

require_once './db.php';
$sql = "delete from user where id = {$id}";
$link = init_connect();
$result = mysqli_query($link, $sql);
close_connect($link);
if ($result) {
    if($id == $_SESSION['id']){
        $_SESSION['login'] = false;
    }
    header('refresh:3, url=./user.php');
    die('<h1>删除成功</h1>');
} else {
    die('<h1>删除失败</h1>');
}

