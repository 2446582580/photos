<?php
session_start();
require_once './table.php';
require_once './register_login.php';
filter_online();
$user_name = new UserField();
$form_data = filter_login_success(new UserData($user_name), $user_name);
//?\>
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
    <link rel="stylesheet" href="css/register.css"/>
</head>
<body>
<div class="layout">
    <header class="hd">
        <h2>个人相册</h2>
        <h3>登录</h3>
    </header>
    <div>
        <form action="./login.php" method="post">
            <div class="form-it flex">
                <label class="flex">
                    <span class="avg">用户名</span>
                    <input type="text"
                           maxlength="32"
                           name="{$user_name->name}"
                           value="{$form_data->{$user_name->name}}"
                           class="avg"
                           placeholder="请输入用户名"/>
                </label>
                <p class="desc avg"></p>
            </div>
            <div class="form-it flex">
                <label class="flex">
                    <span class="avg">密码</span>
                    <input type="password"
                           maxlength="32"
                           name="{$user_name->password}"
                           value="{$form_data->{$user_name->password}}"
                           class="avg"
                           placeholder="请输入密码"/>
                </label>
                <p class="desc avg"></p>
            </div>
            <div class="form-it flex last-it code-box">
                <label class="flex">
                    <span class="avg">验证码</span>
                    <input type="text"
                           maxlength="8"
                           name="{$user_name->code}"
                           value="{$form_data->{$user_name->code}}"
                           class="avg"
                           placeholder="请输入验证码"/>
                </label>
                <p class="desc flex avg code">
                    <img alt=""
                    src="./img.php" 
                    onclick="this.src = './img.php?=' + Math.random()"/>
                </p>
            </div>
            <p class="error">{$form_data->{$user_name->msg}}</p>
            <div class="flex-center btn">
                <input type="hidden"
                       name="{$user_name->token}"
                       value="{$form_data->{$user_name->token}}"/>
                <input type="submit"
                       class="submit both"
                       value="登录"/>
                <a href="./register.php" class="submit both">注册</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
htmlStr;

