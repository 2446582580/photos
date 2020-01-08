<?php
session_start();
//var_dump($_SESSION);
//$_SESSION = [];
//session_destroy();
function both_is_exist($key)
{
    return isset($_POST[$key]) && isset($_SESSION[$key]);
}

function both_is_equal($key, $lowercase = false)
{
    if ($lowercase) {
        return strtolower($_POST[$key]) === strtolower($_SESSION[$key]);
    } else {
        return $_POST[$key] === $_SESSION[$key];
    }
}

function both_check($key, $lowercase = false)
{
    return both_is_exist($key) && both_is_equal($key, $lowercase);
}

function recovery_post_data(&$data, $keys)
{
    foreach ($keys as $k) {
        if (isset($_POST[$k])) {
            $data[$k] = $_POST[$k];
        }
    }
}

$token = 'token';
$username = 'name';
$password = 'password';
$code = 'code';
$msg = 'msg';
$login = 'login';
$data = [
    $token => uniqid(),
    $username => '',
    $password => '',
    $msg => ''
];

function retrieve_user_data($data, $username, $password)
{
    $name = $data[$username];
    $pwd = $data[$password];
    include_once './db.php';
    $link = init_connect();
    $sql = "select * from user where {$username}='{$name}' and {$password}=md5('{$pwd}');";
//var_dump($sql);
    $result = mysqli_query($link, $sql);
    close_connect($link);
    $res = null;
    if ($result) {
        $res = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    }
    return $res;
}


if (isset($_SESSION[$login]) && $_SESSION[$login]) {
    //已经登录了到某页面
    header('location:./index.php');
    die();
}

if (both_check($token)) {
    recovery_post_data($data, [$username, $password]);
    if (!both_check($code, true)) {
        $data[$msg] = '验证码错误';
    } else {
        $user_data = retrieve_user_data($data, $username, $password);;
        if ($user_data) {
            $_SESSION['user'] = $user_data;
            $_SESSION[$login] = true;
//            var_dump($user_data);
//            var_dump('登录成功');
            header('refresh:3,url=./index.php');
            die();
        } else {
            $data[$msg] = '用户名或者密码错误';
        }
    }
}
$_SESSION[$token] = $data[$token];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body{
            background: goldenrod;
        }
        .hd {
            text-align: center;
        }

        .error {
            text-align: center;
            color: #ee3333;
            line-height: 50px;
            height: 50px;
        }

        .center {
            width: 500px;
            margin: 30px auto;
        }

        form > div {
            margin-bottom: 30px;
        }

        form label {
            display: flex;
            line-height: 36px;
        }

        form label span {
            width: 150px;
            text-align: center;
            font-size: 16px;
            cursor: pointer;
        }

        form label input {
            width: 250px;
            outline: none;
            border-radius: 3px;
            font-size: 16px;
            border: 1px solid #00b3ff;
            padding: 0 6px;
        }

        form .code {
            display: flex;
        }

        form .code input {
            width: 120px;
        }

        form .code img {
            height: 36px;
            width: 100px;
            background: #4FEF10;
            margin-left: 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        .flex {
            display: flex;
            justify-content: center;
            align-content: center;
        }

        .flex input {
            margin: 15px 50px;
            padding: 7px 18px;
            font-size: 16px;
            border-radius: 3px;
            border: 1px solid #00b3ff;
            cursor: pointer;
        }

        .flex input:hover {
            background: #00b3ff;
            color: #fff
        }
    </style>
</head>
<body>
<div class="center">
    <div class="hd">
        <h2>用户登录</h2>
    </div>
    <div class="error"><span><?php echo $data[$msg]; ?></span></div>
    <form method="post" action="../login.php">
        <div>
            <label>
                <span>用户名</span>
                <input type="text"
                       name="<?php echo $username; ?>"
                       maxlength="8"
                       placeholder="请输入用户名"
                       value="<?php echo $data[$username]; ?>"/>
            </label>
        </div>
        <div>
            <label>
                <span>密码</span>
                <input type="password"
                       name="<?php echo $password; ?>"
                       maxlength="32"
                       placeholder="请输入密码"
                       value="<?php echo $data[$password]; ?>">
            </label>
        </div>
        <div class="code">
            <label>
                <span>验证码</span>
                <input type="text"
                       name="<?php echo $code; ?>"
                       maxlength="8"
                       placeholder="请输入验证码"
                       value="">
            </label>
            <img alt=""
                 onclick="this.src='./img.php?'+Math.random()"
                 src="../img.php"/>
        </div>
        <div class="flex">
            <input type="hidden"
                   name="token"
                   value="<?php echo $data['token']; ?>"/>
            <input type="submit" value="登录"/>
            <input type="reset" value="重置"/>
        </div>
    </form>
</div>
</body>
</html>