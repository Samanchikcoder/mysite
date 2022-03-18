<?php
session_name('SID') . session_start();
$_SESSION['code'] = rand(1111,9999);
for($i=0;$i < 4;$i++)
$arr[$i]=substr($_SESSION['code'],$i,1); 
$im=imagecreate(80,20);
imagecolorallocate($im,255,255,255); 
$a=1; 
for($i=0;$i < 4;$i++){ 
$figures=array('50', '70', '90', '110' , '130', '150', '170', '190', '210');
$color=imagecolorallocatealpha($im, $figures[rand(0, count($figures)-1)],
$figures[rand(0, count($figures)-1)],
$figures[rand(0, count($figures)-1)],
rand(10,30));
imagestring($im,2,$a+=15,2,$arr[$i],$color); 
} 
header("Content-type: image/jpeg");
ImagePNG($im);
ImageDestroy($im); 
?>