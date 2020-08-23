<?php
header("Content-Type: image/png"); 

$image = imagecreatetruecolor(400, 400);

$scarlet = imagecolorallocate($image, 255, 36, 0); 
$white   = imagecolorallocate($image, 255, 255, 255); 
$black   = imagecolorallocate($image, 0, 0, 0);


imagefill($image, 0, 0, $white);

$font = "/home/nickserv/www/nickserv.mati.su/arial.ttf";
$time = time();
$angle = 1;
$txt = deg2rad(-$angle);
$rrr = ''.$txt;
$i = 0;
$time_mass = getdate($time);
$timem = $time_mass['hours'].':'.$time_mass['minutes'].':'.$time_mass['seconds'];
//imagettftext($image, 60, 0, 30, 90, $black, $font, $rrr);

imageellipse($image, 200, 200, 300, 300, $black);
imageellipse($image, 200, 200, 7, 7, $black);

if ($time_mass['hours']>11)
{
    $kk = $time_mass['hours']-12;
    if ($kk == 0)
    {
        $angle = 0;
    }        
    $angle = 30*($time_mass['hours']-12);
}
else
{
    $kk = $time_mass['hours'];
    if ($kk == 0)
    {
        $angle = 0;
    }        
    $angle = 30*($time_mass['hours']);
}

    $anglem = 6*($time_mass['minutes']);

    $angles = 6*($time_mass['seconds']);

//$angle = 60; 

$hx = 200 - (75*sin(deg2rad(-$angle)));
$hy = 200 - (75*cos(deg2rad(-$angle)));

$mx = 200 - (110*sin(deg2rad(-$anglem)));
$my = 200 - (110*cos(deg2rad(-$anglem)));

$sx = 200 - (145*sin(deg2rad(-$angles)));
$sy = 200 - (145*cos(deg2rad(-$angles)));

imageline($image, 200, 200, $hx, $hy, $black);//часовая стрелка
imageline($image, 200, 200, $mx, $my, $scarlet);//минутная стрелка
imageline($image, 200, 200, $sx, $sy, $black);//секундная стрелка

imagettftext($image, 20, 0, 187, 45, $black, $font, "12");
imagettftext($image, 20, 0, 355, 210, $black, $font, "3");
imagettftext($image, 20, 0, 193, 375, $black, $font, "6");
imagettftext($image, 20, 0, 30, 210, $black, $font, "9");

for ($i = 0; $i < 60; $i++)
{
    $angle = 6*$i;
    if ($angle == 0 || $angle == 90 || $angle == 180|| $angle == 270)
    {
        $ssx = 200 - (135*sin(deg2rad(-$angle)));
        $ssy = 200 - (135*cos(deg2rad(-$angle)));
        $hhx = 200 - (150*sin(deg2rad(-$angle)));
        $hhy = 200 - (150*cos(deg2rad(-$angle)));
    }
    else{
        $ssx = 200 - (145*sin(deg2rad(-$angle)));
        $ssy = 200 - (145*cos(deg2rad(-$angle)));
        $hhx = 200 - (150*sin(deg2rad(-$angle)));
        $hhy = 200 - (150*cos(deg2rad(-$angle)));
    }
    imageline($image, $ssx, $ssy, $hhx, $hhy, $black);//минутная стрелка
}

imagepng($image);
imagedestroy($image);
?>