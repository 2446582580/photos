<?php
require_once './register_login.php';

class UploadField
{
    var $str_token = 'token';
    var $str_title = 'title';
    var $str_intro = 'intro';
    var $str_msg = 'msg';
    var $str_file = 'file';
}

class ValidateUploadField
{
    var $data = null;

    function __construct($data)
    {
        $data = is_array($data) ? $data : [];
        $this->data = $data;
    }

    function validate($filed, $predicate)
    {
        $status = $this->is_empty($filed);
        return !$status ? $predicate($this->data[$filed]) : $status;
    }

    function is_exist($filed)
    {
        return isset($this->data[$filed]);
    }

    function is_empty($field)
    {
        $status = $this->is_exist($field);
        return $status ? empty($this->data[$field]) : !$status;
    }
}

function is_image_file($files)
{
    $status = true;
    $handle = finfo_open(FILEINFO_MIME_TYPE);
    $img_arr = ['image/png', 'image/gif', 'image/jpeg'];
    foreach ($files as $item) {
        $info = finfo_file($handle, $item['tmp_name']);
        $status = $status && in_array($info, $img_arr);
    }
    finfo_close($handle);
    return $status;
}

function transform_files($name)
{
    $res = [];
    if (isset($_FILES[$name])) {
        $files = $_FILES[$name];
        if (is_array($files['error'])) {
            foreach ($files as $key => $item) {
                $len = count($item);
                for ($i = 0; $i < $len; ++$i) {
                    $tmp = isset($res[$i]) ? $res[$i] : [];
                    $tmp[$key] = $item[$i];
                    $res[$i] = $tmp;
                }
            }
        } else {
            array_push($res, $files);
        }
    }
    return $res;
}

function save_upload_image_file($files, $path='./upload/image/', $prefix=''){
    if(!file_exists($path) && !mkdir($path, 0744, true)){
        die("$path is not exists");
    }
    $info = finfo_open(FILEINFO_MIME_TYPE);
    $data = [];
    foreach ($files as $item){
        $from = $item['tmp_name'];
        $ext = substr(strrchr(finfo_file($info, $from), '/'), 1);
        $to = $path.uniqid($prefix).".".$ext;
        move_uploaded_file($from, $to);
        array_push($data, $to);
    }
    finfo_close($info);
    return $data;
}

function upload_file()
{
    $o = new UploadField();
    $data = [
        $o->str_token => '',
        $o->str_title => '',
        $o->str_intro => '',
        $o->str_msg => ''
    ];
    $token_status = validate_both($o->str_token);
    $token = uniqid();
    $_SESSION[$o->str_token] = $token;
    if (is_request_type('get')) {
        $data[$o->str_token] = $token;
        return $data;
    }
    if (!is_request_type('post')) {
        die('is invalid type');
    }
    if (!$token_status) {
        die('is invalid token');
    }
    $v = new ValidateUploadField($_POST);
    if ($v->is_empty($o->str_title) || $v->is_empty($o->str_intro)) {
        die('in invalid submit lack str');
    }
    $v->data = $_FILES;
    if (!$v->validate($o->str_file, function ($item) {
        $status = true;
        $size_arr = $item['size'];
        $size_arr = is_array($size_arr) ? $size_arr : [$size_arr];
        foreach ($size_arr as $ix => $size) {
            $status = $status && $size != 0;
        }
        return $status;
    })) {
        die('in invalid submit lack file');
    }
    $title = $_POST[$o->str_title];
    $intro = $_POST[$o->str_intro];
    $files = transform_files($o->str_file);
    if (!is_image_file($files)) {
        die('上传的文件格式不支持');
    }
    require_once './db.php';
    $pathname_arr = save_upload_image_file($files);
    $img_src = array_pop($pathname_arr);
    $link = init_connect();
    $uid = $_SESSION['id'];
    $sql = "insert into photos (title, img_src, intro, uid, pub_time) values ('$title', '$img_src', '$intro', '$uid', now());";
    if(!mysqli_query($link, $sql)){
        die('发布照片失败');
    }
    else{
        close_connect($link);
        header('refresh:3,url=./index.php');
        die('<h1>发布成功3s后回到首页</h1>');
    }
}


