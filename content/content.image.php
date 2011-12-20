<?php

session_start();

$img = imagecreatetruecolor(120, 40);

$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
$grey = imagecolorallocate($img, 200, 200, 200);

imagefill($img, 0, 0, imagecolorallocate($img, 197, 230, 243));

//for($i = 0; $i < 50; $i++){
//	$color = (rand(1, 2) == 1) ? $black : $grey;
//	//$grey = rand(50, 220);
//	imageline($img, rand(-20, 130), rand(-20, 60), rand(-20, 140), rand(-20, 60), $color);
//}

function randomString($length){
	$chars = 'abcdefghjkmnpqstuwxyz23456789';
	$str = array(array(), array(), array(), 0);
	for($i = 0; $i < $length; $i++){
		$num = rand() % 33;
		$tmp = substr($chars, $num, 1);
		$angle = rand(-25, 25);
		$dim = imagettfbbox(20, $angle, '../assets/font/arial.ttf', $tmp);
		$str[0][] = $tmp;
		$str[1][] = $angle;
		$str[2][] = $dim[2] + 4;
		$str[3] += $dim[2] + 4;
	}
	return $str;
}

$string = randomString(rand(4, 6));
$str = '';


$offset = (120 - $string[3]) / 2;

for($i = 0; $i < count($string[0]); $i++){
	$str .= $string[0][$i];
	$tmp = ($i > 0) ? ($offset += $string[2][$i]) : $offset;
	imagettftext($img, 20, $string[1][$i], $tmp, 30, imagecolorallocate($img, 0, 114, 188), '../assets/font/arial.ttf', $string[0][$i]);
}

$_SESSION['captcha'] = $str;

header('Content-type: image/png');
imagepng($img);
imagedestroy($img);

?>