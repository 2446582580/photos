<?php
session_start();
require_once './upload_file.php';
$field = new UploadField();
$data = upload_file();
echo <<< htmlStr
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
    <link rel="stylesheet" href="css/upload.css"/>
</head>
<body>
<div class="layout">
    <header class="hd">
        <h2>个人相册</h2>
        <h3>登录</h3>
    </header>
    <div>
        <form action="./upload.php" method="post" enctype="multipart/form-data">
            <div>
                <span>图片标题</span>
                <label>
                    <input type="text"
                           maxlength="32"
                           name="{$field->str_title}"
                           value=""
                           class="title"
                           placeholder="请输入图片标题"/>
                </label>
            </div>
            <div class="file">
                <span>图片文件</span>
                <label>
                    <input type="file" name="{$field->str_file}[]"/>
                </label>
            </div>
            <div class="intro">
                <span>图片简介</span>
                <label>
                    <textarea name="{$field->str_intro}"></textarea>
                </label>
            </div>
            <p class="error">{$data[$field->str_msg]}</p>
            <div class="flex-center btn">
                <input type="hidden"
                       name="{$field->str_token}"
                       value="{$data[$field->str_token]}"/>
                <input type="submit"
                       class="submit"
                       value="上传"/>
            </div>
        </form>
    </div>
    <div class="flex-center redirect"><a href="./index.php">暂不发布，返回首页</a></div>
</div>

</body>
</html>
htmlStr;

