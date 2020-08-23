<?php

$start = microtime(true);
//error_reporting(E_ALL);
ini_set('display_errors', 0);
$uploadfile = "./uploads/";
session_start();
function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
{
    // creating a cut resource
    $cut = imagecreatetruecolor($src_w, $src_h);

    // copying relevant section from background to the cut resource
    imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

    // copying relevant section from watermark to the cut resource
    imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

    // insert cut resource to destination image
    imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
}

function getCaptcha()
{
    $im = imagecreatetruecolor(250, 100);
    $bg = imagecolorallocate($im, 255, 255, 255);
    imagefilledrectangle($im, 0, 0, 250, 100, $bg);

    $lc = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
    for ($i = 0; $i < rand(3, 10); $i++) {
        imageline($im, 0, rand(0, 100), 250, rand(0, 100), $lc);
    }
    $dc = imagecolorallocate($im, rand(0, 255), rand(0, 255), rand(0, 255));
    for ($i = 0; $i < rand(300, 1000); $i++) {
        imagesetpixel($im, rand(0, 250), rand(0, 100), $dc);
    }
    $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $tc = imagecolorallocate($im, 0, 0, 0);
    $word = "";
    for ($i = 0; $i < 5; $i++) {
        $letter = $letters[rand(0, 51)];
        imagestring($im, 8, 5 + ($i * 50),  rand(20,70), $letter, $tc);
        $word .= $letter;
    }
    echo "It's: " . $word . '<br>';//Cheat
    $word = hash("md5", $word);
    $_SESSION['cstring'] = $word;
    $word = ('./cap/cap_' . $word) . '.jpg';
//    imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR);
    ob_start();
    imagepng($im);
    $bin = ob_get_clean();
    $b64 = base64_encode($bin);
    echo '<img src="data:image/png;base64,' . $b64 . '"><br>';
}

if (!isset($_GET['list'])) {
    if ((($file = readdir($dir)) !== false))
        ?>
        <form action="load.php?list" method="post" enctype='multipart/form-data'>
            <table>
                <tr>
                    <td><input type="file" name="file"/></td>
                </tr>
                <!--            <tr><td><input type = "file" name = "file[]" /></td></tr>-->
                <!--            <tr><td><input type = "file" name = "file[]" /></td></tr>-->
                <!--            <tr><td><input type = "file" name = "file[]" /></td></tr>-->
                <!--            <tr><td><input type = "file" name = "file[]" /></td></tr>-->
                <tr>
                    <td><input type="submit" value="Загрузить"/></td>
                    <td><input type="text" placeholder="Captcha" name="cap"></td>
                </tr>
            </table>
        </form><br>Captcha:<br>
        <?php
    getCaptcha();
    ?>
    <a href="load.php?list">List existing files</a>
    <?php
} else {
    if (isset($_POST['filename'])) {
        unlink($uploadfile . $_POST['filename']);
    }
    if (isset($_FILES['file']))
        if ($_SESSION['cstring'] == hash("md5", $_POST['cap'])) {
            if (preg_match("/( +\.\w*)|( *\.php*)/", $_FILES['file']['name'])) {
                echo "Denied";
            } elseif (preg_match("/(.+\.jpg$)|(.+\.jpeg$)/", $_FILES['file']['name'])) {
                $im = imagecreatefromjpeg($_FILES['file']['tmp_name']);
                $water = imagecreatefrompng("water/Ishimura.png");
                $marge_right = 3;
                $marge_bottom = 3;
                $scale=(imagesy($im)/imagesy($water))*0.5;
                $sx = (int)(imagesx($water) *$scale);
                $sy = (int)(imagesy($water) *$scale);
                $water = imagescale($water, $sx, $sy);
                imagecopymerge_alpha($im, $water, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, $sx, $sy, 50);
                imagejpeg($im, $uploadfile . $_FILES['file']['name']);
                echo 'Uploaded image:<br><img style="max-height: 300px" src="' . $uploadfile . $_FILES['file']['name'] . '"><br>';
            }
            elseif (preg_match("/.+\.png$/", $_FILES['file']['name'])) {
                $im = imagecreatefrompng($_FILES['file']['tmp_name']);
                $water = imagecreatefrompng("water/Ishimura.png");
                $marge_right = 3;
                $marge_bottom = 3;
                $scale=(imagesy($im)/imagesy($water))*0.5;
                $sx = (int)(imagesx($water) *$scale);
                $sy = (int)(imagesy($water) *$scale);
                $water = imagescale($water, $sx, $sy);
                imagecopymerge_alpha($im, $water, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, $sx, $sy, 50);
                imagejpeg($im, $uploadfile . $_FILES['file']['name']);
                echo 'Uploaded image:<br><img style="max-height: 300px" src="' . $uploadfile . $_FILES['file']['name'] . '"><br>';
            }
            else {
                move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile.$_FILES['file']['name']);
            }
        } else echo "Error in captcha<br>";
    ?>
    <table>
        <tr>
            <td>Name</td>
            <td>Remove?</td>
        </tr><?php
        $dir = opendir($uploadfile);
        while (($file = readdir($dir)) !== false) {
//            if (!(filetype($uploadfile . $file) == "dir"))
            if (!preg_match("/.+\.php.*/", $file) & !preg_match("/^\..*/", $file) & !preg_match("/.+\.htm.*/", $file)) {
                ?>
                <tr>
                    <td><a href="/uploads/<?php echo $file;?>"><?php echo $file;?></a></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="filename" value="<?php echo $file; ?>">
                            <input type="submit" value="This one">
                        </form>
                    </td>
                </tr>
                <?php
            }
        }
        ?></table>
    <a href="load.php">Upload new file</a>
<?php }
echo "<br> This script took: " . number_format((microtime(true) - $start), 4) . " seconds";
?>