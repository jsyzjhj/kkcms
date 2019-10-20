<?php
/* *
 * 配置文件
 */
   if ($mkcms_alipay==1){
$payurl='http://www.fenghug.cn/';
 }
  if ($mkcms_alipay==2){
$payurl='http://pay.qqlepay.cn/';
 }
  if ($mkcms_alipay==2){
$payurl='http://pay.axmyzf.cn/';
 }
  if ($mkcms_alipay==4){
$payurl='http://pay.lxypay.cn/';
 }
  if ($mkcms_alipay==5){
$payurl='https://pay.v8jisu.cn/';
 }
   if ($mkcms_alipay==6){
$payurl='http://pay.22sk.cn/';
 }
   if ($mkcms_alipay==7){
$payurl='http://api2.yy2169.com:52888/creat_order/';
 }
//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//商户ID
$alipay_config['partner']		= ''.$mkcms_appid.'';

//商户KEY
$alipay_config['key']			= ''.$mkcms_appkey.'';


//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑


//签名方式 不需修改
$alipay_config['sign_type']    = strtoupper('MD5');

//字符编码格式 目前支持 gbk 或 utf-8
$alipay_config['input_charset']= strtolower('utf-8');

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$alipay_config['transport']    = 'http';

//支付API地址
$alipay_config['apiurl']    = ''.$payurl.'';
?>
