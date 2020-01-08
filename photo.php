<?php
require_once './db.php';
require_once './page.php';
function fetch_photo_count()
{
    $link = init_connect();
    $sql = "select count(*) from photos;";
    $result = mysqli_query($link, $sql);
    close_connect($link);
    if ($result) {
        $data_arr = mysqli_fetch_row($result);
        mysqli_free_result($result);
        return array_pop($data_arr);
    } else {
        die('query total of photos error');
    }
}

function current_page($name = 'page')
{
    $current = isset($_GET[$name]) ? $_GET[$name] : 1;
    $current = is_numeric($current) ? $current : 1;
    $current = floor($current) < 1 ? 1 : $current;
    return $current;
}

function fetch_photo_page_data($current, $number)
{
    $link = init_connect();
    $beg = ($current - 1) * $number;
    $sql = "select * from photos order by pub_time desc limit {$beg},{$number};";
    $result = mysqli_query($link, $sql);
    close_connect($link);
    if ($result) {
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
        return $data;
    } else {
        die('query photos page data error');
    }
}

function fetch_photo_data()
{
    $current = current_page();
    $total = fetch_photo_count();
    $number = 6;
    fetch_photo_page_data($current, $number);
    return [
        'total' => $total,
        'current' => $current,
        'number' => $number,
        'photos' => fetch_photo_page_data($current, $number),
        'page' => convent_page_info($total, $current, $number)
    ];
}