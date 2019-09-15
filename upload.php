<?php
$domain=explode('/',$_SERVER['HTTP_REFERER']);
$server='http://chiase321.000webhostapp.com/up';
if($login){
$password=$_POST['password'];
if($password){
$pass=md5($password);
}}
$mota=$_POST['mota'];
$error=$_FILES['file']['error'];
$size=$_FILES['file']['size'];
$name=$_FILES['file']['name'];
$type=pathinfo($name,PATHINFO_EXTENSION);
$token=$_POST['token'];
$iduser=trim(file_get_contents("$server/check.php?token=$token"));
if($_POST['submit']){
if(!$iduser){
header("Location: $server/upload.php");
}elseif(!$name){
header("Location: $server/upload.php?er=not");
}elseif($error>0){
header("Location: $server/upload.php?er=error");
}elseif(trim(file_get_contents("$server/check.php?type=$type"))!='yes'){
header("Location: $server/upload.php?er=type");
}elseif($size>(250*1024*1024)){
header("Location: $server/upload.php?er=size");
}else{
$token=rand_text(10);
$path="cache/$token.dat";
move_uploaded_file($_FILES['file']['tmp_name'],$path);
if(file_exists($path)){
$ch=curl_init();
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);    
curl_setopt($ch,CURLOPT_USERAGENT, 'UCWEB/2.0 (Java; U; MIDP-2.0; vi; NokiaE71-1) U2/1.0.0 UCBrowser/9.4.1.377 U2/1.0.0 Mobile UNTRUSTED/1.0');
curl_setopt($ch,CURLOPT_URL,$server.'/tmpapi.php');
$nguyenpro=array('filename'=>$name,'filesize'=>$size,'pass'=>$pass,'mota'=>$mota,'token'=>$token);
curl_setopt($ch,CURLOPT_POST,count($nguyenpro));
curl_setopt($ch,CURLOPT_POSTFIELDS,$nguyenpro);
curl_exec($ch);
curl_close($ch);
header("Location: $server/upload.php?token=$token");
}else{
header("Location: $server?er=error");
}}}
function rand_text($length){
$chars="abcdefghijklmnopqrstuvwxyz0123456789";
$size=strlen($chars);
for($i=0;$i<$length;$i++){
$str.=$chars[rand(0,$size-1)];
}
return $str;
}
?>
