<?php
include('system/inc.php'); //载入全局配置文件
ob_clean(); //清除缓存
$result = mysql_query('select * from xtcms_system where id = 1');
$row = mysql_fetch_array($result);
$xtcms_domain = $row['s_domain'];
$xtcms_token= $row['s_token'];
$xtcms_guanzhu= $row['s_guanzhu'];
$xtcms_fengmian= $row['s_fengmian'];
//定义全局变量
define("yuming", $xtcms_domain);
define("guanzhu", $xtcms_guanzhu);
define("fengmian", $xtcms_fengmian);
define("TOKEN", "".$xtcms_token."");
//得到wechatObj对象
$wechatObj = new wechatCallbackapiTest();
//校验token并返回结果
if (isset($_GET['echostr'])) {
	$wechatObj->valid();
}
else {
	$wechatObj->responseMsg();
}


class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

	//数据返回
    public function responseMsg()
    {
		$postStr = isset($GLOBALS["HTTP_RAW_POST_DATA"])?$GLOBALS["HTTP_RAW_POST_DATA"]:"";
		if (!empty($postStr)){
                libxml_disable_entity_loader(true);
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                $fromUsername = $postObj->FromUserName;
                $toUsername = $postObj->ToUserName;
                $keyword = trim($postObj->Content);

				$event = $postObj->Event;
                $time = time();
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
				switch($postObj->MsgType)
				{
					case 'event':
						if($event == 'subscribe')
						{
						//关注后的回复
							$contentStr =guanzhu;
							$msgType = 'text';
							$textTpl = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $textTpl;

						}
						break;

					//搜索内容
					case 'text':
						$msgType = 'text';
						$str = "我们为您找到以下结果: \r\n";
						if(preg_match('/[\x{4e00}-\x{9fa5}]+/u',$keyword))
						{
							$vod = "SELECT * FROM `xtcms_vod` WHERE `d_name` like '%".$keyword."%'  LIMIT 0 , 10";
							$shipin= mysql_query($vod);
							$itemCount = 0;
							$item360 = 0;
							$itemzw = 0;
							$res = $this->search($keyword);
							$zwres=$this->zwcx($keyword);
							//是否有搜索结果
							if(mysql_num_rows($shipin)>0 || !empty($res[0])){
								//取出数据库中影片信息
								while($row = mysql_fetch_assoc($shipin))
								{
									if ($itemCount >= 3) {
										break;
									}
									$title = "".$row['d_name']."";
									$url =yuming."bplay.php?play=".$row['d_id'];
									$str.="<a href='{$url}'>{$title}</a> \r\n";
									++$itemCount;
								}
								//取出360搜索中影片信息
								for ($i = 0; $i< count($res[0]); $i++) {
									if ($item360 >= 5) {
										break;
									}
									$title = $res[0][$i];
									$url =  yuming."play.php?play=".str_replace("http://www.360kan.com", "", $res[2][$i]);
									$str .= "<a href='{$url}'>{$title}</a> \r\n";
									++$item360;
								}
								$str.="\r\n";
								//取出站外资源中影片信息
								for ($j = 0; $j < count($zwres[0]); $j++) {
									if ($itemzw >= 3) {
										break;
									}
									$title = $zwres[0][$j];
									$url =  yuming . "mplay.php?mso=" . $zwres[2][$j];
									$str .= "▶ <a href='{$url}'> {$title} 【抢先看】</a> ◀\r\n";
									++$itemzw;
								}

								$str .= "----------------------------\r\n 没有找到您要的结果?<a href='" . yuming . "book.php" . "'>☞点击这里☜</a>反馈给我们";
								$contentStr .= sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $str);
								echo $contentStr;
							}
							else
							{
								$newsTpl = "<xml>
									<ToUserName><![CDATA[%s]]></ToUserName>
									<FromUserName><![CDATA[%s]]></FromUserName>
									<CreateTime>%s</CreateTime>
									<MsgType><![CDATA[text]]></MsgType>
									<Content>%s</Content>
									</xml>";
									$resultStr= sprintf($newsTpl, $fromUsername, $toUsername, $time, '很抱歉，未找到关于《'.$keyword.'》的相关影片！
									您还可以到我们的官网（'.yuming.'）进行更详细准确的内容搜索！
									') ;

									echo $resultStr;

							}
									mysql_close($con);

						}
						else
						{
							//任意回复
							$contentStr = "公众号提示： \r\n ●请回复输入电影名如：青云志 即可在线观看！\r\n ●如果无法获取；请稍等片刻重新回复！\r\n ◆友情提示：获取到地址后，直接点击进入，然后拖到播放列表下边，点击集数即可在线播放。\r\n  \r\n ★请回复片名或关键词！";
							$msgType = 'text';
							$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
							echo $resultStr;
						}


						break;
					default:
						break;
				}

        }else {
        	echo $xtcms_guanzhu;
        	exit;
        }
    }

	//公众号token校验
	private function checkSignature()
	{
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	//360搜索结果函数
	private function search ($keyword) {
		$seach=curl_get('https://so.360kan.com/index.php?kw='.$keyword);
        $szz='#js-playicon" title="(.*?)"\s*data-logger#';
        $szz1='#a href="(.*?)" class="g-playicon js-playicon"#';
        $szz2='#<img src="(.*?)" alt=#';
        preg_match_all($szz,$seach,$sarr);
        preg_match_all($szz1,$seach,$sarr1);
        preg_match_all($szz2,$seach,$sarr2);
        $one = $sarr[1];//标题
        $two = $sarr2[1];//图片
        $nine = $sarr1[1];
		return array($one,$two,$nine);
	}

	//站外资源搜索
	private function zwcx($keyword){
		include('data/cxini.php'); //站外配置文件
		$link=$zwcx['zhanwai'];
		$a = $link.'index.php/search?wd='.rawurlencode($keyword);
		$response=curl_get($a);
		$zhanw1='#<li><a href="/index.php/show/index/(.*?)">(.*?)<img src="(.*?)" /><span>(.*?)</span></a></li>#';
		preg_match_all($zhanw1, $response,$zhanw1rr);
		$id=$zhanw1rr[1]; //id
		$img=$zhanw1rr[3];  //图片
		$title=$zhanw1rr[4];  //标题
		return array($title, $img, $id);
	}
}
?>
