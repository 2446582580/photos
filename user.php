<?php
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['role'] == '管理员')){
    header('location:./login.php');
    die();
}
require_once './db.php';
require_once './page.php';
require_once 'photo.php';
$link = init_connect();
$sql = 'select count(*) from user;';
$result = mysqli_query($link, $sql);
$total = 0;
if ($result) {
    $data = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $total = $data ? array_pop($data) : $total;
} else {
    die('query user of number');
}

$current = current_page();
$number = 8;
$start = ($current - 1) * $number;
$sql = "select * from user limit {$start},{$number};";
$users = [];
$result = mysqli_query($link, $sql);
if ($result) {
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    $users = $data ? $data : $total;
} else {
    die('query users data');
}
close_connect($link);
$page_data = convent_page_info($total, $current, $number, $number);
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
    <link rel="stylesheet" href="css/page.css"/>
    <link rel="stylesheet" href="css/heightPc.css"/>
</head>
<body>
<div class="layout">
    <header class="hd">
        <h2>后台管理</h2>
        <h3>账户</h3>
    </header>
    <main class="h50vh">
        <table>
            <thead>
            <tr>
                <th>编号</th>
                <th>用户名</th>
                <th>性别</th>
                <th>学历</th>
                <th>兴趣爱好</th>
                <th>角色</th>
                <th>编辑选项</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($users as $it)
                echo <<< AAA
<tr>
                <td>{$it['id']}</td>
                <td>{$it['name']}</td>
                <td>{$it['gender']}</td>
                <td>{$it['edu']}</td>
                <td>{$it['hobby']}</td>
                <td>{$it['role']}</td>
                <td>
                    <a href="use_edit.php?id={$it['id']}">修改</a>
                    <span>|</span>
                    <a href="#" 
                    onclick="confirm('是否删除该用户') ? 
                    location.href='./user_remove.php?id={$it['id']}' : null;">删除</a>
                </td>
            </tr>
AAA;
            ?>
            </tbody>
        </table>
    </main>
    <footer>
        <ul class="flex-center page">
            <?php
            $data = $page_data;
            $prefix = './user.php?page=';
            echo $data['first'] > 0 ? "<li><a class='it step' href='$prefix{$data['first']}'>首页</a></li>" : '';
            echo $data['prev'] > 0 ? "<li><a class='it step' href='$prefix{$data['prev']}'>&lt;上一页</a></li>" : '';
            for ($current = $data['current'], $beg = $data['beg'], $end = $data['end']; $beg <= $end; ++$beg) {
                if ($current == $beg) {
                    echo "<li><span class='active'>{$beg}</span></li>";
                } else {
                    echo "<li><a href='$prefix{$beg}' class='it'>{$beg}</a></li>";
                }
            }
            echo $data['next'] > 0 ? "<li><a class='it step' href='$prefix{$data['next']}'>下一页&gt;</a></li>" : '';
            echo $data['tail'] > 0 ? "<li><a class='it step' href='$prefix{$data['tail']}'>末页</a></li>" : '';
            ?>
        </ul>
    </footer>
</div>
</body>
</html>



