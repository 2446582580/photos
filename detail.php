<?php
session_start();
require_once './register_login.php';
filter_login();
$data = [];
if(isset($_GET['id']) && is_numeric($_GET['id'])){
    require_once './db.php';
    $id = $_GET['id'];
    $link = init_connect();
    $sql = "update photos set hots = hots + 1 where id = {$id};";
    if(!mysqli_query($link, $sql)){
        die('update access times error');
    }
    $sql = "select 
p.id, p.title, p.hots, p.pub_time, p.img_src, p.intro, u.name
 from photos as p left join user as u 
on u.id = p.uid where p.id = {$id};";
    $result = mysqli_query($link, $sql);
    close_connect($link);
    if($result){
        $data = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        if(!$data){
            header('refresh:3,url=./index.php');
            die('<h2>图片不存在或已删除</h2>');
        }
    }else{
        die('query picture error');
    }
}
else{
    header('location:./index.php');
    die();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css"/>
    <link rel="stylesheet" href="css/common.css"/>
    <link rel="stylesheet" href="css/photo.css"/>
    <link rel="stylesheet" href="css/detail.css"/>
    <style>
        .detail{
            padding-bottom: 25px;
        }
    </style>
</head>
<body>
<div class="layout detail">
    <header class="hd">
        <h2>个人相册</h2>
        <h3>相片详情</h3>
    </header>
    <?php
echo <<< AAA
    <main>
        <div class="title common flex">
            <span class="caption">图片标题</span>
            <span class="content">{$data['title']}</span>
        </div>
        <div class="common flex">
            <span class="caption">发布人</span>
            <span class="content">{$data['name']}</span>
        </div>
        <div class="common flex">
            <span class="caption">访问量</span>
            <span class="content">{$data['hots']}</span>
        </div>
        <div class="common flex">
            <span class="caption">发布时间</span>
            <span class="content">{$data['pub_time']}</span>
        </div>
        <div class="desc flex">
            <span class="caption">图片简介</span>
            <span class="content">
                {$data['intro']}
            </span>
        </div>
        <div class="flex-center">
            <div class="img-box">
                <img alt="" src="{$data['img_src']}" class="img"/>
            </div>
        </div>
    </main>
AAA;
    ?>
    <footer class="flex-center redirect"><a href="./index.php">返回主页</a></footer>
</div>
</body>
</html>


