<?php

function init_connect()
{
    $host_data = [
        'localhost',
        'root',
        ''
    ];
    $link = @mysqli_connect(...$host_data);
    !$link && exit('connect database failure');
    !mysqli_set_charset($link, 'utf8') && die('set charset failure');
    !mysqli_select_db($link, 'db1') && die('select db failure');
    return $link;
}

function close_connect($link){
    mysqli_close($link);
}
