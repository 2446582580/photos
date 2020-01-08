<?php
require_once './db.php';
function join_sql_field($values){
    $str = '';
    foreach ($values as $val){
        var_dump($val);
        if(strlen($val) !== mb_strlen($val)){
            $str.="'{$val}',";
        }
        else{
            if($val){
                $str.="{$val},";
            }else{
                $str.='null,';
            }
        }
    }
    return $str;
}

function work_register($data){
    $link = init_connect();
    $name_arr = array_keys($data);
    $value_arr = array_values($data);
    $field = ' '.join(',', $name_arr).' ';
    $values = "'".join("','", $value_arr)."'";
    var_dump(join_sql_field($values));
    $sql = "insert into user ({$field}) values ({$values});";
    var_dump($sql);
    $res = mysqli_query($link, $sql);
    if($res){
        $data = mysqli_insert_id($link);
    }else{
        var_dump(mysqli_error($link));
        $data = null;
    }
    close_connect($link);
    return $data;
}