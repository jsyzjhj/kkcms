<?php
include('system/inc.php');
if(isset($_POST['submit'])){
	if ($_SESSION['verifycode'] != $_POST['verifycode']) {
		alert_href('验证码错误','book.php');
	}
    null_back($_POST['userid'],'请填写昵称');
	null_back($_POST['content'],'请填写留言内容');
	//判断昵称是否符合规则
	if (!preg_match("/[\x7f-\xff]+(?:\s*[\x7f-\xff]+)*/", $_POST['userid'])) {
		echo "<script>alert('昵称不合法!');location.href='book.php'</script>";
		die();
	}
	//判断留言内容是否符合规则
	//判断有一个空格以上但是又不能全部是空的字符串
	if (!ctype_space($_POST['content']) && !empty($_POST['content'])) {
		//匹配数字字母下划线空格中文 数量不能超过10个字
		if (!preg_match("/[\x7f-\xff]+(?:\s*[\x7f-\xff]+)*/", $_POST['content'])) {
			echo "<script>alert('内容填写不合法!');location.href='book.php'</script>";
			die;
		}
	} else {
		echo "<script>alert('内容填写不合法!');location.href='book.php'</script>";
		die;
	}
	$data['userid'] = $_POST['userid'];
	$data['content'] =addslashes($_POST['content']);
	$data['time'] =date('y-m-d h:i:s',time());
	$str = arrtoinsert($data);
		$sql = 'insert into xtcms_book ('.$str[0].') values ('.$str[1].')';
	if(mysql_query($sql)){

alert_href('留言成功!小的马上为您准备相关资源！','book.php');
}
else{
alert_back('抱歉！服务器好像开小差了呢！');
	}


}
include('template/'.$xtcms_bdyun.'/book.php');
?>
