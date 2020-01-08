<?php
session_start();
require_once './register_login.php';
filter_login();
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
    <link rel="stylesheet" href="css/index.css"/>
    <link rel="stylesheet" href="css/page.css"/>
</head>
<body>
<div class="layout">
    <header class="hd">
        <h2>个人相册</h2>
        <h3>首页</h3>
    </header>
    <ul class="bd">
        <?php
        require_once './photo.php';
        $data = fetch_photo_data();
        $photos = $data['photos'];
        $len = count($photos);
        //        var_dump($photos);
        for ($i = 0; $i < $len; ++$i) {
            $tmp = $photos[$i];
            echo <<< AAA
        <li class="flex-center">
            <a href="./detail.php?id={$tmp['id']}" class="link">
                <div class="img-box">
                    <img class="img" alt="" src=" {$tmp['img_src']} "/>
                </div>
                <p class="title">{$tmp['title']}</p>
            </a>
        </li>
AAA;
        }
        ?>
    </ul>
    <footer>
        <ul class="flex-center page">
            <?php
            require_once './page.php';
            $all_data = $data;
            $data = $all_data['page'];
            $prefix = './index.php?page=';
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
    <div class="flex-center redirect"><a href="./upload.php">独乐乐不如众乐乐</a></div>
</div>
</body>
</html>


