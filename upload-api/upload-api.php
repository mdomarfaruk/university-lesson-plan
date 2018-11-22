<?php //

include("resize-class.php");
$fileindex = $_POST['fileindex'];
$filename = 'uploadfile';

if ($fileindex == 1)
{

    $uploaddir = '../uploads/';
    $uploaddir_thumb = '../uploads/thumb/';
} else if ($fileindex == 2)
{
    $uploaddir = '../uploads/';
    $uploaddir_thumb = '../uploads/thumb/';
}

//$randvalue = substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 25)), 0, 25);
$uploadfile = time() . $_FILES[$filename]['name'];

$image = $_FILES[$filename]['name'];
$image_type = $_FILES[$filename]['type'];
$uploaddir_desired = '../uploads/medium/';
if ($image != "")
{
    $w_h = getimagesize($_FILES[$filename]['tmp_name']);
    $o_width = $w_h[0];
    $o_height = $w_h[1];
    $thumbs_width = 55;
    $thumbs_height = 55;

    $desired_height = 300;
    $desired_width = 1200;

    if (move_uploaded_file($_FILES[$filename]['tmp_name'], $uploaddir . $uploadfile))
    {
        $resizeObj = new resize($uploaddir . $uploadfile);
        $resizeObj->resizeImage($desired_width, $desired_height, 'exact');
        $resizeObj->saveImage($uploaddir_desired . $uploadfile, 80);

        if ($fileindex == 1)
        {

            # $thumbs_height = $o_height*($thumbs_width/$o_width);

            $resizeObj = new resize($uploaddir . $uploadfile);
            $resizeObj->resizeImage($thumbs_width, $thumbs_height, 'exact');
            $resizeObj->saveImage($uploaddir_thumb . $uploadfile, 100);
        } else if ($fileindex == 2)
        {
            //$thumbs_width = 100;
            //$thumbs_height = $o_height*($thumbs_width/$o_width);

            $resizeObj = new resize($uploaddir . $uploadfile);
            $resizeObj->resizeImage($thumbs_width, $thumbs_height, 'exact');
            $resizeObj->saveImage($uploaddir_thumb . $uploadfile, 100);
        }
        echo basename($uploadfile);
    }
} else
{
    echo "error";
}
?>