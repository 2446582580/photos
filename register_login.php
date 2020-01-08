<?php
require_once './table.php';
function create_form_user_field($form_data, $user_name)
{
    $checked = ' checked=checked ';
    $selected = ' selected=selected ';
    $create_item = function ($set, $value, $check_string, $calc_index) {
        $index = 1;
//        分割获取到的值得字符串
        $values = array_map(function ($value) {
            return trim($value);
        }, explode(',', $value));
        return function ($next = true) use (&$set, &$index, &$values, &$check_string, $calc_index) {
//            生成字符串对应的下标
            $digit = $calc_index($index);
            $string = trim($set[$digit]);
            $next && $index < count($set) && ++$index;
//            判断是否选中这项
            in_array($string, $values) && var_dump($string);
            $check = in_array($string, $values) ? $check_string : '';
//            生成对象
            return new FormCheck($string, $digit, $check);
        };
    };
    $form_field_set = new UserFieldSet();
    $gender = $user_name->gender;
    $edu = $user_name->edu;
    $hobby = $user_name->hobby;
    return [
        $gender => $create_item(
            $form_field_set->gender,
            $form_data->{$gender},
            $checked,
            function ($index) {
                return $index;
            }
        ),
        $edu => $create_item(
            $form_field_set->edu,
            $form_data->{$edu},
            $selected,
            function ($index) {
                return $index;
            }
        ),
        $hobby => $create_item(
            $form_field_set->hobby,
            $form_data->{$hobby},
            $checked,
            function ($index) {
                return pow(2, $index - 1);
            }
        )
    ];
}

function filter_login(){
    $login = 'login';
    if (!(isset($_SESSION[$login]) && $_SESSION[$login])) {
        header('location:./login.php');
        die();
    }
    return true;
}

function filter_online()
{
    $login = 'login';
    if (isset($_SESSION[$login]) && $_SESSION[$login]) {
        header('location:./index.php');
        die();
    }
    return true;
}


function validate_both($name)
{
    $status = isset($_POST[$name]) && isset($_SESSION[$name]);
    return $status && strtolower($_POST[$name]) === strtolower($_SESSION[$name]);
}


function fetch_data($name, $required = true, $is_arr = false)
{
    $data = isset($_POST[$name]) ? $_POST[$name] : null;
    if ($required) {
        return empty($data) ? die('required') : $data;
    }
    if ($data === null) {
        return 'null';
    }
    $user_set = new UserFieldSet();
    $arr = $user_set->{$name};
    if (!$is_arr) {
        return isset($arr[$data]) ? $data : die('value not in array');
    }
    $sum = 0;
    foreach ($data as $value) {
        if (isset($arr[$value])) {
            $sum += $value;
        } else {
            die('array of value not in array');
        }
    }
    return $sum;
}

function is_request_type($type)
{
    return strtolower($_SERVER['REQUEST_METHOD']) === strtolower($type);
}

function filter_register_success($form_data, $user_name)
{
    $token_status = validate_both($user_name->token);
    $token = uniqid();
    $form_data->{$user_name->token} = $token;
    $_SESSION[$user_name->token] = $token;
    if (is_request_type('get')) {
        return $form_data;
    }
    if(!is_request_type('post')){
        die('is invalid type');
    }
    if (!$token_status) {
        die('is invalid token');
    }

//    处理用户名和密码
    $name = fetch_data($user_name->name, true, false);
    $password = fetch_data($user_name->password, true, false);
    $gender = fetch_data($user_name->gender, false, false);
    $edu = fetch_data($user_name->edu, false, false);
    $hobby = fetch_data($user_name->hobby, false, true);
    $password = md5($password);
    $sql = "insert into user (name, password, gender, edu, hobby) values ('$name','$password',$gender,$edu,$hobby)";
    require_once './db.php';
    $link = init_connect();
    if (mysqli_query($link, $sql)) {
        echo '<h1>注册成功</h1>';
        header('refresh:3,url=./login.php');
        die();
    } else {
        $form_data->{$user_name->msg} = '用户名已存在';
    }
    close_connect($link);
    return $form_data;
}


function filter_login_success($form_data, $user_name)
{
    $token_status = validate_both($user_name->token);
    $token = uniqid();
    $form_data->{$user_name->token} = $token;
    $_SESSION[$user_name->token] = $token;
    require_once './code.php';
    $_SESSION[$user_name->msg] = rand_str_code();
    if (is_request_type('get')) {
        return $form_data;
    }
    if(!is_request_type('post')){
        die('is invalid type');
    }
    if (!$token_status) {
        die('is invalid token');
    }

    //    处理code
    if (!validate_both($user_name->code)) {
        $form_data->{$user_name->msg} = '验证码错误';
        return $form_data;
    }

//    查询数据库
    $name = fetch_data($user_name->name, true, false);
    $password = fetch_data($user_name->password, true, false);
    $password = md5($password);
    $sql = "select id,name,role from user where name='$name' and password='$password';";
    require_once './db.php';
    $link = init_connect();
    $result = mysqli_query($link, $sql);
    close_connect($link);
    if (!$result) {
        $form_data->{$user_name->msg} = '系统错误';
        return $form_data;
    }
    if (!mysqli_num_rows($result)) {
        $form_data->{$user_name->msg} = '用户名或密码错误';
        return $form_data;
    }
    foreach (mysqli_fetch_assoc($result) as $index => $value) {
        $_SESSION[$index] = $value;
    }
    $_SESSION['login'] = true;
    header('location:./index.php');
    die();
}
