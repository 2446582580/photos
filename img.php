<?php
session_start();
require_once './code.php';
$_SESSION['code'] = rand_str_code();

function rand_color_alpha($alpha = 30)
{
    return [
        mt_rand(0, 255),
        mt_rand(0, 255),
        mt_rand(0, 255),
        $alpha
    ];
}
$w = 100;
$h = 37;
$image = imagecreatetruecolor($w, $h);
//填充背景
imagefill(
    $image,
    0, 0,
    imagecolorallocatealpha($image, ...rand_color_alpha(80))
);

//写入字符串
imagettftext(
    $image,
    20,
    0,
    20, 26,
    imagecolorallocatealpha($image, ...rand_color_alpha(10)),
    'C:/wamp64/www/wqy.ttf',
    $_SESSION['code']
);

for ($i = 0; $i < 250; ++$i) {
    imagesetpixel(
        $image,
        mt_rand(0, $w),
        mt_rand(0, $h),
        imagecolorallocatealpha($image, ...rand_color_alpha())
    );
}

for ($i = 0; $i < 20; ++$i){
    imageline(
      $image,
      mt_rand(0, $w), mt_rand(0, $h),
      mt_rand(0, $w), mt_rand(0, $h),
      imagecolorallocatealpha($image, ...rand_color_alpha(100))
    );
}

header('content-type:image/png');
echo imagepng($image);
imagedestroy($image);

