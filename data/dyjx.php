<?php
error_reporting(0);
include('../system/inc.php'); //载入全局配置
header('Content-type:text/html;charset=utf-8');
if ($xtcms_dianyingnew==0){
$urllist='http://www.360kan.com/dianying/list.php?rank=createtime&cat=all&area=all&act=all&year=all&pageno=1';
}
elseif($xtcms_dianyingnew==1){
$urllist='http://www.360kan.com/dianying/list.php?rank=rankhot&cat=all&area=all&act=all&year=all&pageno=1';
}
$info = curl_get($urllist);
switch($_GET['n']){
    case "jp":
        $vname='#<span class="s1">(.*?)</span>#';//影片名称
        $fname='#<span class="s2">(.*?)</span>#';//评分
        $nname='#<span class="hint">(.*?)</span>#';//年份
        $vlist='#<a class="js-tongjic" href="(.*?)">#';//链接
        $vstar='# <p class="star">(.*?)</p>#';//主演
        $vvlist='#<div class="s-tab-main">[\s\S]+?<div monitor-desc#';//获取图片区域
        $vimg='#<img src="(.*?)">#'; //图片
        $array = array();
        preg_match_all($vname, $info,$namearr); //影片名称
        preg_match_all($vlist, $info,$linkarr);//链接
        preg_match_all($vstar, $info,$zhuyanarr);//主演
        preg_match_all($vvlist, $info,$imglist);
        $zcf=implode($glue, $imglist[0]);
        preg_match_all($vimg, $zcf,$imgarr); //图片
        preg_match_all($fname, $info,$pingfenarr); //评分
        preg_match_all($nname, $info,$yeararr);// 年份
        $i=0;
        foreach ($namearr[1] as $key => $value)
        {if ($i<12){
        $url=$linkarr[1][$key]; //地址
        $img=$imgarr[1][$key]; //图片
        $name=$namearr[1][$key];//名称
        $pingfen=$pingfenarr[1][$key]; //评分
        $year=$yeararr[1][$key]; //年份
        $zhuyan=$zhuyanarr[1][$key];//主演
        $jiami=$url;
        if ($xtcms_wei==1){
        $chuandi='./vod'.$jiami;
        }
        else{
        $chuandi='./play.php?play='.$jiami;
        }
        echo "<li class='col-md-5 col-sm-4 col-xs-3 ";
        if ($i>=10){
        echo "hidden-lg hidden-md";
        }
        echo "'><div class='stui-vodlist__box'>
        <a class='stui-vodlist__thumb lazyload img-shadow' href='$chuandi' target='_blank' title='$name' alt='$name' style='background:url({$img}) no-repeat;background-size:100%;background-position:50% 50%;'>
        <span class='play hidden-xs'></span>
        <span class='pic-text text-right'>$year</span>
        </a><div class='stui-vodlist__detail'>
        <h4 class='title text-overflow'>
        <a href='$chuandi' title='$name'>$name</a>
        </h4>
        <p class='text text-overflow text-muted hidden-xs'>$zhuyan</p>
        </div>
        </div>
        </li>";
        $i ++;	}
        }
    break;
    case "wp":
    case "ht":
        $vname='#<span class="s1">(.*?)</span>#';
        $fname='#<span class="s2">(.*?)</span>#';
        $nname='#<span class="hint">(.*?)</span>#';
        $vlist='#<a class="js-tongjic" href="(.*?)">#';
        $vstar='# <p class="star">(.*?)</p>#';
        $vvlist='#<div class="s-tab-main">[\s\S]+?<div monitor-desc#';
        $vimg='#<img src="(.*?)">#';
        $bflist='#<a data-daochu(.*?) href="(.*?)" class="js-site-btn btn btn-play"></a>#'; $array = array();
        preg_match_all($vname, $info,$namearr);
        preg_match_all($vlist, $info,$listarr);
        preg_match_all($vstar, $info,$stararr);
        preg_match_all($vvlist, $info,$imglist);
        $zcf=implode($glue, $imglist[0]);
        preg_match_all($vimg, $zcf,$imgarr);
        preg_match_all($fname, $info,$fnamearr);
        preg_match_all($nname, $info,$nnamearr);
        $i = 0;
        foreach ($namearr[1] as $key => $value) {
            if ($i < 12) {
                $gul = $listarr[1][$key];
                $_GET['id'] = $gul;
                $zimg = $imgarr[1][$key];
                $zname = $namearr[1][$key];
                $fname = $fnamearr[1][$key];
                $nname = $nnamearr[1][$key];
                $zstar = $stararr[1][$key];
                $tok = $gul;
                if ($xtcms_wei == 1) {
                    $playurl = vod . $tok;
                } else {
                    $play = './play.php?play=';
                    $playurl = $play . $tok;
                }
                echo '<div class="col-md-2 col-sm-3 col-xs-4">
            <a class="videopic lazy" href="' . $playurl . '" title="' . $zname . '" data-original="' . $zimg . '" style="background: url('.$zimg.') no-repeat; background-position:50% 50%; background-size: cover; border-radius: 6px;"><span class="play hidden-xs"></span><span class="score">豆瓣 ' . $fname . ' 分</span></a>
            <div class="title">
                <h5 class="text-overflow"><a href="' . $playurl . '">' . $zname . '</a></h5>
            </div>
            <div class="subtitle text-muted text-muted text-overflow hidden-xs">' . $zstar . '</div>
            </div>';
                $i++;
            }
        }
    break;
    case "hyqs":
        $vname = '#<span class="s1">(.*?)</span>#';
        $fname = '#<span class="s2">(.*?)</span>#';
        $nname = '#<span class="hint">(.*?)</span>#';
        $vlist = '#<a class="js-tongjic" href="(.*?)">#';
        $vstar = '# <p class="star">(.*?)</p>#';
        $vvlist = '#<div class="s-tab-main">[\s\S]+?<div monitor-desc#';
        $vimg = '#<img src="(.*?)">#';
        $bflist = '#<a data-daochu(.*?) href="(.*?)" class="js-site-btn btn btn-play"></a>#';
        $array = array();
        preg_match_all($vname, $info, $namearr);
        preg_match_all($vlist, $info, $listarr);
        preg_match_all($vstar, $info, $stararr);
        preg_match_all($vvlist, $info, $imglist);
        $zcf = implode($glue, $imglist[0]);
        preg_match_all($vimg, $zcf, $imgarr);
        preg_match_all($fname, $info, $fnamearr);
        preg_match_all($nname, $info, $nnamearr);
        $i = 0;
        foreach ($namearr[1] as $key => $value) {
            if ($i < 12) {
                $gul = $listarr[1][$key];
                $_GET['id'] = $gul;
                $zimg = $imgarr[1][$key];
                $zname = $namearr[1][$key];
                $fname = $fnamearr[1][$key];
                $nname = $nnamearr[1][$key];
                $zstar = $stararr[1][$key];
                $tok = $gul;
                if ($xtcms_wei == 1) {
                    $playurl = vod . $tok;
                } else {
                    $play = './play.php?play=';
                    $playurl = $play . $tok;
                }
                echo "<li><div class='stui-vodlist__box'>
								<a class='stui-vodlist__thumb lazyload' href='$playurl' title='$zname' style='background: url({$zimg}) no-repeat;background-size:100%;background-position:50% 50%;'>
									<span class='play hidden-xs'></span>
									<span class='pic-text text-right'></span>
								</a>
								<div class='stui-vodlist__detail'>
									<h4 class='title text-overflow'><a href='$playurl' title='$zname'>$zname</a></h4>
								</div>
							</div>
						</li>";
                $i++;
            }
        }
    break;
    case "st21":
    break;
}


?>
