<?php
include('system/inc.php');
error_reporting(0);
if (!file_exists('./install/install.lock')) {
    header("location:install");
    die;
}
$seach = curl_get('https://www.360kan.com/');
//准备获取幻灯片
$szz = "# <a href='(.*?)' class='p0 g-playicon js-playicon' ><img src='(.*?)' alt='(.*?)' /><span class='title'>(.*?)</span><span class='desc'>(.*?)</span><b></b>#";
preg_match_all($szz, $seach, $sarr);
$one = $sarr[1];
$two = $sarr[2];
$three = $sarr[5];
include 'data/cxini.php';
include 'template/'.$xtcms_bdyun.'/index.php';
?>
