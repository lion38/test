<?php
session_start();
header ("Content-type: image/jpeg");
$image = imagecreatefromjpeg("images/captcha.jpg");

//géneration du code
$string='abcdefgh8jkm2n7p39rst4uv5x6wyz';
$a=$string[mt_rand(0,29)];
$b=$string[mt_rand(0,29)];
$c=$string[mt_rand(0,29)];
$d=$string[mt_rand(0,29)];
$e=$string[mt_rand(0,29)];
$f=$string[mt_rand(0,29)];
$string1=$a.$b.$c.$d.$e.$f;
$_SESSION['codesecurite'] = $string1;

// Texte :
$font = 'wp-content/themes/iconiac/fonts/';
$couleurTexte[0] = imagecolorallocate($image, 51, 21, 183);
$couleurTexte[1] = imagecolorallocate($image, 20, 87, 106);
$couleurTexte[2] = imagecolorallocate($image, 63, 133, 36);
$couleurTexte[3] = imagecolorallocate($image, 157, 39, 39);
$couleurTexte[4] = imagecolorallocate($image, 157, 39, 153);
$couleurTexte[5] = imagecolorallocate($image, 0, 0, 0);

$rotate[0] = rand(-10,10);
$rotate[1] = rand(-10,10);
$rotate[2] = rand(-10,10);
$rotate[3] = rand(-10,10);
$rotate[4] = rand(-10,10);
$rotate[5] = rand(-10,10);
$rand[0] = rand(0,5);
$rand[1] = rand(0,5);
$rand[2] = rand(0,5);
$rand[3] = rand(0,5);
$rand[4] = rand(0,5);
$rand[5] = rand(0,5);
$rand2[0] = rand(0,4);
$rand2[1] = rand(0,4);
$rand2[2] = rand(0,4);
$rand2[3] = rand(0,4);
$rand2[4] = rand(0,4);
$rand2[5] = rand(0,4);
imagettftext($image, 24, $rotate[0], 8, 34, $couleurTexte[$rand[0]], $font.$rand2[0].'.ttf', $a);
imagettftext($image, 24, $rotate[1], 42, 34, $couleurTexte[$rand[1]], $font.$rand2[1].'.ttf', $b);
imagettftext($image, 24, $rotate[2], 74, 34, $couleurTexte[$rand[2]], $font.$rand2[2].'.ttf', $c);
imagettftext($image, 24, $rotate[3], 106, 34, $couleurTexte[$rand[3]], $font.$rand2[3].'.ttf', $d);
imagettftext($image, 24, $rotate[4], 135, 34, $couleurTexte[$rand[4]], $font.$rand2[4].'.ttf', $e);
imagettftext($image, 24, $rotate[5], 170, 34, $couleurTexte[$rand[5]], $font.$rand2[5].'.ttf', $f);

imagejpeg($image);
?>
