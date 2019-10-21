<?php
error_reporting(0);
header('Content-type:text/html;charset=utf-8');
$info = file_get_contents("https://v.jxn8.cn/");
switch($_GET['n']){
    case "jp":
        $szz1='#<li><a href="/index.php/show/index/(.*?)"><b></b><img src="(.*?)" /><span>(.*?)</span></a></li>#';
        preg_match_all($szz1, $info,$sarr1);
            for($i =0;$i<15;$i++){
            $zname=$sarr1[3][$i];
            $two=$sarr1[1][$i];
            $zimg=$sarr1[2][$i];
            $link="mplay.php?mso=".$two;
                echo "
                <li class='col-md-5 col-sm-4 col-xs-3 '><div class='stui-vodlist__box'>
                <a class='stui-vodlist__thumb lazyload img-shadow' href='$link' title='$zname' alt='$zname' style='background:url({$zimg}) no-repeat;background-size:100%;background-position:40% 60%;'>
                <span class='play hidden-xs'></span>
                </a><div class='stui-vodlist__detail'>
                <h4 class='title text-overflow'>
                <a href='$link' title='$zname'>$zname</a>
                </h4>
                </div>
                </div>
                </li>
                ";}
    break;
    case "wp":
    case "ht":
        $szz1='#<li><a href="/index.php/show/index/(.*?)"><b></b><img src="(.*?)" /><span>(.*?)</span></a></li>#';
        preg_match_all($szz1, $info,$sarr1);
        $str='';
       for($i =0;$i<12;$i++){
           $zname=$sarr1[3][$i];//名字
           $two=$sarr1[1][$i];//ID
           $zimg=$sarr1[2][$i];//图片
           $link="mplay.php?mso=".$two;

           echo  "
		  <div class='col-md-2 col-sm-3 col-xs-4 '><a class='videopic lazy' href='$link' title='$zname'  style='background: url({$zimg}) no-repeat; background-position:50% 50%; background-size: cover;border-radius: 6px;' ><span class='play hidden-xs'></span><span class='score'>电影尝鲜</span></a><div class='title'><h5 class='text-overflow'><a href='$link' title='$zname' target='_self'>$zname</a></h5></div></div>";

         }
    break;
    case "hyqs":
        $szz1 = '#<li><a href="/index.php/show/index/(.*?)"><b></b><img src="(.*?)" /><span>(.*?)</span></a></li>#';
        preg_match_all($szz1, $info, $sarr1);
        for ($i = 0; $i < 10; $i++) {
            $zname = $sarr1[3][$i]; //名字
            $two = $sarr1[1][$i]; //ID
            $zimg = $sarr1[2][$i]; //图片
            $link = "mplay.php?mso=" . $two;
            echo "
		   <li class='hidden-xs'>
            <div class='stui-vodlist__box'>
                <a class='stui-vodlist__thumb lazyload' href='$link' title='$zname' style='background:url({$zimg}) no-repeat;background-size:100%;background-position:40% 60%;'>
                    <span class='play hidden-xs'></span>
                    <span class='pic-text text-right'>电影尝鲜</span>
                </a>
                <div class='stui-vodlist__detail'>
                    <h4 class='title text-overflow'><a href='$link' title='$zname'>$zname</a></h4>
                </div>
            </div>
        </li>";
        }
    break;
    case "st21":
    break;
}


?>
