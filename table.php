<?php
$table = <<< TABLE
创建数据库
create database if not exists photo charset utf8;
set names utf8;

use photo;

创建表
create table if not exists user(
    id int primary key auto_increment,
    name varchar(8) unique key comment '用户名',
    password char(32) comment 'md5密码',
    gender enum('男','女') comment '性别',
    edu enum('小学','初中','高中','大专','本科','研究生','硕士','博士') comment '学历',
    hobby set('数码','体育','聚会交际','购物','旅游','上网冲浪','电影','漫画动漫') comment '兴趣爱好',
    role enum('管理员','普通用户') default '普通用户' comment '用户角色'
) charset=utf8 engine=InnoDB;

insert into user(name, password, gender, edu, hobby, role)
values('admin', );

insert into user (name, password)
    values ('小王', md5('123'));
select *from user;
update user set name='admin' where id = 1;

create table if not exists photos (
    id int auto_increment primary key,
    title varchar(16) comment '标题',
    hots int default 0 comment '访问量',
    pub_time datetime comment '发布时间',
    img_src varchar(256) comment '图片路径',
    uid int comment '发布用户id',
    intro text comment '图片简介'
);
insert into photos (title, pub_time, img_src, uid, intro)
values ('搞事情', now(), './upload/1.jpg' ,1,'好了走人了别搞事器');
insert into photos (title, img_src, uid, intro) 
select title, img_src, uid, intro from photos;
show tables;
insert into user (name, password, gender, edu, hobby, role)
values('ok', '202cb962ac59075b964b07152d234b70', 1, 2, 15, 2);
TABLE;


class UserFieldSet
{
    var $edu = [1 => '小学', '初中', '高中', '大专', '本科', '研究生', '硕士', '博士'];
    var $gender = [1 => '男', '女'];
    var $hobby = [
        1 => '数码', 2 => '体育', 4 => '聚会交际',
        8 => '购物', 16 => '旅游', 32 => '上网冲浪',
        64 => '电影', 128 => '漫画动漫'
    ];
}

class UserField
{
    var $token = 'token';
    var $name = 'name';
    var $password = 'password';
    var $gender = 'gender';
    var $hobby = 'hobby';
    var $edu = 'edu';
    var $code = 'code';
    var $msg = 'msg';
}

class UserData
{
    public function __construct($form_name)
    {
        foreach ($form_name as $value) {
            $this->$value = '';
        }
        return $this;
    }
}

class FormCheck
{
    var $string = '';
    var $digit = '';
    var $check = '';

    function __construct($string, $digit, $check = '')
    {
        $this->string = $string;
        $this->digit = $digit;
        $this->check = $check;
    }
}