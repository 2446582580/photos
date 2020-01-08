<?php
session_start();
require_once './table.php';
require_once './register_login.php';
filter_online();
$user_name = new UserField();
$form_data = filter_register_success(new UserData($user_name), $user_name);
$form_field = create_form_user_field($form_data, $user_name);
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
        <h3>注册</h3>
    </header>
    <div>
        <form action="./register.php" method="post">
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
                           placeholder="请输入用户名"/>
                </label>
                <p class="desc avg"></p>
            </div>
            <div class="form-it flex">
                <span class="avg">性别</span>
                <div class="flex radio">
                    <label class="flex-center">
                        <input type="radio"
                               {$form_field[$user_name->gender](false)->check}
                        name="{$user_name->gender}"
                        value="{$form_field[$user_name->gender](false)->digit}"/>
                        <span>{$form_field[$user_name->gender](true)->string}</span>
                    </label>
                    <label class="flex-center">
                        <input type="radio"
                               {$form_field[$user_name->gender](false)->check}
                        name="{$user_name->gender}"
                        value="{$form_field[$user_name->gender](false)->digit}"/>
                        <span>{$form_field[$user_name->gender](true)->string}</span>
                    </label>
                </div>
            </div>
            <div class="form-it flex">
                <span class="avg">学历</span>
                <div class="flex radio">
                    <select name="edu" class="select">
                        <option disabled selected value=""></option>
                        <option {$form_field[$user_name->edu](false)->check}
                            value="{$form_field[$user_name->edu](false)->digit}">{$form_field[$user_name->edu](true)->string}
                        </option>
                        <option {$form_field[$user_name->edu](false)->check}
                            value="{$form_field[$user_name->edu](false)->digit}">{$form_field[$user_name->edu](true)->string}
                        </option>
                        <option {$form_field[$user_name->edu](false)->check}
                            value="{$form_field[$user_name->edu](false)->digit}">{$form_field[$user_name->edu](true)->string}
                        </option>
                        <option {$form_field[$user_name->edu](false)->check}
                            value="{$form_field[$user_name->edu](false)->digit}">{$form_field[$user_name->edu](true)->string}
                        </option>
                        <option {$form_field[$user_name->edu](false)->check}
                            value="{$form_field[$user_name->edu](false)->digit}">{$form_field[$user_name->edu](true)->string}
                        </option>
                        <option {$form_field[$user_name->edu](false)->check}
                            value="{$form_field[$user_name->edu](false)->digit}">{$form_field[$user_name->edu](true)->string}
                        </option>
                        <option {$form_field[$user_name->edu](false)->check}
                            value="{$form_field[$user_name->edu](false)->digit}">{$form_field[$user_name->edu](true)->string}
                        </option>
                        <option {$form_field[$user_name->edu](false)->check}
                            value="{$form_field[$user_name->edu](false)->digit}">{$form_field[$user_name->edu](true)->string}
                        </option>
                    </select>
                </div>
            </div>
            <div class="form-it last-it flex">
                <span class="avg">兴趣爱好</span>
                <div class="flex radio">
                    <label class="flex-center">
                        <input type="checkbox"
                               {$form_field[$user_name->hobby](false)->check}
                        name="{$user_name->hobby}[]"
                        value="{$form_field[$user_name->hobby](false)->digit}"/>
                        <span>{$form_field[$user_name->hobby](true)->string}</span>
                    </label>
                    <label class="flex-center">
                        <input type="checkbox"
                               {$form_field[$user_name->hobby](false)->check}
                        name="{$user_name->hobby}[]"
                        value="{$form_field[$user_name->hobby](false)->digit}"/>
                        <span>{$form_field[$user_name->hobby](true)->string}</span>
                    </label>
                    <label class="flex-center">
                        <input type="checkbox"
                               {$form_field[$user_name->hobby](false)->check}
                        name="{$user_name->hobby}[]"
                        value="{$form_field[$user_name->hobby](false)->digit}"/>
                        <span>{$form_field[$user_name->hobby](true)->string}</span>
                    </label>
                    <label class="flex-center">
                        <input type="checkbox"
                               {$form_field[$user_name->hobby](false)->check}
                        name="{$user_name->hobby}[]"
                        value="{$form_field[$user_name->hobby](false)->digit}"/>
                        <span>{$form_field[$user_name->hobby](true)->string}</span>
                    </label>
                    <label class="flex-center">
                        <input type="checkbox"
                               {$form_field[$user_name->hobby](false)->check}
                        name="{$user_name->hobby}[]"
                        value="{$form_field[$user_name->hobby](false)->digit}"/>
                        <span>{$form_field[$user_name->hobby](true)->string}</span>
                    </label>
                    <label class="flex-center">
                        <input type="checkbox"
                               {$form_field[$user_name->hobby](false)->check}
                        name="{$user_name->hobby}[]"
                        value="{$form_field[$user_name->hobby](false)->digit}"/>
                        <span>{$form_field[$user_name->hobby](true)->string}</span>
                    </label>
                    <label class="flex-center">
                        <input type="checkbox"
                               {$form_field[$user_name->hobby](false)->check}
                        name="{$user_name->hobby}[]"
                        value="{$form_field[$user_name->hobby](false)->digit}"/>
                        <span>{$form_field[$user_name->hobby](true)->string}</span>
                    </label>
                    <label class="flex-center">
                        <input type="checkbox"
                               {$form_field[$user_name->hobby](false)->check}
                        name="{$user_name->hobby}[]"
                        value="{$form_field[$user_name->hobby](false)->digit}"/>
                        <span>{$form_field[$user_name->hobby](true)->string}</span>
                    </label>
                </div>
            </div>
            <p class="error">{$form_data->{$user_name->msg}}</p>
            <div class="flex-center btn">
                <input type="hidden"
                       name="{$user_name->token}"
                       value="{$form_data->{$user_name->token}}"/>
                <input type="submit"
                       class="submit"
                       value="立即注册"/>
            </div>
        </form>
    </div>
    <footer class="flex-center redirect"><a href="./login.php">已有账号，去登陆？</a></footer>
</div>

</body>
</html>
htmlStr;

