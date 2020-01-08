<?php

function create_rand_chars($arr_range)
{
    $data = [];
    foreach ($arr_range as $item) {
        $data = array_merge($data, range(...$item));
    }
    shuffle($data);
    shuffle($data);
    return $data;
}

function rand_str($chars, $num = 4, $glue = '')
{
    $arr_index = array_rand($chars, $num);
    $data = [];
    foreach ($arr_index as $value){
        array_push($data, $chars[$value]);
    }
    return join($glue, $data);
}

function rand_str_code($num = 4, $arr_range = [['a', 'z'], [0, 9], ['A', 'Z']])
{
    $chars = create_rand_chars($arr_range);
    return rand_str($chars, $num);
}
